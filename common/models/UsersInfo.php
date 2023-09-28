<?php

/**
 * This is the model class for table "users_info".
 *
 * The followings are the available columns in table 'users_info':
 * @property integer $user_id
 * @property integer $notify_by_email
 * @property integer $notify_by_sms
 * @property integer $notify_by_push_notification
 * @property integer $business_email_notify
 * @property integer $admin_email_notify
 */
class UsersInfo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_info';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, notify_by_sms', 'required'),
			array('user_id, notify_by_email, notify_by_sms, notify_by_push_notification, business_email_notify, admin_email_notify', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, notify_by_email, notify_by_sms, notify_by_push_notification, business_email_notify, admin_email_notify', 'safe'),
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
			'user_id' => 'User',
			'notify_by_email' => Yii::t('user', 'notify_by_email'),
			'notify_by_sms' =>  Yii::t('user', 'notify_by_sms'),
			'notify_by_push_notification' => Yii::t('user', 'notify_by_push_notification'),
			'business_email_notify' => Yii::t('user', 'business_email_notify'),
			'admin_email_notify' => Yii::t('user', 'admin_email_notify'),
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
		$criteria->compare('notify_by_email',$this->notify_by_email);
		$criteria->compare('notify_by_sms',$this->notify_by_sms);
		$criteria->compare('notify_by_push_notification',$this->notify_by_push_notification);
		$criteria->compare('business_email_notify',$this->business_email_notify);
		$criteria->compare('admin_email_notify',$this->admin_email_notify);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersInfo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
