<?php

/**
 * This is the model class for table "sms_order".
 *
 * The followings are the available columns in table 'sms_order':
 * @property string $id
 * @property string $site_id
 * @property string $user_id
 * @property string $type_user
 * @property string $billing_email
 * @property string $billing_phone
 * @property string $order_total
 * @property string $order_total_paid
 * @property integer $payment_method
 * @property integer $status
 * @property integer $created_time
 * @property integer $modified_time
 */
class SmsOrder extends CActiveRecord
{
        const TYPE_ORDER = 'SMS';
        const ORDER_STATUS_NONE = 0; // chưa xử lý
        const ORDER_STATUS_PAID = 1; // đã thanh toán
        const ORDER_STATUS_PROCESSING = 2; // đang xử lý
        
        const PAYMENT_METHOD_TRANFER = 2;
        const PAYMENT_METHOD_ONLINE = 3;
        const PAYMENT_METHOD_BAOKIM = 4;
        
        public static $bank_list=array(
        'vietcombank'=>array(
                'name' => 'Vietcombank CN Hoàng Mai – Hà Nội',
                'logo' => 'https://www.vietcombank.com.vn/images/logo30.png',
                'account' => '0021 0012 79 779',
                'owner'  => 'Bùi Thanh Dũng',
            )                    
        );       
        /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return ClaTable::getTable('sms_order');
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('order_total', 'required'),
                        array('bank_code,bank_source_account, bank_source_owner, bank_source_time', 'required', 'on'=>'tranfer'),
                        array('order_total', 'numerical', 'min'=>10000,'max'=>50000000),
			array('payment_method, status, status_tranfer_money, status_money, created_time, modified_time', 'numerical', 'integerOnly'=>true),
			array('site_id, user_id, order_total, order_total_paid', 'length', 'max'=>11),
			array('type_user', 'length', 'max'=>5),
			array('billing_name', 'length', 'max'=>100),
			array('billing_email', 'length', 'max'=>100),
			array('billing_phone', 'length', 'max'=>20),
                        array('payment_method_child', 'length', 'max' => 10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('billing_name, billing_email, billing_phone, order_total, order_total_paid, payment_method, payment_method_child, status, status_tranfer_money, status_money, created_time, modified_time, multitext, bank_code, bank_source_account, bank_source_owner, bank_source_time', 'safe'),
			array('id, site_id, user_id, type_user, billing_name, billing_email, billing_phone, order_total, order_total_paid, payment_method, status, status_tranfer_money, status_money, created_time, modified_time, bank_code, bank_source_account, bank_source_owner, bank_source_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'site_id' => 'Site',
			'user_id' => 'User',
			'type_user' => 'Type User',
			'billing_name' => 'Billing Name',
			'billing_email' => 'Billing Email',
			'billing_phone' => 'Billing Phone',
			'order_total' => Yii::t('sms', 'order_total'),
			'order_total_paid' => 'Order Total Paid',
			'payment_method' => 'Payment Method',
			'status' => 'Status',
			'created_time' => 'Created Time',
			'modified_time' => 'Modified Time',
			'bank_code' => Yii::t('sms', 'bank_code'),
			'bank_source_account' => Yii::t('sms', 'bank_source_account'),
			'bank_source_owner' => Yii::t('sms', 'bank_source_owner'),
			'bank_source_time' => Yii::t('sms', 'bank_source_time'),			
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('site_id',$this->site_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('type_user',$this->type_user,true);
		$criteria->compare('billing_name',$this->billing_name,true);
		$criteria->compare('billing_email',$this->billing_email,true);
		$criteria->compare('billing_phone',$this->billing_phone,true);
		$criteria->compare('order_total',$this->order_total,true);
		$criteria->compare('order_total_paid',$this->order_total_paid,true);
		$criteria->compare('payment_method',$this->payment_method);
		$criteria->compare('status',$this->status);
		$criteria->compare('status_tranfer_money',$this->status_tranfer_money);
		$criteria->compare('status_money',$this->status_money);
		$criteria->compare('created_time',$this->created_time);
		$criteria->compare('modified_time',$this->modified_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SmsOrder the static model class
	 */
	public static function model($className=__CLASS__)
	{
            return parent::model($className);
	}
        
        public function beforeSave() {            
            if ($this->isNewRecord) {
                $this->created_time = time();
                $this->modified_time = $this->created_time;            
                $this->site_id = (!$this->site_id)?Yii::app()->controller->site_id:$this->site_id;
            } else {
                $this->modified_time = time();            
            }
            return parent::beforeSave();
        }
}
