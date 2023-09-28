<?php

/**
 * This is the model class for table "maps".
 *
 * The followings are the available columns in table 'maps':
 * @property integer $id
 * @property integer $site_id
 * @property integer $user_id
 * @property string $latlng
 * @property string $name
 * @property string $address
 * @property string $email
 * @property string $phone
 * @property string $website
 * @property integer $headoffice
 * @property integer $order
 * @property integer $created_time
 * @property integer $modified_time
 */
class Maps extends ActiveRecord {

    const IS_HEADOFFICE = 1;
    const DEFAUTL_LIMIT = 5;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('map');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('latlng,name,address', 'required'),
            array('user_id, headoffice, order, created_time, modified_time', 'numerical', 'integerOnly' => true),
            array('latlng, email', 'length', 'max' => 100),
            array('name, address, phone, website', 'length', 'max' => 255),
            array('id, site_id, user_id, latlng, name, address, email, phone, website, headoffice, order, created_time, modified_time', 'safe'),
            array('email', 'email'),
            array('phone', 'isPhone'),
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
            'user_id' => 'User',
            'latlng' => 'Latlng',
            'name' => Yii::t('map', 'name'),
            'address' => Yii::t('common', 'address'),
            'email' => Yii::t('common', 'email'),
            'phone' => Yii::t('common', 'phone'),
            'website' => Yii::t('map', 'website'),
            'headoffice' => Yii::t('map', 'headoffice'),
            'order' => Yii::t('common', 'order'),
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
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
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('latlng', $this->latlng, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('website', $this->website, true);
        $criteria->compare('headoffice', $this->headoffice);
        $criteria->compare('order', $this->order);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->user_id = Yii::app()->user->id;
            $this->modified_time = $this->created_time;
        } else {
            $this->modified_time = time();
        }
        return parent::beforeSave();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Maps the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    static function getMaps($options = array()) {
        if (!isset($options['limit']))
            $options['limit'] = self::DEFAUTL_LIMIT;
        $siteid = Yii::app()->controller->site_id;
        $maps = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('map'))
                ->where("site_id=$siteid")
                ->order('headoffice DESC, created_time DESC')
                ->limit($options['limit'])
                ->queryAll();
        return $maps;
    }

}
