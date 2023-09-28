<?php

/**
 * This is the model class for table "se_providers_info".
 *
 * The followings are the available columns in table 'se_providers_info':
 * @property string $provider_id
 * @property integer $site_id
 * @property string $description
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $meta_title
 */
class SeProvidersInfo extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return $this->getTableName('se_providers_info');
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('provider_id', 'required'),
			array('site_id', 'numerical', 'integerOnly'=>true),
			array('provider_id', 'length', 'max'=>11),
			array('meta_keywords, meta_description, meta_title', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('provider_id, site_id, description, meta_keywords, meta_description, meta_title', 'safe'),
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
			'provider_id' => 'provider_id',
			'site_id' => 'Site',
			'description' => 'Description',
			'meta_keywords' => 'Meta Keywords',
			'meta_description' => 'Meta Description',
			'meta_title' => 'Meta Title',
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

		$criteria->compare('provider_id',$this->provider_id,true);
		$criteria->compare('site_id',$this->site_id);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('meta_keywords',$this->meta_keywords,true);
		$criteria->compare('meta_description',$this->meta_description,true);
		$criteria->compare('meta_title',$this->meta_title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SeServicesInfo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
