<?php

/**
 * This is the model class for table "lov_comments".
 *
 * The followings are the available columns in table 'lov_comments':
 * @property integer $fc_id
 * @property integer $obj_id
 * @property integer $user_id
 * @property string $comment
 * @property integer $createdate
 * @property string $obj_type
 */
class Workcomments extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Workcomments the static model class
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
		return 'lov_comments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('obj_id, user_id, createdate', 'numerical', 'integerOnly'=>true),
			array('obj_type', 'length', 'max'=>20),
			array('comment', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('fc_id, obj_id, user_id, comment, createdate, obj_type', 'safe', 'on'=>'search'),
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
			'fc_id' => 'Fc',
			'obj_id' => 'Obj',
			'user_id' => 'User',
			'comment' => 'Comment',
			'createdate' => 'Createdate',
			'obj_type' => 'Obj Type',
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

		$criteria->compare('fc_id',$this->fc_id);
		$criteria->compare('obj_id',$this->obj_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('createdate',$this->createdate);
		$criteria->compare('obj_type',$this->obj_type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}