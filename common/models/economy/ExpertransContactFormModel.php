<?php

/**
 * This is the model class for table "expertrans_contact_form".
 *
 * The followings are the available columns in table 'expertrans_contact_form':
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $service
 * @property string $other_service
 * @property string $note
 * @property integer $site_id
 * @property integer $created_time
 * @property integer $modified_time
 * @property string $company
 * @property integer $aff_id
 * @property string $company_name
 */
class ExpertransContactFormModel extends CActiveRecord
{

    public $isCheck = false;

    const STATUS_ACTIVED = 1;
    const STATUS_DEACTIVED = 0;
    const STATUS_WAITING = 2;

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

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'expertrans_contact_form';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, phone, email, company, status', 'required'),
            array('site_id, created_time, modified_time, aff_id', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 200),
            array('phone', 'length', 'max' => 20),
            array('email, company, company_name', 'length', 'max' => 255),
            array('service, other_service', 'length', 'max' => 500),
            array('note', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, phone, email, service, other_service, note, site_id, created_time, modified_time, company, aff_id, company_name, status, affiliate_user, total_price, payment_status, payment_method, affiliate_id, aff_percent, service_name', 'safe'),
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
            'name' => Yii::t('translate', 'name'),
            'phone' => Yii::t('translate', 'phone'),
            'email' => Yii::t('translate', 'email'),
            'service' => Yii::t('translate', 'service'),
            'other_service' => Yii::t('translate', 'other_service'),
            'note' => Yii::t('translate', 'note'),
            'site_id' => 'Site',
            'created_time' => Yii::t('translate','created_time'),
            'modified_time' => 'Modified Time',
            'company' => Yii::t('translate', 'company'),
            'aff_id' => Yii::t('translate', 'aff_id'),
            'company_name' => Yii::t('translate', 'company_name'),
            'status' => Yii::t('translate', 'status'),
            'affiliate_user' => Yii::t('translate', 'affiliate_user'),
            'payment_status' => Yii::t('shoppingcart', 'payment_status'),
            'payment_method' => Yii::t('shoppingcart', 'payment_method'),
            'total_price' => Yii::t('translate', 'total_price'),
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
        $criteria->compare('service', $this->service, true);
        $criteria->compare('other_service', $this->other_service, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('company', $this->company, true);
        $criteria->compare('aff_id', $this->aff_id);
        $criteria->compare('status', $this->status);
        $criteria->compare('company_name', $this->company_name, true);
        $criteria->compare('affiliate_user', $this->affiliate_user, true);
        $criteria->compare('total_price', $this->total_price, true);
        $criteria->compare('payment_status', $this->payment_status, true);
        $criteria->compare('payment_method', $this->payment_method);
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
     * @return ExpertransContactForm the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function statusArrayTranslate()
    {
        return array(
            self::STATUS_ACTIVED => Yii::t('translate', 'actived'),
            self::STATUS_DEACTIVED => Yii::t('translate', 'deactived'),
            self::STATUS_WAITING => Yii::t('translate', 'waiting')
        );
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
                $affiliate_order->type = AffiliateOrder::TYPE_CONTACT;
                if ($affiliate_order->save()) {
                }
            }
        }
        parent::afterSave();
    }
}
