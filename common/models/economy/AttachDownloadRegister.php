<?php

/**
 * This is the model class for table "contacts".
 *
 * The followings are the available columns in table 'contacts':
 * @property integer $id
 * @property integer $site_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $format
 * @property integer $created_time
 * @property string $notice
 * 
 */
class AttachDownloadRegister extends ActiveRecord {

    public $verifyCode;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return ClaTable::getTable('attach_download_register');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, email, phone, format, kindle_email', 'required'),
            array('created_time', 'numerical', 'integerOnly' => true),
            array('name,notice', 'length', 'max' => 255),
            array('email, kindle_email', 'email'),
            array('phone', 'length', 'max' => 20),
            array('name, email, phone, format, created_time,notice, kindle_email', 'safe'),
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
            'name' => 'Họ và Tên',
            'email' => Yii::t('contact','email'),
            'kindle_email' => 'Email kindle',
            'phone' => 'Điện thoại',
            'notice' => 'Yêu cầu khác',
            'format' => 'Định dạng tải sách',
            'created_time' => Yii::t('contact','created_time'),
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

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('format', $this->format, true);
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
