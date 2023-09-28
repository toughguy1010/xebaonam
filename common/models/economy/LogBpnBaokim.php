<?php

/**
 * This is the model class for table "ncs_log_baokim".
 *
 * The followings are the available columns in table 'ncs_log_baokim':
 * @property integer $id
 * @property integer $created_on
 * @property string $customer_email
 * @property string $customer_name
 * @property string $fee_amount
 * @property string $merchant_email
 * @property integer $merchant_id
 * @property string $merchant_name
 * @property string $merchant_phone
 * @property string $net_amount
 * @property string $order_id
 * @property integer $payment_type
 * @property string $total_amount
 * @property string $transaction_id
 * @property integer $transaction_status
 * @property integer $usd_vnd_exchange_rate
 * @property string $verify_sign
 */
class LogBpnBaokim extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LogBaokim the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'log_bpn_baokim';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('transaction_id', 'required'),						
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('created_on, customer_email, customer_name, fee_amount, merchant_email, merchant_id, merchant_name, merchant_phone, net_amount, order_id, payment_type, total_amount, transaction_id, transaction_status, usd_vnd_exchange_rate, verify_sign', 'safe'),
			array('id, created_on, customer_email, customer_name, fee_amount, merchant_email, merchant_id, merchant_name, merchant_phone, net_amount, order_id, payment_type, total_amount, transaction_id, transaction_status, usd_vnd_exchange_rate, verify_sign', 'safe', 'on'=>'search'),
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
			'created_on' => 'Created On',
			'customer_email' => 'Customer Email',
			'customer_name' => 'Customer Name',
			'fee_amount' => 'Fee Amount',
			'merchant_email' => 'Merchant Email',
			'merchant_id' => 'Merchant',
			'merchant_name' => 'Merchant Name',
			'merchant_phone' => 'Merchant Phone',
			'net_amount' => 'Net Amount',
			'order_id' => 'Order',
			'payment_type' => 'Payment Type',
			'total_amount' => 'Total Amount',
			'transaction_id' => 'Transaction',
			'transaction_status' => 'Transaction Status',
			'usd_vnd_exchange_rate' => 'Usd Vnd Exchange Rate',
			'verify_sign' => 'Verify Sign',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('created_on',$this->created_on);
		$criteria->compare('customer_email',$this->customer_email,true);
		$criteria->compare('customer_name',$this->customer_name,true);
		$criteria->compare('fee_amount',$this->fee_amount,true);
		$criteria->compare('merchant_email',$this->merchant_email,true);
		$criteria->compare('merchant_id',$this->merchant_id);
		$criteria->compare('merchant_name',$this->merchant_name,true);
		$criteria->compare('merchant_phone',$this->merchant_phone,true);
		$criteria->compare('net_amount',$this->net_amount,true);
		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('payment_type',$this->payment_type);
		$criteria->compare('total_amount',$this->total_amount,true);
		$criteria->compare('transaction_id',$this->transaction_id,true);
		$criteria->compare('transaction_status',$this->transaction_status);
		$criteria->compare('usd_vnd_exchange_rate',$this->usd_vnd_exchange_rate);
		$criteria->compare('verify_sign',$this->verify_sign,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}