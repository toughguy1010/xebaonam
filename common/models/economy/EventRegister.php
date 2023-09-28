<?php

/**
 * This is the model class for table "edu_event_register".
 *
 * The followings are the available columns in table 'edu_event_register':
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property integer $event_id
 * @property string $message
 * @property integer $created_time
 * @property integer $modified_time
 */
class EventRegister extends ActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return $this->getTableName('eve_event_register');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, email, phone, event_id', 'required'),
            array('event_id, created_time, modified_time,user_id,quantity', 'numerical', 'integerOnly' => true),
            array('name, email', 'length', 'max' => 255),
            array('phone', 'length', 'max' => 50),
            array('message', 'length', 'max' => 500),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, email, phone, event_id, message, created_time, modified_time, site_id,user_id, status, quantity', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => Yii::t('user', 'user_name'),
            'email' => Yii::t('common', 'email'),
            'phone' => Yii::t('common', 'phone'),
            'event_id' => Yii::t('event', 'event'),
            'message' => Yii::t('common', 'message'),
            'status' => Yii::t('common', 'status'),
            'quantity' => Yii::t('common', 'quantity'),
            'created_time' => Yii::t('common', 'created_time'),
            'modified_time' => Yii::t('common', 'modified_time'),
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('event_id', $this->event_id);
        $criteria->compare('message', $this->message, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('status', $this->status,true);
        $criteria->order = ('id DESC');
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CourseRegister the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeSave()
    {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->modified_time = $this->created_time;
        } else {
            $this->modified_time = time();
        }
        return parent::beforeSave();
    }

    public static function checkRegisted($user_id, $event_id)
    {
        $siteid = Yii::app()->controller->site_id;
        //
        $condition = 'site_id=:site_id AND status=' . self::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        $condition .= ' AND user_id=:user_id';
        $params[':user_id'] = $user_id;

        $condition .= ' AND event_id=:event_id';
        $params[':event_id'] = $event_id;
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('eve_event_register'))
            ->where($condition, $params)
            ->queryAll();
        return $data[0];
    }


}
