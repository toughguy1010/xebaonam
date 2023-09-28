<?php

/**
 * This is the model class for table "orders_log_sms".
 *
 * The followings are the available columns in table 'orders_log_sms':
 * @property string $id
 * @property integer $order_id
 * @property string $phone
 * @property integer $type
 * @property string $result
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $site_id
 */
class OrdersLogSms extends ActiveRecord {
    
    const TYPE_ADMIN = 1; // Gửi tin nhắn cho admin
    const TYPE_CUSTOMER = 2; // Gửi tin đặt hàng thành công cho khách hàng
    const TYPE_VOUCHER = 3; // Gửi mã voucher cho khách hàng
    const TYPE_BOOK_TABLE = 4; // Gửi mã voucher cho khách hàng khi đặt bàn

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('orders_log_sms');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('order_id, type, created_time, modified_time, site_id', 'numerical', 'integerOnly' => true),
            array('phone, result', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, order_id, phone, type, result, created_time, modified_time, site_id', 'safe'),
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
            'order_id' => 'Order',
            'phone' => 'Phone',
            'type' => 'Type',
            'result' => 'Result',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('order_id', $this->order_id);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('result', $this->result, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('site_id', $this->site_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return OrdersLogSms the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
