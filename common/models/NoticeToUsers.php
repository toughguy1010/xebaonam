<?php

/**
 * This is the model class for table "notice_to_users".
 *
 * The followings are the available columns in table 'notice_to_users':
 * @property string $id
 * @property string $site_id
 * @property string $user_id
 * @property integer $notice_id
 * @property integer $status
 * @property string $modified_time
 * @property string $created_time
 */
class NoticeToUsers extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'notice_to_users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('notice_id, status', 'numerical', 'integerOnly'=>true),
			array('site_id, user_id, modified_time, created_time', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, site_id, user_id, notice_id, status, modified_time, created_time', 'safe', 'on'=>'search'),
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
			'notice_id' => 'Notification',
			'status' => 'Status',
			'modified_time' => 'Modified Time',
			'created_time' => 'Created Time',
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
		$criteria->compare('notice_id',$this->notice_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('modified_time',$this->modified_time,true);
		$criteria->compare('created_time',$this->created_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NoticeToUsers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
