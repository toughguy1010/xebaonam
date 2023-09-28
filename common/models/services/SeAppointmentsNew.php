<?php

/**
 * This is the model class for table "se_appointments_new".
 *
 * The followings are the available columns in table 'se_appointments_new':
 * @property string $id
 * @property string $name
 * @property integer $dob
 * @property integer $profile_number
 * @property string $email
 * @property string $phone
 * @property integer $time_appointment
 * @property integer $date_appointment
 * @property integer $service_id
 * @property integer $provider_id
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $site_id
 * @property integer $status
 * @property integer $store_id
 * @property string $description
 * @property string $provider_name
 */
class SeAppointmentsNew extends ActiveRecord {

    const MON_AM = 1; // sáng thứ 2
    const MON_PM = 2; // chiều thứ 2
    const TUE_AM = 3; // sáng thứ 3
    const TUE_PM = 4; // chiều thứ 3
    const WED_AM = 5; // sáng thứ 4
    const WED_PM = 6; // chiều thứ 4
    const THU_AM = 7; // sáng thứ 5
    const THU_PM = 8; // chiều thứ 5
    const FRI_AM = 9; // sáng thứ 6
    const FRI_PM = 10; // chiều thứ 6
    const SAT_AM = 11; // sáng thứ 7
    const SAT_PM = 12; // chiều thứ 7

    const STATUS_ACTIVED = 1;
    const STATUS_PENDING = 0;
    const STATUS_COMPLETE = 3;
    const STATUS_PROCCESSING = 4;
    const STATUS_CANCEL = 20;
    
    public $captcha;

        /**
     * @return string the associated database table name
     */

    public function tableName() {
        return $this->getTableName('se_appointments_new');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, phone, time_appointment, date_appointment', 'required'),
            array('captcha', 'required', 'on' => 'frontend'),
            array('captcha', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements(), 'on' => 'frontend'),
            array('site_id, provider_id, service_id, created_time, modified_time, time_appointment', 'length', 'max' => 11),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, profile_number, email, phone, time_appointment, date_appointment, service_id, provider_id, created_time, modified_time, site_id, status, store_id, provider_name, description', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Họ và tên',
            'dob' => 'Ngày sinh',
            'email' => 'Email',
            'phone' => 'Điện thoại',
            'profile_number' => 'Số hồ sơ (nếu có)',
            'time_appointment' => 'Thời gian khám',
            'date_appointment' => 'Ngày khám',
            'provider_id' => 'Tên bác sĩ',
            'service_id' => 'Chương trình hoặc chuyên khoa',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'site_id' => 'Site',
            'status' => 'Trạng thái',
            'store_id' => 'Địa điểm khám',
            'provider_name' => 'Yêu cầu bác sĩ (học vị, chức vụ..)',
            'description' => 'Nội dung khám bệnh',
            'captcha' => 'Mã xác thực'
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search($options = array()) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        if (!$this->site_id) {
            $this->site_id = Yii::app()->controller->site_id;
        }
        $criteria->compare('id', $this->id, true);
        $criteria->compare('site_id', $this->site_id, true);
        $criteria->compare('provider_id', $this->provider_id, true);
        $criteria->compare('service_id', $this->service_id, true);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('modified_time', $this->modified_time, true);
        $criteria->compare('status', $this->status);
        $criteria->order = 'created_time DESC';
        //
        $dataprovider = new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                'pageVar' => ClaSite::PAGE_VAR,
            ),
        ));
        //
        return $dataprovider;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SeAppointmentsNew the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        if (!$this->site_id) {
            $this->site_id = Yii::app()->controller->site_id;
        }
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->modified_time = $this->created_time;
        } else {
            $this->modified_time = time();
        }
        return parent::beforeSave();
    }

    public static function timeAppointmentArr() {
        return [
            self::MON_AM => 'Sáng thứ 2',
            self::MON_PM => 'Chiều thứ 2',
            self::TUE_AM => 'Sáng thứ 3',
            self::TUE_PM => 'Chiều thứ 3',
            self::WED_AM => 'Sáng thứ 4',
            self::WED_PM => 'Chiều thứ 4',
            self::THU_AM => 'Sáng thứ 5',
            self::THU_PM => 'Chiều thứ 5',
            self::FRI_AM => 'Sáng thứ 6',
            self::FRI_PM => 'Chiều thứ 6',
            self::SAT_AM => 'Sáng thứ 7',
            self::SAT_PM => 'Chiều thứ 7',
        ];
    }
    
    /**
     * get status arr
     * @return type
     */
    static function appointmentStatus() {
        return array(
            self::STATUS_ACTIVED => 'Chấp nhận',
            self::STATUS_COMPLETE => 'Hoàn thành',
            self::STATUS_PROCCESSING => 'Đang xử lý',
            self::STATUS_PENDING => 'Chờ xử lý',
            self::STATUS_CANCEL => 'Hủy',
        );
    }
    
    /**
     * get status color
     * @return type
     */
    static function appointmentStatusColor() {
        return array(
            self::STATUS_ACTIVED => '#2a8bcc',
            self::STATUS_COMPLETE => '#6c9842',
            self::STATUS_PROCCESSING => '#fe9e19',
            self::STATUS_PENDING => '#7b68af',
            self::STATUS_CANCEL => '#b52c26',
        );
    }

}
