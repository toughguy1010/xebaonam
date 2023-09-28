<?php

/**
 * This is the model class for table "user_investor_info".
 *
 * The followings are the available columns in table 'user_investor_info':
 * @property integer $user_id
 * @property integer $site_id
 * @property integer $user_video
 */
class UsersInvestorInfo extends ActiveRecord
{
    public $archive;
    public $yesno;
    public $region;
    public $industrie;
    public $moneyInvest;
    public $howDoYouWantToJoin;
    public $timeSlot;

    public function __construct($scenario = 'insert')
    {
        if ($scenario === null) // internally used by populateRecord() and model()
            return;

        $this->setScenario($scenario);
        $this->setIsNewRecord(true);
        $this->_attributes = $this->getMetaData()->attributeDefaults;

        $this->init();

        $this->attachBehaviors($this->behaviors());
        $this->afterConstruct();

        self::setMoneyInvest();
        self::set_do_you_want_to_join();
        self::setYesNo();
        self::setRegion();
        self::setIndustriesPreferToInvest();
        self::setTimeSlotParticipate();
        self::setMoneyInvest();
        self::setArchiveYouWant();
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'user_investor_info';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('info_qt1, info_qt2, info_qt3, info_qt4, pref_1, pref_2, pref_3, pref_4, pref_5, pref_7', 'required', 'message' => 'Vui lòng chọn'),
            array('user_id, user_pdf, user_video, site_id, site_id, company_name, address, phone, owner_company, info_qt1,
            info_qt2, info_qt3, info_qt4, pref_1, pref_2, pref_3, pref_4, pref_5, pref_6, pref_7', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'user_id' => Yii::t('user', 'id'),
            'user_pdf' => Yii::t('user', 'user_pdf'),
            'user_video' => Yii::t('user', 'user_video'),
            'user_bio' => Yii::t('user', 'user_bio'),
            'user_quotes' => Yii::t('user', 'user_quotes'),
            'site_id' => Yii::t('user', 'site_id'),
            'company_name' => '2.1 Tên Công ty (Company name)',
            'address' => '2.2 Địa chỉ( Address)',
            'phone' => '2.3 Số điện thoại (Phone number)',
            'owner_company' => '2.4 Bạn có phải là chủ sở hữu công ty ? (Are you the owner of this company?)',
            'info_qt1' => '3.1. Bạn đã từng tham gia mạng lưới/ nhóm nhà đầu tư thiên thần chưa? (Are you a member of any network/ club of angel investors?)',
            'info_qt2' => '3.2. Bạn đã từng đầu tư cho doanh nghiệp khởi nghiệp? (Have you ever invested in a startup?)',
            'info_qt3' => '3.3. Bạn có muốn tham gia khóa đào tạo về đầu tư mạo hiểm? (Are you interested in joining the training course on angel investment?)',
            'info_qt4' => '3.4. Bạn muốn tham gia iAngel như thế nào? (How do you want to join iAngel?)',
            'pref_1' => '4.1.Bạn quan tâm đầu tư vào ngành nghề nào? (What industries do you prefer to invest in?)',
            'pref_2' => '4.2 Số tiền bạn có thể đầu tư? (How much are you willing to invest?)',
            'pref_3' => '4.3 Khu vực bạn muốn đầu tư? (What region do you prefer to invest in?)',
            'pref_4' => '4.4 Bạn muốn đạt được gì khi tham gia vào mạng lưới nhà đầu tư thiên thần – iAngel? (What do you want to archive after joining iAngel?)',
            'pref_5' => '4.5 Thời gian nào phù hợp với bạn để tham gia các buổi đào tạo của iAngel? (Which time slot is best for you to participate in our trainings and workshops?)',
            'pref_6' => '4.6 Bạn muốn đóng góp ý tưởng cho iAngel? (Do you have any suggestions for iAngel?)',
            'pref_7' => '4.7 Bạn có đồng ý chia sẻ thông tin của bạn với các thành viên khác? (Do you agree let iAngel share your information with other members?)',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $this->site_id = Yii::app()->controller->site_id;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Users the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function set_company_information()
    {
        return array();

    }

    /**
     * setHowDoYouWantToJoin
     */
    public function setYesNo()
    {

        $this->yesno = array(
            1 => 'Có/Yes',
            0 => 'Không/No'
        );
    }

    public function set_do_you_want_to_join()
    {
        $this->howDoYouWantToJoin = array(
            0 => 'Là thành viên của mạng lưới/ As a member of the network',
            1 => 'Là diễn giả chia sẻ về đầu tư thiên thần / As a speaker at iAngel events',
            2 => '2 phương án trên/ The above two');
    }

    public function setIndustriesPreferToInvest()
    {
        $this->industrie = array(
            0 => 'Nông nghiệp/ Agriculture',
            1 => 'Nhiên liệu sinh học/ Biofuels',
            2 => 'Ô tô/ Automotive',
            3 => 'Sản xuất điện/ Energy generation',
            4 => 'Xây dựng hệ sinh thái/ Built environment',
            5 => 'Sử dụng năng lượng/tài nguyên hiệu quả/ Energy/resource efficiency',
            6 => 'Biển /Marine',
            7 => 'Nước/ Water',
            8 => 'Mạng lưới thông minh / Smart grid',
            9 => 'Các ứng dụng di động / Mobile applications',
            10 => 'Chất thải/ Waste',
            11 => 'Phần cứng/ Hardware',
            12 => 'Chất bán dẫn/Semiconductor',
            13 => 'Phần mềm/ Software',
            14 => 'Khác/Others');
    }

    public function setMoneyInvest()
    {
        $this->moneyInvest = array(
            0 => '1,000 – 2,000 USD',
            1 => '2,000 – 3,000 USD',
            2 => '3,000 – 5,000 USD',
            3 => '5,000 – 10,000 USD',
            14 => 'Khác/Others'
        );
    }

    public function setRegion()
    {
        $this->region = array(
            0 => 'Bắc/North',
            1 => 'Trung/Central',
            2 => 'Nam/ South'
        );
    }

    public function setArchiveYouWant()
    {
        $this->archive = array(
            0 => 'Hoàn thiện kiến thức đầu tư mạo hiểm/ To perfect knowledge of venture capital',
            1 => 'Chia sẻ kinh nghiệm và ý tưởng/ Share experiences and exchange ideas',
            2 => 'Kết nối các nhà đầu tư khác và các Start – up tiềm năng nhất/ Connect with angel investors and potential Start – ups',
            3 => 'Nhận chứng nhận hoàn thành khóa đào tạo cho nhà đầu tư thiên thần đầu tiên ở Việt Nam/ Get complete certification training courses for the first angel investment in Vietnam',
            4 => 'Mang đến cơ hội xúc tiến thương vụ thành công/ Provide opportunities to promote business success',
            5 => 'Khác/Others'
        );
    }

    public function setTimeSlotParticipate()
    {
        $this->timeSlot = array(
            0 => 'Trong giờ hành chính/ During office hours',
            1 => 'Ngoài giờ hành chính/ After office hours',
            2 => 'Cuối tuần/ Weekend'
        );
    }

}
