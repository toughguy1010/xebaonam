<?php

/**
 * This is the model class for table "users_address".
 *
 * The followings are the available columns in table 'users_address':
 * @property integer $user_id
 * @property integer $site_id
 * @property string $name
 * @property string $email
 * @property integer $status
 * @property string $phone
 * @property string $province_id
 * @property string $district_id
 * @property integer $active
 * @property integer $created_time
 * @property integer $modified_time
 * @property string $id
 */
class UsersAddress extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_address';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, site_id, name,  phone, district_id, created_time', 'required'),
			array('user_id, site_id, status, active, created_time, modified_time', 'numerical', 'integerOnly'=>true),
			array('name, email', 'length', 'max'=>100),
			array('phone', 'length', 'max'=>20),
			array('province_id, district_id', 'length', 'max'=>4),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, site_id, name, email, status, phone, province_id, district_id, active, created_time, modified_time, id, address', 'safe'),
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
			'user_id' => Yii::t('common','user'),
			'site_id' => 'Site',
			'name' => Yii::t('common','name'),
			'email' => Yii::t('common','email'),
			'status' => 'Status',
			'phone' =>Yii::t('common','phone'),
			'province_id' => Yii::t('common','province'),
			'district_id' => Yii::t('common','district'),
			'active' => 'Active',
			'created_time' => 'Created Time',
			'modified_time' => 'Modified Time',
			'id' => 'ID',
			'address' => Yii::t('common','address'),
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

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('site_id',$this->site_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('address',$this->address);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('province_id',$this->province_id,true);
		$criteria->compare('district_id',$this->district_id,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('created_time',$this->created_time);
		$criteria->compare('modified_time',$this->modified_time);
		$criteria->compare('id',$this->id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersAddress the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
