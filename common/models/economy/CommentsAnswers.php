<?php

/**
 * This is the model class for table "comments_answers".
 *
 * The followings are the available columns in table 'comments_answers':
 * @property string $id
 * @property string $comment_id
 * @property string $site_id
 * @property string $content
 * @property integer $status
 * @property string $liked
 * @property string $user_id
 * @property integer $type
 * @property string $email_phone
 * @property string $name
 * @property integer $user_type
 * @property string $created_time
 * @property string $modified_time
 */
class CommentsAnswers extends ActiveRecord
{

    public $verifyCode;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'comments_answers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('comment_id, site_id, content, created_time, modified_time', 'required'),
			array('status, type, user_type', 'numerical', 'integerOnly'=>true),
			array('comment_id, site_id, liked, user_id, created_time, modified_time', 'length', 'max'=>10),
			array('content', 'length', 'max'=>500),
			array('email_phone, name', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, comment_id, site_id, content, status, liked, user_id, type, email_phone, name, user_type, created_time, modified_time, verifyCode', 'safe', 'on'=>'search'),
            array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements()),
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
			'comment_id' => 'Comment',
			'site_id' => 'Site',
			'content' => 'Content',
			'status' => 'Status',
			'liked' => 'Liked',
			'user_id' => 'User',
			'type' => 'Type',
			'email_phone' => 'Email Phone',
			'name' => 'Name',
			'user_type' => 'User Type',
			'created_time' => 'Created Time',
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
		$criteria->compare('comment_id',$this->comment_id,true);
		$criteria->compare('site_id',$this->site_id,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('liked',$this->liked,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('email_phone',$this->email_phone,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('user_type',$this->user_type);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('modified_time',$this->modified_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CommentsAnswers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
