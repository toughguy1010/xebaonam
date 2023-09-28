<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'UsersCompanyInfo':
 * @property integer $user_id
 * @property integer $site_id
 */
class UsersCompanyInfo extends ActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'user_company_info';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id', 'required', 'on' => 'signup'),
            array('user_id, user_pdf, user_video, site_id, company_project_name, contact_name, phone_email_website, time_working, industry, product_type, member, stage_of_development,proj_qt1,proj_qt2,proj_qt3,proj_qt4,proj_qt5,proj_qt6,proj_qt7,proj_qt8_1,proj_qt8_2,proj_qt8_3,proj_qt8_4,proj_qt8_5,proj_qt9,proj_qt10,proj_qt11,proj_qt12', 'safe'),
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
            'company_project_name' => '1.1 Tên công ty/ Dự án <span style="color: #333">( Company/Project name )</span>',
            'contact_name' => '1.2 Tên người liên lạc <span style="color: #333">( Contact name )</span>',
            'phone_email_website' => '1.3 Phone number/Email/Website:',
            'time_working' => '1.4 Thời gian thực hiện khởi nghiệp/ thực hiện dự án? <span style="color: #333">( How long have you been working on this start-up/ project? )</span>',
            'industry' => '1.5 Ngành nghề <span style="color: #333"> (Industry?)</span>:',
            'product_type' => '1.6 Loại sản phẩm <span style="color: #333">(Product type)</span>',
            'member' => '1.7 Thành viên: Liệu kê các thành viên và kinh nghiệm làm việc của các thành viên <br><span style="color: #333">( Who are the members of your management team and how will their experience aid in your success?)</span>',
            'stage_of_development' => '1.8 Giai đoạn thực hiện khởi nghiệp <br><span style="color: #333"> ( Stage of development)</span>',
            'proj_qt1' => '2.1 Mô tả sản phẩm hoặc dịch vụ. Liệt kê giá trị chính /sự độc đáo / khác biệt / thú vị / mới về sản phẩm? <br><span style="color: #333">Describe the product or service. Listing the main value proposition/ unique/different/interesting/new about it?</span>',
            'proj_qt2' => '2.2 Thị trường muc tiêu của sản phẩm (đặc điểm địa lý, nhân khẩu học, và / hoặc tâm lý tiêu dùng, hành vi tiêu dùng) <br><span style="color: #333"> What is your target market (important geographic, demographic, and/or psychographic characteristics of the market</span>',
            'proj_qt3' => '2.3 Làm thế nào để khách hàng biết đến bạn? ( khách hàng của bạn đang gặp phải khó khăn gì và sản phẩm . dịch vụ của bạn giải quyết được vấn đề gì ? Phương thức để bạn có được kết quả đó ?) <br><span style="color: #333"> How do you know people need what you are making? (what key problems are they facing, and how does your product/service solve their problem? What test have you ran to validate it?)</span>',
            'proj_qt4' => '2.4 Liệt kê các đối thủ cạnh tranh trực tiếp của bạn, điểm mạnh và điểm yếu của họ. Nếu đối thủ cạnh tranh trực tiếp không tồn tại, mô tả các lựa chọn thay thế hiện có <br><span style="color: #333"> Please name of your direct competitors, their strengths and weaknesses. If direct competitors don’t exist, describe the existing alternatives</span>',
            'proj_qt5' => '2.5 Lợi thế cạnh tranh của công ty bạn là gì?<br><span style="color: #333"> What is your company’s competitive or advantage?</span>',
            'proj_qt6' => '2.6 Kế hoạch quảng bá, xây dựng và tiếp cận khách hàng cho các sản phẩm và dịch vụ của bạn. Làm thế nào để bạn tìm thấy các khách hàng? <br><span style="color: #333"> Detail how you will promote, sell and create customer for your products and services. How do you find customers?</span>',
            'proj_qt7' => '2.7 Chiến lược sẽ sử dụng để xây dựng, cung cấp, và duy trì giá trị công ty (ví dụ, lợi nhuận)? mô hình tăng trưởng <br><span style="color: #333"> What strategy will you employ to build, deliver, and retain company value (e.g., profits)? Growth model </span>',
            'proj_qt8_1' => '2.8.1 Nếu bạn đã tung ra sản phẩm / dịch vụ, số lượng khách hàng bạn có là bao nhiêu? <br><span style="color: #333">If you have launched your product/service, how many customers do you have?</span>',
            'proj_qt8_2' => '2.8.2 Nếu bạn đã bán sản phẩm, doanh thu đã có tháng qua là bao nhiêu? <br><span style="color: #333">If you have paid customers, how much revenue has your startup had last month? (in terms of USD)<span>. ',
            'proj_qt8_3' => '2.8.3 Doanh thu của bạn đã có trong năm qua?  <br><span style="color: #333">How much revenue has your startup had last year? (in terms of USD)</span> ',
            'proj_qt8_4' => '2.8.4  Doanh thu mong đợi vào năm 2017 <br><span style="color: #333">Expected Revenue in 2017 (in USD)</span>',
            'proj_qt8_5' => '2.8.5 Bạn sẽ làm gì cụ thể trong giai đoạn tiếp theo để tăng phân khúc khách hàng và lợi nhuận?<br><span style="color: #333"> What would you do specific in next stage of start up, to increase you customer segment and profit?</span> ',
            'proj_qt9' => '2.9 Nguồn vốn bạn tự có là bao nhiêu. Có gây vốn từ bên ngoài ? Bao nhiêu? Từ ai? Khi nào? <br><span style="color: #333"> Have you already raised any private capital? How much? From whom? When?',
            'proj_qt10' => '2.10 Bạn muốn gì  từ các nhà đầu tư. Nêu những mong muốn về nguồn lực, hỗ trợ mà bạn cần từ các nhà đầu tư <br><span style="color: #333"> What you want from the investors. Tell us what resources and assistance you\'d like to get from an investor </span>',
            'proj_qt11' => '2.11 Số tiền đầu tư mà bạn mong muốn (USD)? <br><span style="color: #333"> How much fund (in USD) are you planning to raise?</span>',
            'proj_qt12' => '2.12 Bạn có thể đưa ra những đề nghị gì để đổi lấy một khoản đầu tư từ nhà đầu tư thiên thần ?<br><span style="color: #333"> What you want to offer in exchange for an investment . Tell us what you are willing to give to the investors in exchange for their participation in your project ?</span>',
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

    public static function time_working()
    {
        return array(
            0 => 'Less than 6 months/ Ít hơn 6 tháng',
            1 => '6-12 months/ 6-12 tháng',
            2 => '12-24 months/ 12-24 tháng',
            3 => 'More than 2 years/ Hơn 2 năm');
    }

    /**
     * @return array
     */
    public static function industry()
    {
        return array(
            0 => 'Khác',
            1 => 'Nông nghiệp/ Agriculture',
            2 => 'Ô tô/ Automotive',
            3 => 'Nhiên liệu sinh học/ Biofuels',
            4 => 'Chất thải/ Waste',
            5 => 'Sản xuất điện/ Energy generation',
            6 => 'Internet',
            7 => 'Sử dụng năng lượng/tài nguyên hiệu quả/ Energy/resource efficiency',
            8 => 'Phần cứng/ Hardware',
            9 => 'Năng lượng lưu trữ/ Energy storage',
            10 => 'Biển /Marine',
            11 => 'Mạng lưới thông minh/ Smart grid',
            12 => 'Chất bán dẫn/ Semiconductor',
            13 => 'Xây dựng hệ sinh thái/ Built environment',
            14 => 'Phần mềm/ Software',
            15 => 'Các ứng dụng di động/ Mobile applications',
            16 => 'Nước/ Water');
    }

    /**
     * @return array
     */
    public static function product_type()
    {
        return array(
            0 => 'Khác',
            1 => 'Service/ Dịch vụ',
            2 => 'Physical products (hardware)',
            3 => 'Software/ Phần mềm',
            4 => 'Physical products (none hardware)');
    }

    /**
     * @return array
     */
    public static function stage_of_development()
    {
        return array(
            0 => 'Concept/ Idea /Ý tưởng',
            1 => 'Customer development/ Phát triển khách hàng',
            2 => 'Building technology/ Xây dựng công nghệ',
            3 => 'Demo product/ Tạo sản phẩm mẫu',
            4 => 'Growth/ Phát triển',
            5 => 'Scaling Sales/ Mở rộng quy mô kinh doanh',
            6 => 'Launched/ Phát hành sản phẩm');
    }

}
