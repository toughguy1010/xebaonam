<?php

/**
 * This is the model class for table "interpretation_order".
 *
 * The followings are the available columns in table 'interpretation_order':
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $tell
 * @property string $address
 * @property string $payment_method
 * @property integer $words
 * @property string $total_price
 * @property string $currency
 */
class InterpretationOrder extends ActiveRecord {

    const ORDER_WAITFORPROCESS = 0;
    const ORDER_WAITFORPAYMENT = 1;
    const ORDER_WAITFORCOMPLETE = 2;
    //
    const ORDER_DESTROY = 5; // Hủy đơn hàng
    const ORDER_COMPLETE = 6; // Hoàn thành
    //
    const ORDER_PAYMENT_STATUS_NONE = 0; // chưa xử lý
    const ORDER_PAYMENT_STATUS_PAID = 1; // đã thanh toán
    const ORDER_PAYMENT_STATUS_PROCESSING = 2; // đang xử lý
    //
    const PAYMENT_METHOD_CONTACT = 1; // Liên hệ
    const PAYMENT_METHOD_TRANSPORT = 2; // Chuyển khoản
    const PAYMENT_METHOD_PAYPAL = 3; // thanh toán paypal
    const PAYMENT_METHOD_NGANLUONG = 4; // thanh toán one pay quốc tế
    //
    public $updateStatus = 0;
    public $isCheck = false;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'interpretation_order';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, email, tell, payment_method', 'required'),
            array('email', 'email'),
            array('tell', 'isPhone'),
            array('id, words', 'numerical', 'integerOnly' => true),
            array('name, email, tell, address', 'length', 'max' => 255),
            array('total_price, payment_method', 'length', 'max' => 16),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, email, tell, address, words, total_price, affiliate_id, affiliate_user, user_id, created_time, modified_time, note, currency, site_id, key, day, payment_status, payment_method, status, aff_percent', 'safe'),
        );
    }
    /**
     * add rule: checking phone number
     * @param type $attribute
     * @param type $params
     */
    public function isPhone($attribute, $params) {
        if (!ClaRE::isPhoneNumber($this->$attribute))
            $this->addError($attribute, Yii::t('errors', 'phone_invalid'));
    }

    public function beforeSave() {
        if ($this->isNewRecord) {
            $this->site_id = Yii::app()->controller->site_id;
            $this->user_id = Yii::app()->user->id;
            $this->created_time = time();
        } else {
            $this->modified_time = time();
        }
        if ($this->isCheck) {
            $affiliateSession = isset(Yii::app()->session[ClaTranslateShoppingCart::AFFILIATE_SESSION_KEY]) ? Yii::app()->session[ClaTranslateShoppingCart::AFFILIATE_SESSION_KEY] : array();
            if ($affiliateSession && isset($affiliateSession['id'])) {
                $this->affiliate_id = $affiliateSession['id'];
                $this->affiliate_user = $affiliateSession['user_id'];
            }
        }
        return parent::beforeSave();
    }

    public function afterSave() {
        if ($this->isCheck) {
            $affiliateSession = isset(Yii::app()->session[ClaTranslateShoppingCart::AFFILIATE_SESSION_KEY]) ? Yii::app()->session[ClaTranslateShoppingCart::AFFILIATE_SESSION_KEY] : array();
            if ($affiliateSession && isset($affiliateSession['id'])) {
                $affiliate_order = new AffiliateOrder();
                $affiliate_order->user_id = $affiliateSession['user_id'];
                $affiliate_order->affiliate_id = $affiliateSession['id'];
                $affiliate_order->affiliate_click_id = $affiliateSession['affiliate_click_id'];
                $affiliate_order->order_id = $this->id;
                $affiliate_order->type = AffiliateOrder::TYPE_INTERPRETATION;
                if ($affiliate_order->save()) {
                }
            }
        }
        parent::afterSave();
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
            'name' => Yii::t('common','name'),
            'email' => Yii::t('common','email'),
            'tell' => Yii::t('translate','tell'),
            'address' => Yii::t('common','address'),
            'payment_method' => Yii::t('shoppingcart','payment_method'),
            'words' => Yii::t('common','words'),
            'total_price' => 'Total Price',
            'payment_status' => Yii::t('common','payment_status'),
            'status' => Yii::t('common','status'),
            'aff_percent' => Yii::t('translate','aff_percent'),
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
        $criteria->compare('tell', $this->tell, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('payment_method', $this->payment_method, true);
        $criteria->compare('payment_status', $this->payment_status, true);
        $criteria->compare('words', $this->words);
        $criteria->compare('total_price', $this->total_price, true);
        $criteria->compare('affiliate_user', $this->affiliate_user, true);
        $criteria->compare('status', $this->status, true);
        $criteria->order = 'created_time DESC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                //'pageSize' => $pageSize,
                'pageVar' => 'page',
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return InterpretationOrder the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
