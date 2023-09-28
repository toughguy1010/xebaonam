<?php

/**
 * This is the model class for table "car_try_driver".
 *
 * The followings are the available columns in table 'car_try_driver':
 * @property string $id
 * @property string $car_id
 * @property integer $date_coming
 * @property integer $time_coming
 * @property string $user_name
 * @property string $email
 * @property string $phone
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $site_id
 */
class CarTryDriver extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'car_try_driver';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('car_id, date_coming, time_coming, phone', 'required'),
			array('created_time, modified_time, site_id', 'numerical', 'integerOnly'=>true),
			array('car_id', 'length', 'max'=>250),
			array('time_coming, user_name', 'length', 'max'=>50),
			array('email', 'length', 'max'=>100),
			array('phone', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, car_id, date_coming, time_coming, user_name, email, phone, created_time, modified_time, site_id', 'safe', 'on'=>'search'),
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
			'car_id' => 'Mẫu xe',
			'date_coming' => 'Ngày dự kiến',
			'time_coming' => 'Thời gian dự kiến',
			'user_name' => 'Họ tên',
			'email' => 'Email',
			'phone' => 'Số điện thoại',
			'created_time' => 'Ngày tạo',
			'modified_time' => 'Modified Time',
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
		$criteria->compare('car_id',$this->car_id,true);
		$criteria->compare('date_coming',$this->date_coming);
		$criteria->compare('time_coming',$this->time_coming);
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('note',$this->note, true);
		$criteria->compare('site_id',$this->site_id);
        $criteria->order = 'created_time DESC';
		return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                'pageVar' => ClaSite::PAGE_VAR,
            )
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CarTryDriver the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function arrTimeComing() {
		return $arr =[
			'' => 'Chọn thời gian',
			'8:00 - 9:00' => '8:00 - 9:00',
			'9:00 - 10:00' => '9:00 - 10:00',
			'10:00 - 11:00' => '10:00 - 11:00',
			'11:00 - 12:00' => '11:00 - 12:00',
			'12:00 - 13:00' => '12:00 - 13:00',
			'13:00 - 14:00' => '13:00 - 14:00',
			'14:00 - 15:00' => '14:00 - 15:00',
			'15:00 - 16:00' => '15:00 - 16:00',
		];
	}

	// public static function arrPlace() {
	// 	return $arr =[
	// 		'Toyata' => 'Toyata',
	// 	];
	// }

	// public static function arrDear() {
	// 	return $arr =[
	// 		'' => 'Chọn danh xưng',
	// 		'Ông' => 'Ông',
	// 		'Bà' => 'Bà',
	// 		'Anh' => 'Anh',
	// 		'Chị' => 'Chị',
	// 	];
	// }

}
