<?php

/**
 * This is the model class for table "car_form".
 *
 * The followings are the available columns in table 'car_form':
 * @property string $id
 * @property string $title
 * @property string $user_name
 * @property integer $car_id
 * @property string $address
 * @property string $phone
 * @property string $email
 * @property integer $time
 * @property string $content
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $type
 * @property integer $site_id
 */
class CarForm extends ActiveRecord {
    
    const SCHEDULE_REPAIR = 1; // Đặt lịch hẹn sửa chữa
    const REGISTER_RECEIVE_NEWS = 2; // Đăng ký nhận tin
    const CUSTOMER_IDEA = 3; // Ý kiến khách hàng
    const TRY_DRIVE_CAR = 4; // Đăng ký lái thử xe

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('car_form');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_name, email, phone', 'required'),
            array('car_id, created_time, modified_time, type, site_id', 'numerical', 'integerOnly' => true),
            array('title, user_name, address, email', 'length', 'max' => 255),
            array('phone', 'length', 'max' => 20),
            array('content', 'length', 'max' => 1020),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, title, user_name, car_id, address, phone, email, time, content, created_time, modified_time, type, site_id', 'safe', 'on' => 'search'),
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
            'title' => Yii::t('car', 'title'),
            'user_name' => Yii::t('car', 'user_name'),
            'car_id' => Yii::t('car', 'model'),
            'address' => Yii::t('common', 'address'),
            'phone' => Yii::t('common', 'phone'),
            'email' => Yii::t('common', 'email'),
            'time' => Yii::t('car', 'time'),
            'content' => Yii::t('car', 'content'),
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'type' => 'Type',
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
        $criteria->compare('title', $this->title, true);
        $criteria->compare('user_name', $this->user_name, true);
        $criteria->compare('car_id', $this->car_id);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('time', $this->time);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('type', $this->type);
        $criteria->compare('site_id', $this->site_id);
        
        $criteria->order = 'id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CarForm the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
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
