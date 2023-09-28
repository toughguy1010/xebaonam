<?php

/**
 * This is the model class for table "car_history_suport_buy".
 *
 * The followings are the available columns in table 'car_history_suport_buy':
 * @property string $id
 * @property integer $car_id
 * @property integer $car_name
 * @property string $email
 * @property string $name
 * @property string $car_price
 * @property string $car_component_price
 * @property string $car_earnest
 * @property integer $car_suport_type
 * @property integer $month
 * @property string $interest
 * @property integer $created_time
 * @property integer $site_id
 */
class CarHistorySuportBuy extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'car_history_suport_buy';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('car_id, email, car_price, car_earnest, car_suport_type, month, interest, created_time, site_id', 'required'),
			array('car_id, car_suport_type, month, created_time, site_id', 'numerical', 'integerOnly'=>true),
			array('email', 'length', 'max'=>100),
			array('name', 'length', 'max'=>50),
			array('car_price, car_component_price, car_earnest, interest', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('car_name, car_color, car_avatar, id, car_id, email, name, car_price, car_component_price, car_earnest, car_suport_type, month, interest, created_time, site_id', 'safe', 'on'=>'search'),
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
			'car_id' => 'Car',
			'email' => 'Email',
			'name' => 'Name',
			'car_price' => 'Car Price',
			'car_component_price' => 'Car Component Price',
			'car_earnest' => 'Car Earnest',
			'car_suport_type' => 'Car Suport Type',
			'month' => 'Month',
			'interest' => 'Interest',
			'created_time' => 'Created Time',
			'site_id' => 'Site',
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
		$criteria->compare('car_id',$this->car_id);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('car_price',$this->car_price,true);
		$criteria->compare('car_component_price',$this->car_component_price,true);
		$criteria->compare('car_earnest',$this->car_earnest,true);
		$criteria->compare('car_suport_type',$this->car_suport_type);
		$criteria->compare('month',$this->month);
		$criteria->compare('interest',$this->interest,true);
		$criteria->compare('created_time',$this->created_time);
		$criteria->compare('site_id',$this->site_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CarHistorySuportBuy the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
