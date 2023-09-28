<?php

/**
 * This is the model class for table "car_register_service".
 *
 * The followings are the available columns in table 'car_register_service':
 * @property string $id
 * @property string $services
 * @property integer $date_coming
 * @property string $time_coming
 * @property string $place
 * @property string $employee
 * @property integer $customer_label
 * @property string $customer_first_name
 * @property string $customer_last_name
 * @property string $customer_email
 * @property string $customer_phone
 * @property string $customer_note
 * @property integer $car_category_id
 * @property integer $car_id
 * @property string $license_plate
 * @property string $year_produce
 * @property integer $status
 * @property integer $site_id
 * @property integer $created_time
 * @property integer $key
 */
class CarRegisterService extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'car_register_service';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('services, date_coming, time_coming, customer_name, customer_phone, license_plate', 'required'),
            array('date_coming, status, site_id, created_time', 'numerical', 'integerOnly' => true),
            array('services, time_coming, customer_name, customer_email, customer_phone, license_plate, year_produce, key', 'length', 'max' => 255),
            array('customer_note', 'length', 'max' => 1000),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, services, date_coming, time_coming, customer_email, customer_phone, customer_note, car_category_id, car_id, license_plate, year_produce, status, site_id, created_time, key', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'services' => 'Dịch vụ',
            'date_coming' => 'Ngày dự kiến',
            'time_coming' => 'Thời gian dự kiến',
            // 'place' => 'Địa điểm',
            // 'employee' => 'Nhân viên phục vụ',
            // 'customer_label' => 'Danh xưng',
            // 'customer_first_name' => 'Họ',
            'customer_name' => 'Họ tên',
            'customer_email' => 'Email',
            'customer_phone' => 'Số điện thoại',
            'customer_note' => 'Yêu cầu sửa chữa',
            'car_category_id' => 'Mẫu xe',
            'car_id' => 'Phiên bản',
            'license_plate' => 'Biển số xe',
            'year_produce' => 'Năm sản xuất',
            'status' => 'Trạng thái',
            'site_id' => 'Site',
            'created_time' => 'Ngày yêu cầu',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('services', $this->services, true);
        $criteria->compare('date_coming', $this->date_coming);
        $criteria->compare('time_coming', $this->time_coming, true);
        // $criteria->compare('place', $this->place, true);
        // $criteria->compare('employee', $this->employee, true);
        // $criteria->compare('customer_label', $this->customer_label);
        // $criteria->compare('customer_first_name', $this->customer_first_name, true);
        $criteria->compare('customer_name', $this->customer_name, true);
        $criteria->compare('customer_email', $this->customer_email, true);
        $criteria->compare('customer_phone', $this->customer_phone, true);
        $criteria->compare('customer_note', $this->customer_note, true);
//        $criteria->compare('car_category_id', $this->car_category_id);
//        $criteria->compare('car_id', $this->car_id);
        $criteria->compare('license_plate', $this->license_plate, true);
        $criteria->compare('year_produce', $this->year_produce, true);
//        $criteria->compare('status', $this->status);
        $criteria->compare('site_id', $this->site_id);
//        $criteria->compare('created_time', $this->created_time);

        $criteria->order = 'created_time DESC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                'pageVar' => ClaSite::PAGE_VAR,
            )
        ));
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
        }
        //
        return parent::beforeSave();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CarRegisterService the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    // public static function optionsLabel() {
    //     return [
    //         1 => 'Ông',
    //         2 => 'Bà',
    //         3 => 'Anh',
    //         4 => 'Chị',
    //     ];
    // }

    // public static function getNameLabel($label) {
    //     $data = self::optionsLabel();
    //     return isset($data[$label]) ? $data[$label] : '';
    // }

    public static function optionsTime() {
        return [
            1 => '08:00',
            2 => '09:00',
            3 => '10:00',
            4 => '11:00',
            5 => '13:00',
            6 => '14:00',
            7 => '15:00',
            8 => '16:00',
            9 => '17:00',
        ];
    }

    public static function getNameTime($time) {
        $data = self::optionsTime();
        return isset($data[$time]) ? $data[$time] : '';
    }

}
