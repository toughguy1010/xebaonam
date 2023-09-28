<?php

/**
 * This is the model class for table "site_support".
 *
 * The followings are the available columns in table 'site_support':
 * @property integer $site_id
 * @property integer $user_id
 * @property string $data
 * @property integer $created_time
 * @property integer $modified_time
 */
class SiteSupport extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('site_support');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('site_id', 'required'),
            array('site_id, user_id, created_time', 'numerical', 'integerOnly' => true),
            array('site_id, user_id, data, created_time,modified_time', 'safe'),
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
            'site_id' => 'Site',
            'user_id' => 'User',
            'data' => 'Data',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time'
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

        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('data', $this->data, true);
        $criteria->compare('created_time', $this->created_time);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SiteSupport the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    function beforeSave() {
        if ($this->isNewRecord) {
            $this->user_id = Yii::app()->user->id;
            $this->created_time = $this->modified_time = time();
        } else
            $this->modified_time = time();
        //
        return parent::beforeSave();
    }

    /**
     * return all type was support
     * @return array
     */
    static function getSupportTypesArr() {
        return array(
            'phone' => Yii::t('support', 'phone'),
            'address' => Yii::t('support', 'address'),
            'text' => Yii::t('support', 'text'),
            'skype' => Yii::t('support', 'skype'),
            'yahoo' => Yii::t('support', 'yahoo'),
            'fb' => Yii::t('support', 'facebook'),
            'googleplus' => Yii::t('support', 'googleplus'),
            'twitter' => Yii::t('support', 'twitter'),
            'instagram' => Yii::t('support', 'instagram'),
            'youtube' => Yii::t('support', 'youtube'),
            'gmail' => Yii::t('support', 'gmail'),
            'hotline' => Yii::t('support', 'hotline'),
            'fax' => Yii::t('support', 'fax'),
            'email' => Yii::t('support', 'email'),
            'pinterest' => Yii::t('support', 'pinterest'),
            'yelp' => Yii::t('support', 'yelp'),
            'linkedin' => Yii::t('support', 'linkedin'),
            'trip_advisor' => Yii::t('support', 'trip_advisor'),
            'zalo' => 'Zalo'
        );
    }

    /**
     * json decode data
     * @param type $data
     * @return type
     */
    function processData($data = '') {
        if ($data) {
            $data = json_decode($data, true);
        }
        return $data;
    }

    /*
     * json data
     */

    function encodeData($data = array()) {
        if ($data && is_array($data)) {
            $data = json_encode($data);
        } else
            $data = '';
        return $data;
    }

    /**
     * return data of site
     */
    function getData() {
        $support = self::model()->findByPk(Yii::app()->controller->site_id);
        if ($support) {
            $data = $support->processData($support->data);
            if ($data)
                return $data;
        }
        return array();
    }

}
