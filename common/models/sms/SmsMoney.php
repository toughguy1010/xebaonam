<?php

/**
 * This is the model class for table "sms_money".
 *
 * The followings are the available columns in table 'sms_money':
 * @property string $id
 * @property string $site_id
 * @property string $user_id
 * @property string $type_user
 * @property integer $money
 * @property string $money_history
 * @property string $money_used
 * @property string $money_hash
 * @property integer $modified_time
 */
class SmsMoney extends CActiveRecord
{       
        const TYPE_USER_GUEST = 'guest';
        const TYPE_USER_ADMIN = 'admin';
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return ClaTable::getTable('sms_money');
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('money, modified_time', 'numerical', 'integerOnly'=>true),
			array('site_id, user_id', 'length', 'max'=>11),
			array('type_user', 'length', 'max'=>5),
			array('money_history, money_used', 'length', 'max'=>20),
			array('money_hash', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('site_id, user_id, type_user, money, money_history, money_used, money_hash, modified_time', 'safe'),
			array('id, site_id, user_id, type_user, money, money_history, money_used, money_hash, modified_time', 'safe', 'on'=>'search'),
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
			'type_user' => 'Type User',
			'money' => 'Money',
			'money_history' => 'Money History',
			'money_used' => 'Money Used',
			'money_hash' => 'Money Hash',
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
		$criteria->compare('site_id',$this->site_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('type_user',$this->type_user,true);
		$criteria->compare('money',$this->money);
		$criteria->compare('money_history',$this->money_history,true);
		$criteria->compare('money_used',$this->money_used,true);
		$criteria->compare('money_hash',$this->money_hash,true);
		$criteria->compare('modified_time',$this->modified_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SmsMoney the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function findByKey($site_id,$user_id,$type_user){
            return $this->find('site_id=:site_id AND user_id=:user_id AND type_user=:type_user',array(':site_id'=>$site_id,':user_id'=>$user_id,':type_user'=>$type_user));
        }
        
        public function addMoneyViaOrder($order_sms){
            if($order_sms && (int)$order_sms->status_tranfer_money === 0 && (int)$order_sms->status_money === 1){
                $model = $this->findByKey($order_sms->site_id, $order_sms->user_id, $order_sms->type_user);                
                if($model){
                    $model->money = (int)$model->money + (int)$order_sms->order_total_paid;
                    $model->money_history =  $model->money_history + (int)$order_sms->order_total_paid;
                    if($model->save()){
                        $order_sms->status_tranfer_money = 1;
                        $order_sms->save();
                        return true;
                    }
                }else{
                    $model = new SmsMoney();
                    $model->site_id = $order_sms->site_id;
                    $model->user_id = $order_sms->user_id;
                    $model->type_user = $order_sms->type_user;
                    $model->money =(int)$order_sms->order_total_paid;
                    $model->money_history = (int)$order_sms->order_total_paid;
                    if($model->save()){
                        $order_sms->status_tranfer_money = 1;                        
                        $order_sms->save();                         
                        return true;
                    }
                }
            }
            return false;
        }
        
        public function verifyMoney(){
            return $this->id && $this->money_hash ===  ClaGenerate::encrypt(strval($this->money));
        }

        public function beforeSave() {        
            $this->money_hash = ClaGenerate::encrypt(strval($this->money));
            $this->modified_time = time();
            if ($this->isNewRecord) {                                                
                $this->site_id = (!$this->site_id)?Yii::app()->controller->site_id:$this->site_id;
            }
            return parent::beforeSave();
        }
}
