<?php

/**
 * This is the model class for table "log_vtcpay".
 *
 * The followings are the available columns in table 'log_vtcpay':
 * @property integer $status
 * @property integer $order_id
 * @property integer $website_id
 * @property string $order_code
 * @property string $amount
 * @property string $sign
 * @property integer $created_time
 * @property integer $site_id
 * @property integer $correct
 */
class LogVtcpay extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'log_vtcpay';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('status, website_id', 'numerical', 'integerOnly' => true),
            array('order_code', 'length', 'max' => 100),
            array('amount, created_time, site_id, order_id', 'length', 'max' => 10),
            array('sign', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('status, website_id, order_code, amount, sign, order_code, created_time, site_id, correct', 'safe', 'on' => 'search'),
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
            'status' => 'Status',
            'website_id' => 'Website',
            'order_code' => 'Order Code',
            'amount' => 'Amount',
            'sign' => 'Sign',
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

        $criteria->compare('status', $this->status);
        $criteria->compare('website_id', $this->website_id);
        $criteria->compare('order_code', $this->order_code, true);
        $criteria->compare('amount', $this->amount, true);
        $criteria->compare('sign', $this->sign, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return LogVtcpay the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
        }
        return parent::beforeSave();
    }

}
