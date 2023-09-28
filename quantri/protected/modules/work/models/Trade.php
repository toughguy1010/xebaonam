<?php

/**
 * This is the model class for table "lov_trades".
 *
 * The followings are the available columns in table 'lov_trades':
 * @property string $tradeid
 * @property string $trade_code
 * @property string $trade_name
 */
class Trade extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Blog the static model class
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
		return 'lov_trades';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('trade_name', 'required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
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
			'trade_code' => 'Mã ngành',
			'trade_name' => 'Nhóm ngành nghề ',
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

		$criteria->compare('can_view',$this->can_view);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}