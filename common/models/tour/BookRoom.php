<?php

/**
 * This is the model class for table "book_room".
 *
 * The followings are the available columns in table 'book_room':
 * @property string $id
 * @property string $checking_in
 * @property string $checking_out
 * @property string $room_id
 * @property integer $room_qty
 * @property integer $adults
 * @property integer $children
 * @property integer $age_children
 * @property integer $bed_type
 * @property integer $extra_bed
 * @property integer $sex
 * @property string $name
 * @property string $company
 * @property string $address
 * @property string $province_id
 * @property string $province_name
 * @property string $phone
 * @property string $email
 * @property integer $transfer_request
 * @property integer $arrival_time
 * @property integer $travel_time
 * @property string $message
 * @property integer $payment_methods
 * @property integer $status
 * @property string $site_id
 */
class BookRoom extends ActiveRecord {
    
    const TWIN_BEDS = 1; // giường đôi
    const SINGLE_BED = 2; // giường đơn

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'book_room';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('checking_in, checking_out, room_id, room_qty, adults, children, age_children, bed_type, name, phone, message', 'required'),
            array('room_qty, adults, children, age_children, bed_type, extra_bed, sex, transfer_request, arrival_time, travel_time, payment_methods, status', 'numerical', 'integerOnly' => true),
            array('checking_in, checking_out, room_id, site_id', 'length', 'max' => 10),
            array('name, company, address, province_name, email', 'length', 'max' => 255),
            array('phone', 'length', 'max' => 50),
            array('message', 'length', 'max' => 1000),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, checking_in, checking_out, room_id, room_qty, adults, children, age_children, bed_type, extra_bed, sex, name, company, address, province_id, province_name, phone, email, transfer_request, arrival_time, travel_time, message, payment_methods, status, site_id, created_time, modified_time', 'safe'),
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
            'checking_in' => Yii::t('book_room', 'checking_in'),
            'checking_out' => Yii::t('book_room', 'checking_out'),
            'room_id' => Yii::t('book_room', 'room_id'),
            'room_qty' => Yii::t('book_room', 'room_qty'),
            'adults' => Yii::t('book_room', 'adults'),
            'children' => Yii::t('book_room', 'children'),
            'age_children' => Yii::t('book_room', 'age_children'),
            'bed_type' => Yii::t('book_room', 'bed_type'),
            'extra_bed' => Yii::t('book_room', 'extra_bed'),
            'sex' => Yii::t('book_room', 'sex'),
            'name' => Yii::t('book_room', 'name'),
            'company' => Yii::t('book_room', 'company'),
            'address' => Yii::t('book_room', 'address'),
            'province_id' => Yii::t('book_room', 'province'),
            'phone' => Yii::t('book_room', 'phone'),
            'email' => Yii::t('book_room', 'email'),
            'transfer_request' => Yii::t('book_room', 'transfer_request'),
            'arrival_time' => Yii::t('book_room', 'arrival_time'),
            'travel_time' => Yii::t('book_room', 'travel_time'),
            'message' => Yii::t('book_room', 'message'),
            'payment_methods' => Yii::t('book_room', 'payment_methods'),
            'status' => 'Status',
            'site_id' => 'Site',
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
        $criteria->compare('checking_in', $this->checking_in, true);
        $criteria->compare('checking_out', $this->checking_out, true);
        $criteria->compare('room_id', $this->room_id, true);
        $criteria->compare('room_qty', $this->room_qty);
        $criteria->compare('adults', $this->adults);
        $criteria->compare('children', $this->children);
        $criteria->compare('age_children', $this->age_children);
        $criteria->compare('bed_type', $this->bed_type);
        $criteria->compare('extra_bed', $this->extra_bed);
        $criteria->compare('sex', $this->sex);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('company', $this->company, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('province_id', $this->province_id, true);
        $criteria->compare('province_name', $this->province_name, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('transfer_request', $this->transfer_request);
        $criteria->compare('arrival_time', $this->arrival_time);
        $criteria->compare('travel_time', $this->travel_time);
        $criteria->compare('message', $this->message, true);
        $criteria->compare('payment_methods', $this->payment_methods);
        $criteria->compare('status', $this->status);
        //
        $this->site_id = Yii::app()->controller->site_id;
        //
        $criteria->compare('site_id', $this->site_id, true);
        //
        $criteria->order = 'id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BookRoom the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function arrSex() {
        return array(
            1 => 'Ông',
            2 => 'Bà'
        );
    }
    
    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->modified_time = $this->created_time = time();
        } else {
            $this->modified_time = time();
        }
        //
        return parent::beforeSave();
    }

}
