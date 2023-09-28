<?php

/**
 * This is the model class for table "contacts".
 *
 * The followings are the available columns in table 'contacts':
 * @property integer $contact_id
 * @property integer $site_id
 * @property string $contact_name
 * @property string $contact_email
 * @property string $contact_phone
 * @property string $contact_enquiry
 * @property integer $created_time
 * @property string $contact_subject
 * 
 */
class Contacts extends CActiveRecord {

    public $verifyCode;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return ClaTable::getTable('contacts');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('contact_name, contact_email, contact_phone, contact_subject, contact_enquiry', 'required'),
            array('created_time', 'numerical', 'integerOnly' => true),
            array('contact_name,contact_subject', 'length', 'max' => 255),
            array('contact_email', 'email'),
            array('contact_phone', 'length', 'max' => 20),
            array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements()),
            array('contact_name, contact_email, contact_phone, contact_enquiry, created_time,contact_subject', 'safe'),
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
            'contact_id' => 'ID',
            'contact_name' => Yii::t('contact','contact_name'),
            'contact_email' => Yii::t('contact','contact_email'),
            'contact_phone' => Yii::t('contact','contact_phone'),
            'contact_subject' => Yii::t('contact','contact_subject'),
            'contact_enquiry' => Yii::t('contact','contact_enquiry'),
            'created_time' => Yii::t('contact','created_time'),
            'verifyCode' => Yii::t('contact','verifyCode'),
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

        $criteria->compare('contact_id', $this->contact_id);
        $criteria->compare('contact_name', $this->contact_name, true);
        $criteria->compare('contact_email', $this->contact_email, true);
        $criteria->compare('contact_phone', $this->contact_phone, true);
        $criteria->compare('contact_enquiry', $this->contact_enquiry, true);
        $criteria->compare('created_time', $this->created_time);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Contacts the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    function beforeSave() {
        if($this->isNewRecord){
            $this->created_time = time();
        }
        return parent::beforeSave();
    }

}
