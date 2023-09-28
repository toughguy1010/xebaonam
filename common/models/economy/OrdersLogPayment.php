<?php

/**
 * This is the model class for table "orders_log_payment".
 *
 * The followings are the available columns in table 'orders_log_payment':
 * @property string $id
 * @property integer $order_id
 * @property string $trans_status
 * @property string $merchant_id
 * @property string $merch_txn_ref
 * @property string $order_info
 * @property string $response_code
 * @property string $message
 * @property integer $transaction_no
 * @property string $amount
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $site_id
 */
class OrdersLogPayment extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('orders_log_payment');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('order_id, transaction_no, created_time, modified_time, site_id, type', 'numerical', 'integerOnly' => true),
            array('trans_status, merchant_id, merch_txn_ref, order_info, response_code, message', 'length', 'max' => 255),
            array('amount', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, order_id, trans_status, merchant_id, merch_txn_ref, order_info, response_code, message, transaction_no, amount, created_time, modified_time, site_id, type', 'safe', 'on' => 'search'),
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
            'trans_status' => 'Trans Status',
            'merchant_id' => 'Merchant',
            'merch_txn_ref' => 'Merch Txn Ref',
            'order_info' => 'Order Info',
            'response_code' => 'Response Code',
            'message' => 'Message',
            'transaction_no' => 'Transaction No',
            'amount' => 'Amount',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'type' => 'Type',
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
        $criteria->compare('trans_status', $this->trans_status, true);
        $criteria->compare('merchant_id', $this->merchant_id, true);
        $criteria->compare('merch_txn_ref', $this->merch_txn_ref, true);
        $criteria->compare('order_info', $this->order_info, true);
        $criteria->compare('response_code', $this->response_code, true);
        $criteria->compare('message', $this->message, true);
        $criteria->compare('transaction_no', $this->transaction_no);
        $criteria->compare('amount', $this->amount, true);
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
     * @return OrdersLogPayment the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
