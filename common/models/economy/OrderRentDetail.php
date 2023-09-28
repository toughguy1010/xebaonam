<?php

/**
 * This is the model class for table "order_rent_detail".
 *
 * The followings are the available columns in table 'order_rent_detail':
 * @property integer $id
 * @property integer $order_id
 * @property integer $rent_from
 * @property integer $rent_to
 * @property integer $rent_product_id
 * @property string $product_code
 * @property integer $quantity
 * @property string $price
 * @property integer $site_id
 * @property string $currency
 * @property integer $created_time
 * @property integer $day
 */
class OrderRentDetail extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order_rent_detail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_id, rent_from, rent_to, rent_product_id, quantity', 'required'),
			array('order_id, rent_from, rent_to, rent_product_id, quantity, site_id, created_time', 'numerical', 'integerOnly'=>true),
			array('product_code', 'length', 'max'=>255),
			array('price', 'length', 'max'=>16),
			array('currency', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, order_id, rent_from, rent_to, rent_product_id, product_code, quantity, price, site_id, currency, created_time, day', 'safe', 'on'=>'search'),
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
			'order_id' => 'Order',
			'rent_from' => 'Rent From',
			'rent_to' => 'Rent To',
			'rent_product_id' => 'Rent Product',
			'product_code' => 'Product Code',
			'quantity' => 'Quantity',
			'price' => 'Price',
			'site_id' => 'Site',
			'currency' => 'Currency',
			'created_time' => 'Created Time',
            'day' => Yii::t('rent','day'),
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
		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('rent_from',$this->rent_from);
		$criteria->compare('rent_to',$this->rent_to);
		$criteria->compare('rent_product_id',$this->rent_product_id);
		$criteria->compare('product_code',$this->product_code,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('site_id',$this->site_id);
		$criteria->compare('currency',$this->currency,true);
		$criteria->compare('created_time',$this->created_time);
		$criteria->compare('day',$this->day);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderRentDetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        return parent::beforeSave();
    }

    /**
     * get products and its info
     * @param type $order_id
     */
    static function getItemssDetailInOrder($order_id) {
        $order_id = (int) $order_id;
        if ($order_id) {
            $items = Yii::app()->db->createCommand()
                ->select()
                ->from(ClaTable::getTable('order_rent_detail'))
                ->where('order_id=:order_id', array(':order_id' => $order_id))
                ->queryAll();
            $results = array();
            foreach ($items as $item) {
                $results[$item['id']] = $item;
            }
            return $results;
        }
        return array();
    }
}
