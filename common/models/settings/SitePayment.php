<?php

/**
 * This is the model class for table "site_payment".
 *
 * The followings are the available columns in table 'site_payment':
 * @property integer $id
 * @property string $site_id
 * @property string $payment_type
 * @property integer $status
 * @property string $email_bussiness
 * @property integer $merchan_id
 * @property string $params
 * @property string $receive_account
 * @property string $url_return
 * @property string $client_id
 * @property string $secret
 */
class SitePayment extends CActiveRecord {

    const TYPE_BAOKIM = 'baokim';
    const TYPE_ONEPAY = 'onepay'; // nội địa
    const TYPE_ONEPAY_QUOCTE = 'onepay_quocte'; // quốc tế
    const TYPE_NGANLUONG = 'nganluong';
    const TYPE_VTCPAY = 'vtcpay'; // VTC ONLINE
    const TYPE_PAYPAL = 'paypal'; // PAYPAL
    const TYPE_ALEPAY = 'alepay'; // PAYPAL

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'site_payment';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('status', 'numerical', 'integerOnly' => true),
            array('payment_type', 'length', 'max' => 50),
            array('email_bussiness, merchan_id', 'length', 'max' => 100),
            array('email_bussiness', 'email'),
            array('params', 'length', 'max' => 512),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, site_id, payment_type, status, email_bussiness, merchan_id, params, api_user, api_password, access_code, secure_pass, pri_key, url_request, url_return, receive_account, client_id, secret, api_key, encrypt_key, checksum', 'safe'),
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
            'payment_type' => Yii::t('setting', 'setting_payment_type'),
            'status' => 'Status',
            'email_bussiness' => Yii::t('setting', 'email_bussiness'),
            'merchan_id' => 'Merchan ID',
            'params' => 'Params',
            'api_user' => 'API User',
            'api_password' => 'API Password',
            'access_code' => 'Access Code',
            'secure_pass' => 'Secure Password',
            'pri_key' => 'Private Key',
            'client_id' => 'Client ID',
            'secret' => 'Secret',
            'api_key' => 'Api Key',
            'encrypt_key' => 'Encrypt Key',
            'checksum' => 'Checksum Key'
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
        $criteria->compare('site_id', $this->site_id);

        $criteria->order = 'id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    /**
     * @hungtm
     * check payment by payment_type
     * @param type $type
     */
    public static function checkPaymentType($type) {
        $res = SitePayment::model()->find('site_id=:site_id AND status=1 AND payment_type=:payment_type', array(
            ':site_id' => Yii::app()->siteinfo['site_id'],
            ':payment_type' => $type
        ));
        return (is_null($res)) ? false : true;
    }
    
    /**
     * @hungtm
     * get config payment by payment_type
     * @return type
     */
    public static function getPaymentType($type) {
        $payment = SitePayment::model()->findByAttributes(array(
            'site_id' => Yii::app()->siteinfo['site_id'],
            'payment_type' => $type
        ));
        return $payment;
    }

    public function checkPaymentOnline() {
        $res = $this->find('site_id=:site_id AND status=1', array(':site_id' => Yii::app()->siteinfo['site_id']));
        return (is_null($res)) ? false : true;
    }

    public function getEmailBussiness($payment_type) {
        $res = $this->find('site_id=:site_id AND payment_type=:payment_type AND status=1',array(':site_id' => Yii::app()->siteinfo['site_id'], ':payment_type' => $payment_type));
        if ($res && $res->email_bussiness) {
            return $res->email_bussiness;
        } else {
            return '';
        }
    }

    public function getConfigPayment($payment_type) {
        $model = $this->find('site_id=:site_id AND payment_type=:payment_type AND status=1',array('site_id' => Yii::app()->siteinfo['site_id'], ':payment_type' => $payment_type));
        if ($model) {
            $res = $model->getAttributes();
            unset($res['id']);
            unset($res['params']);
            return $res;
        } else {
            return false;
        }
    }

    public static function typeArr() {
        return array(
            self::TYPE_BAOKIM => self::TYPE_BAOKIM,
            self::TYPE_ONEPAY => self::TYPE_ONEPAY,
            self::TYPE_ONEPAY_QUOCTE => self::TYPE_ONEPAY_QUOCTE,
            self::TYPE_NGANLUONG => self::TYPE_NGANLUONG,
            self::TYPE_VTCPAY => self::TYPE_VTCPAY,
            self::TYPE_PAYPAL => self::TYPE_PAYPAL,
            self::TYPE_ALEPAY => self::TYPE_ALEPAY
        );
    }

}
