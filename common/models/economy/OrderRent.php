<?php

/**
 * This is the model class for table "order_rent".
 *
 * The followings are the available columns in table 'order_rent':
 * @property integer $id
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $name
 * @property string $note
 * @property integer $status
 * @property string $total_price
 * @property string $currency
 * @property integer $site_id
 * @property string $key
 * @property string $payment_method
 * @property string $payment_key
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $vat
 * @property integer $shop_id
 * @property integer $deposits
 * @property integer $is_check
 */
class OrderRent extends ActiveRecord
{
    const PAYMENT_METHOD_CONTACT = 1; // Liên hệ
    const PAYMENT_METHOD_TRANSPORT = 2; // Chuyển khoản
    const PAYMENT_METHOD_NGANLUONG = 4; // thanh toán one pay quốc tế

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order_rent';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
//            array('bank_note, bank_no, bank_name', 'required'),
			array('status, site_id, created_time, modified_time', 'numerical', 'integerOnly'=>true),
			array('email, phone, name, payment_method, bank_note, bank_no, bank_name', 'length', 'max'=>255),
			array('address, note', 'length', 'max'=>500),
			array('total_price, deposits', 'length', 'max'=>16),
			array('currency', 'length', 'max'=>3),
			array('key, payment_key', 'length', 'max'=>250),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, email, phone, address, name, note, status, total_price, currency, site_id, key, payment_method, payment_key, shop_id, created_time, modified_time, note, deposits, vat, is_check, use_insurance, use_vat, insurance, total_product_price, receive_address_id, return_address_id, return_address_name, receive_address_name, bank_name ,bank_no, bank_note, district_id, province_id, ship_fee,tax_company_name,tax_company_code, tax_company_address, return_district_id, return_province_id,return_fee', 'safe'),
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
			'email' => 'Email',
			'phone' => 'Phone',
			'address' => 'Address',
			'name' => 'Name',
			'note' => 'Note',
			'status' => 'Status',
			'total_price' => 'Total Price',
			'currency' => 'Currency',
			'site_id' => 'Site',
			'key' => 'Key',
			'payment_method' => 'Payment Method',
			'payment_key' => 'Payment Key',
			'created_time' => 'Created Time',
			'modified_time' => 'Modified Time',
            'vat' => Yii::t('rent','vat'),
            'deposits' => Yii::t('rent','deposits'),
            'is_check' => Yii::t('rent','is_check'),
            'insurance' => Yii::t('rent','insurance'),
            'use_vat' => Yii::t('rent','use_vat'),
            'use_insurance' => Yii::t('rent','use_insurance'),
            'total_product_price' => Yii::t('rent','total_product_price'),
            'receive_address_id' => Yii::t('rent','receive_address_id'),
            'return_address_id' => Yii::t('rent','return_address_id'),
            'return_address_name' => Yii::t('rent','return_address_name'),
            'receive_address_name' => Yii::t('rent','receive_address_name'),
            'bank_name' => Yii::t('user','bank_name'),
            'bank_no' => Yii::t('rent','bank_no'),
            'bank_note' => Yii::t('rent','bank_note'),
            'district_id' => Yii::t('rent','district_id'),
            'province_id' => Yii::t('rent','province_id'),
            'ship_fee' => Yii::t('rent','ship_fee'),
            'return_fee' => Yii::t('rent','return_fee'),
            'tax_company_name' => Yii::t('rent','tax_company_name'),
            'tax_company_code' => Yii::t('rent','tax_company_code'),
            'tax_company_address' => Yii::t('rent','tax_company_address'),
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

		$criteria->compare('id',$this->id);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('total_price',$this->total_price,true);
		$criteria->compare('currency',$this->currency,true);
		$criteria->compare('site_id',$this->site_id);
		$criteria->compare('key',$this->key,true);
		$criteria->compare('payment_method',$this->payment_method,true);
		$criteria->compare('payment_key',$this->payment_key,true);
		$criteria->compare('created_time',$this->created_time);
		$criteria->compare('modified_time',$this->modified_time);
		$criteria->compare('vat',$this->vat,true);
        $criteria->compare('shop_id', $this->shop_id);
		$criteria->compare('deposits',$this->deposits,true);
		$criteria->compare('insurance',$this->insurance,true);
		$criteria->compare('use_vat',$this->use_vat,true);
		$criteria->compare('use_insurance',$this->use_insurance,true);
		$criteria->compare('total_product_price',$this->total_product_price,true);
        $criteria->order = 'created_time DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderRent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        $this->modified_time = time();
        return parent::beforeSave();
    }

    /**
     * Xử lý giá
     */
    function processPrice() {
        if ($this->total_price)
            $this->total_price = floatval(str_replace(array('.', ', '), array('', '.'), $this->total_price + ''));
    }
}
