<?php

/**
 * This is the model class for table "popup_register_product".
 *
 * The followings are the available columns in table 'popup_register_product':
 * @property string $id
 * @property integer $site_id
 * @property integer $product_id
 * @property string $name
 * @property string $desc
 * @property string $avatar_path
 * @property string $avatar_name
 * @property integer $time_start
 * @property integer $time_end
 * @property integer $status
 * @property integer $user_created
 * @property integer $user_updated
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $order
 */
class PopupRegisterProducts extends ActiveRecord
{
	public $avatar;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'popup_register_product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('site_id, product_id, status, user_created, user_updated, created_at, updated_at, order', 'numerical', 'integerOnly'=>true),
			array('name, avatar_path, avatar_name', 'length', 'max'=>250),
			array('desc, avatar, time_start, time_end', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, site_id, product_id, name, desc, avatar_path, avatar_name, time_start, time_end, status, user_created, user_updated, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'product_id' => 'Product',
			'name' => 'Name',
			'desc' => 'Desc',
			'avatar_path' => 'Avatar Path',
			'avatar_name' => 'Avatar Name',
			'time_start' => 'Time Start',
			'time_end' => 'Time End',
			'status' => 'Status',
			'user_created' => 'User Created',
			'user_updated' => 'User Updated',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
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
		$criteria->compare('site_id',$this->site_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('avatar_path',$this->avatar_path,true);
		$criteria->compare('avatar_name',$this->avatar_name,true);
		$criteria->compare('time_start',$this->time_start);
		$criteria->compare('time_end',$this->time_end);
		$criteria->compare('status',$this->status);
		$criteria->compare('user_created',$this->user_created);
		$criteria->compare('user_updated',$this->user_updated);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('updated_at',$this->updated_at);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PopupRegisterProduct the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function beforeSave() {
        if ($this->isNewRecord) {
            $this->user_created = $this->user_updated = Yii::app()->user->id;
            $this->created_at = $this->updated_at = time();
        } else {
			$this->user_updated = Yii::app()->user->id;
            $this->updated_at = time();
        }
        $this->time_start = ($this->time_start < 10000 && $this->time_start) ? strtotime($this->time_start) : $this->time_start;
        $this->time_end = ($this->time_end < 10000 && $this->time_end) ? strtotime($this->time_end) : $this->time_end;
        return parent::beforeSave();
    }

    public static function getPopupArr() {
        $results = array();
        $data = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('popup_register_product'))
                ->where('site_id=' . Yii::app()->siteinfo['site_id'])
                ->queryAll();
        foreach ($data as $item) {
            $results[$item['id']] = $item['name'];
        }
        //
        return $results;
    }

    public static function getPopupModelALl() {
        $results = array();
        $results = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('popup_register_product'))
                ->where('site_id=' . Yii::app()->siteinfo['site_id'])
                ->queryAll();
        return $results;
    }
}
