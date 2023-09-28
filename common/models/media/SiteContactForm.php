<?php

/**
 * This is the model class for table "print_picture".
 *
 * The followings are the available columns in table 'print_picture':
 * @property string $id
 * @property string $site_id
 * @property string $name
 * @property string $phone
 * @property string $address
 * @property string $email
 * @property string $image_src
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $payment_method
 * @property integer $transport_method
 * @property integer $status
 * @property integer $payment_status
 */
class SiteContactForm extends ActiveRecord {
    
    public $avatar;


    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('contact_form');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('created_time, modified_time, payment_method, transport_method, status, payment_status', 'numerical', 'integerOnly' => true),
            array('site_id', 'length', 'max' => 11),
            array('name, address, email, image_src', 'length', 'max' => 255),
            array('phone', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, site_id, name, phone, address, email, image_src, created_time, modified_time, payment_method, transport_method, status, payment_status, note, avatar', 'safe'),
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
            'site_id' => 'Site',
            'name' => Yii::t('user', 'name'),
            'phone' => Yii::t('common', 'phone'),
            'address' => Yii::t('common', 'address'),
            'email' => Yii::t('common', 'email'),
            'image_src' => 'Image Path',
            'created_time' => Yii::t('common', 'created_time'),
            'modified_time' => 'Modified Time',
            'payment_method' => Yii::t('shoppingcart', 'payment_method'),
            'transport_method' => Yii::t('shoppingcart', 'transport_method'),
            'status' => Yii::t('common', 'status'),
            'payment_status' => Yii::t('shoppingcart', 'payment_status'),
            'note' => Yii::t('file', 'note'),
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
        $criteria->compare('site_id', $this->site_id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('image_src', $this->image_src, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('payment_method', $this->payment_method);
        $criteria->compare('transport_method', $this->transport_method);
        $criteria->compare('status', $this->status);
        $criteria->compare('payment_status', $this->payment_status);
        $criteria->compare('note', $this->note, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PrintPicture the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    static function allowExtensions() {
        return array(
            'image/jpeg' => 'image/jpeg',
            'image/gif' => 'image/gif',
            'image/png' => 'image/png',
            'image/bmp' => 'image/bmp',
            'application/x-shockwave-flash' => 'application/x-shockwave-flash',
        );
    }
    
    function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
        }
        return parent::beforeSave();
    }

}
