<?php

/**
 * This is the model class for table "lov_my_save_job".
 *
 * The followings are the available columns in table 'lov_my_save_job':
 * @property integer $savejob_id
 * @property integer $user_id
 * @property integer $news_id
 */
class MySaveJob extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MySaveJob the static model class
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
		return 'lov_my_save_job';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('savejob_id, user_id, news_id', 'required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('savejob_id, user_id, news_id,created_date', 'safe'),
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
		'trade_news'    => array(self::BELONGS_TO, 'RecruitmentNews', 'news_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'savejob_id' => 'Savejob',
			'user_id' => 'User',
			'news_id' => 'News',
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

		$criteria->compare('savejob_id',$this->savejob_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('news_id',$this->news_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}