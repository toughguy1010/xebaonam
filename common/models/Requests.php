<?php

/**
 * This is the model class for table "requests".
 *
 * The followings are the available columns in table 'requests':
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $trade
 * @property string $website_reference
 * @property string $color
 * @property string $description
 * @property integer $status
 * @property integer $created_time
 * @property string $theme_id
 */
class Requests extends ActiveRecord {

    public $captcha;

    const STATUS_WAIT = 0;
    const STATUS_PROCESSED = 1;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'requests';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name,phone,address,trade', 'required'),
            array('captcha', 'required', 'on' => 'request'),
            array('status, created_time', 'numerical', 'integerOnly' => true),
            array('name, email, phone, address, trade, website_reference, color', 'length', 'max' => 255),
            array('captcha', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements(), 'on' => 'request'),
            array('email', 'email'), // The following rule is used by search().
            array('phone', 'isPhone'),
            // @todo Please remove those attributes that should not be searched.
            array('id, name, email, phone, address, trade, website_reference, color, description, status, created_time, captcha, theme_id', 'safe'),
        );
    }

    /**
     * add rule: checking phone number
     * @param type $attribute
     * @param type $params
     */
    public function isPhone($attribute, $params) {
        if (!$this->$attribute)
            return true;
        if (!ClaRE::isPhoneNumber($this->$attribute))
            $this->addError($attribute, Yii::t('errors', 'phone_invalid'));
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => Yii::t('request', 'name'),
            'email' => Yii::t('request', 'email'),
            'phone' => Yii::t('request', 'phone'),
            'address' => Yii::t('request', 'address'),
            'trade' => Yii::t('request', 'trade'),
            'website_reference' => Yii::t('request', 'website_reference'),
            'color' => Yii::t('request', 'color'),
            'description' => Yii::t('common', 'description'),
            'status' => Yii::t('common', 'status'),
            'created_time' => 'Created Time',
            'captcha' => Yii::t('common', 'captcha'),
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
        $criteria->compare('address', $this->address, true);
        $criteria->compare('trade', $this->trade, true);
        $criteria->compare('website_reference', $this->website_reference, true);
        $criteria->compare('color', $this->color, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_time', $this->created_time);
        $criteria->order = 'status,created_time DESC';
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

    static function getRequestStatus() {
        return array(
            self::STATUS_WAIT => Yii::t('request', 'status_wait'),
            self::STATUS_PROCESSED => Yii::t('request', 'status_processed'),
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Requests the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        if ($this->isNewRecord) {
            $this->created_time = time();
        }
        return parent::beforeSave();
    }

}
