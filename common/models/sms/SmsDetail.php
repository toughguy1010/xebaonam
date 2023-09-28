<?php

/**
 * This is the model class for table "sms_detail".
 *
 * The followings are the available columns in table 'sms_detail':
 * @property string $id
 * @property integer $sms_id
 * @property string $phone
 * @property string $status
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $site_id
 */
class SmsDetail extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return ClaTable::getTable('sms_detail');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('sms_id, phone', 'required'),
            array('sms_id, status, created_time, modified_time, site_id', 'numerical', 'integerOnly' => true),
            array('message', 'length', 'max' => 255),
            array('phone', 'length', 'max' => 20),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, sms_id, phone, status, created_time, modified_time, site_id, message', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'sms_id' => 'Sms',
            'phone' => Yii::t('sms', 'phone'),
            'status' => 'Status',
            'message' => Yii::t('sms', 'message_response'),
            'created_time' => Yii::t('sms', 'created_time'),
            'modified_time' => Yii::t('sms', 'modified_time'),
            'site_id' => 'Site',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $this->site_id = Yii::app()->controller->site_id;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('sms_id', $this->sms_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => '50',
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SmsDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        if ($this->isNewRecord) {
            $this->site_id = Yii::app()->controller->site_id;
            $this->created_time = time();
        }
        return parent::beforeSave();
    }

}
