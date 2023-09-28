<?php

/**
 * This is the model class for table "domains".
 *
 * The followings are the available columns in table 'domains':
 * @property string $domain_id
 * @property integer $site_id
 * @property integer $user_id
 * @property integer $domain_type
 * @property integer $domain_default
 * @property integer $created_time
 */
class Domains extends ActiveRecord {

    const DOMAIN_TYPE_NOACTION = 1; //
    const DOMAIN_TYPE_CANACTION = 0;
    const DOMAIN_DEFAULT_YES = 1;
    const DOMAIN_DEFAULT_NO = 0;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('domains');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('domain_id, site_id, user_id', 'required'),
            array('site_id, user_id', 'numerical', 'integerOnly' => true),
            array('domain_id', 'length', 'min' => 2, 'max' => 50),
            array('domain_id', 'unique'),
            array('domain_id', 'checkDomain', 'on' => 'addmore'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('domain_id, site_id, user_id, domain_default, created_time, language', 'safe'),
        );
    }

    /**
     * validate domain
     * @param type $attribute
     * @param type $params
     */
    function checkDomain($attribute, $params) {
        if (ClaRE::checkDomain($this->$attribute) && !ClaRE::isIPAddress($this->$attribute)) {
            
        } else {
            $this->addError($attribute, Yii::t('errors', 'domain_invalid'));
            return false;
        }
        if (!Yii::app()->isDemo) {
            // check server name was to point domainname to web3nhat's ip
            if (self::checkServerName($this->$attribute)) {
                return true;
            } else {
                $this->addError($attribute, Yii::t('domain', 'domain_invalid_ip', array('{domain}' => $this->$attribute)));
                return false;
            }
        }
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
            'domain_id' => Yii::t('common', 'domain'),
            'site_id' => 'Site ID',
            'user_id' => 'User',
//            'domain_type' => '0: có thể xóa, 1: không thể xóa',
            'domain_default' => Yii::t('domain', 'domain_default'),
            'created_time' => 'Created Date',
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

        $criteria->compare('domain_id', $this->domain_id, true);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('domain_default', $this->domain_default);
        $criteria->compare('created_time', $this->created_time);

        $criteria->order = 'created_time DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                'pageVar' => ClaSite::PAGE_VAR,
            ),
        ));
    }

    protected function beforeSave() {
        $this->domain_id = strtolower($this->domain_id);
        if ($this->isNewRecord)
            $this->created_time = time();
        return parent::beforeSave();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Domains the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * kiểm tra xem domain đã trỏ về ip của hệ thông chứa
     * @param type $domain
     */
    static function checkServerName($domain = '') {
        if ($domain) {
            $ip = gethostbyname($domain);
            if (in_array($ip, self::getIpInSystem()))
                return true;
        }
        return false;
    }

    static function getIpInSystem() {
        return Yii::app()->params['ipssystem'];
    }

    /**
     * 
     */
    function afterDelete() {
        //
        Yii::app()->cache->delete('domain_' . $this->domain_id);
        parent::afterSave();
    }

}
