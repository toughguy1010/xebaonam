<?php

/**
 * This is the model class for table "bpo_form".
 *
 * The followings are the available columns in table 'bpo_form':
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $country
 * @property string $from
 * @property string $to
 * @property integer $service
 * @property integer $other_service
 * @property string $currency
 * @property integer $payment_method
 * @property string $note
 * @property string $company
 */
class BpoForm extends ActiveRecord
{
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
    public function tableName()
    {
        return 'bpo_form';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('currency, payment_method, name, email, phone, company, service', 'required'),
            array('other_service, payment_method', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 200),
            array('service', 'length', 'max' => 500),
            array('phone', 'length', 'max' => 20),
            array('email', 'length', 'max' => 255),
            array('email', 'email'),
            array('country, from, currency', 'length', 'max' => 4),
            array('to', 'length', 'max' => 500),
            array('note', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, phone, email, country, from, to, service, other_service, currency, payment_method, note, modified_time,created_time, site_id, company, status, payment_status, total_price, service_name, aff_percent', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => Yii::t('common', 'name'),
            'phone' => Yii::t('common', 'phone'),
            'email' => Yii::t('common', 'email'),
            'country' => Yii::t('common', 'country'),
            'from' => Yii::t('translate', 'from_lang'),
            'to' => Yii::t('translate', 'to_lang'),
            'service' => Yii::t('common', 'service_bpo'),
            'other_service' => Yii::t('common', 'other_service'),
            'currency' => Yii::t('translate', 'currency'),
            'payment_method' => Yii::t('shoppingcart', 'payment_method'),
            'note' => Yii::t('common', 'note'),
            'company' => Yii::t('common', 'company'),
            'affiliate_id' => Yii::t('common', 'affiliate_id'),
            'affiliate_user' => Yii::t('common', 'affiliate_user'),
            'payment_status' => Yii::t('common', 'payment_status'),
            'total_price' => Yii::t('translate', 'total_price'),
            'service_name' => Yii::t('common', 'service_name'),
            'aff_percent' => Yii::t('translate', 'aff_percent'),
            'site_id' => 'site_id',
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
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('country', $this->country, true);
        $criteria->compare('from', $this->from, true);
        $criteria->compare('to', $this->to, true);
        $criteria->compare('service', $this->service);
        $criteria->compare('other_service', $this->other_service);
        $criteria->compare('currency', $this->currency, true);
        $criteria->compare('payment_method', $this->payment_method);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('site_id', $this->site_id, true);
        $criteria->compare('company', $this->company, true);
        $criteria->compare('affiliate_id', $this->affiliate_id, true);
        $criteria->compare('affiliate_user', $this->affiliate_user, true);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('total_price', $this->total_price, true);
        $criteria->compare('payment_status', $this->payment_status, true);
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
     * @return BpoForm the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    function beforeSave() {
        if ($this->isNewRecord) {
            $this->created_time = $this->modified_time = time();
            if (!$this->site_id) {
                $this->site_id = Yii::app()->controller->site_id;
            }
        } else {
            $this->modified_time = time();
        }
        if ($this->isCheck) {
            $affiliateSession = isset(Yii::app()->session[ClaTranslateShoppingCart::AFFILIATE_SESSION_KEY]) ? Yii::app()->session[ClaTranslateShoppingCart::AFFILIATE_SESSION_KEY] : array();
            if ($affiliateSession && isset($affiliateSession['id'])) {
                $this->affiliate_id = $affiliateSession['id'];
                $this->affiliate_user = $affiliateSession['user_id'];
                $model = ExpertransService::model()->findByPk($this->service);
                if($model){
                    $this->aff_percent = $model->aff_percent;
                    $this->service_name = $model->name;
                }
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
                $affiliate_order->type = AffiliateOrder::TYPE_BPO;
                if ($affiliate_order->save()) {
                }
            }
        }
        parent::afterSave();
    }

    /**
     * Trả về các trạng thái của đơn hàng.
     * @hatv
     * @return array
     */
    public static function getStatusArr() {
        return array(
            self::ORDER_WAITFORPROCESS => Yii::t('shoppingcart', 'order_waitforprocess'),
            self::ORDER_DESTROY => Yii::t('shoppingcart', 'order_destroy'),
            self::ORDER_COMPLETE => Yii::t('shoppingcart', 'order_complete'),
        );
    }
}
