<?php

/**
 * This is the model class for table "order_rent_simple".
 *
 * The followings are the available columns in table 'order_rent_simple':
 * @property string $id
 * @property integer $product_id
 * @property integer $date_rent
 * @property integer $region
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $status
 */
class OrderRentSimple extends ActiveRecord {

    const REGION_HN = 1; // Hà nội
    const REGION_HCM = 2; // Hồ chí minh
    const REGION_OTHER = 3; // Khác

    /**
     * @return string the associated database table name
     */

    public function tableName() {
        return 'order_rent_simple';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, phone, region', 'required'),
            array('product_id, created_time, modified_time, destination_id, site_id, status, region', 'numerical', 'integerOnly' => true),
            array('name, phone, email, date_rent', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, product_id, date_rent, name, phone, email, created_time, modified_time, status, region', 'safe', 'on' => 'search'),
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
            'destination_id' => 'Khu vực',
            'product_id' => 'Nước đi',
            'date_rent' => 'Ngày đi',
            'name' => 'Họ và tên',
            'phone' => 'Số điện thoại',
            'email' => 'Email',
            'created_time' => 'Thời gian tạo',
            'modified_time' => 'Thời gian sửa',
            'status' => 'Trạng thái',
            'region' => 'Nơi bạn công tác'
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
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('date_rent', $this->date_rent);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);

        $criteria->order = 'id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return OrderRentSimple the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        $this->created_time = time();
        $this->modified_time = time();
        $this->site_id = Yii::app()->controller->site_id;
        return parent::beforeSave();
    }

    public static function optionsStatus() {
        return [
            1 => 'Chờ liên hệ',
            2 => 'Đã tư vấn',
            3 => 'Hoàn thành',
            4 => 'Hủy'
        ];
    }

    public static function optionsRegion() {
        return [
            self::REGION_HN => 'Hà nội',
            self::REGION_HCM => 'Hồ chí minh',
            self::REGION_OTHER => 'Khác'
        ];
    }

    public static function getNameRegion($region) {
        $data = self::optionsRegion();
        return isset($data[$region]) ? $data[$region] : '';
    }

    public static function getNameStatus($status) {
        $data = self::optionsStatus();
        return (isset($data[$status]) && $data[$status]) ? $data[$status] : '';
    }

}
