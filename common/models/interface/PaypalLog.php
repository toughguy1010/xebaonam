<?php

/**
 * This is the model class for table "paypal_log".
 *
 * The followings are the available columns in table 'paypal_log':
 * @property string $id
 * @property string $item_name
 * @property string $item_number
 * @property string $payment_status
 * @property string $payment_amount
 * @property string $payment_currency
 * @property string $receiver_email
 * @property string $payer_email
 * @property string $created_at
 * @property string $site_id
 * @property string $gift_card_order_id
 */
class PaypalLog extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'paypal_log';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('item_name, item_number, payment_status, payment_currency, receiver_email, payer_email', 'length', 'max' => 255),
            array('payment_amount', 'length', 'max' => 16),
            array('created_at, site_id', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, item_name, item_number, payment_status, payment_amount, payment_currency, receiver_email, payer_email, created_at, site_id, gift_card_order_id', 'safe'),
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
            'item_name' => 'Item Name',
            'item_number' => 'Item Number',
            'payment_status' => 'Payment Status',
            'payment_amount' => 'Payment Amount',
            'payment_currency' => 'Payment Currency',
            'receiver_email' => 'Receiver Email',
            'payer_email' => 'Payer Email',
            'created_at' => 'Created At',
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
        $criteria->compare('item_name', $this->item_name, true);
        $criteria->compare('item_number', $this->item_number, true);
        $criteria->compare('payment_status', $this->payment_status, true);
        $criteria->compare('payment_amount', $this->payment_amount, true);
        $criteria->compare('payment_currency', $this->payment_currency, true);
        $criteria->compare('receiver_email', $this->receiver_email, true);
        $criteria->compare('payer_email', $this->payer_email, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('site_id', $this->site_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PaypalLog the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
