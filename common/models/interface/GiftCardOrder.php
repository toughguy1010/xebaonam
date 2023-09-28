<?php

/**
 * This is the model class for table "gift_card_order".
 *
 * The followings are the available columns in table 'gift_card_order':
 * @property string $id
 * @property string $flexible_price
 * @property string $total_price
 * @property string $owner
 * @property string $owner2
 * @property string $owner3
 * @property string $owner4
 * @property string $owner5
 * @property string $owner6
 * @property string $email
 * @property integer $ecard
 * @property string $ecardid
 * @property integer $personalize
 * @property string $personalization_from
 * @property string $personalization_message
 * @property string $created_time
 * @property string $site_id
 * @property integer $type_expiration
 * @property string $expiration_date
 * @property string $payment_status
 * @property string $qrcode
 * @property integer $campaign_id
 */
class GiftCardOrder extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gift_card_order';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('owner, email, flexible_price', 'required'),
            array('ecard, personalize', 'numerical', 'integerOnly' => true),
            array('id', 'length', 'max' => 100),
            array('flexible_price, total_price', 'length', 'max' => 16),
            array('owner, owner2, owner3, owner4, owner5, owner6, email, personalization_from, personalization_message, qrcode', 'length', 'max' => 255),
            array('ecardid, created_time, site_id, expiration_date', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, flexible_price, total_price, owner, owner2, owner3, owner4, owner5, owner6, email, ecard, ecardid, personalize, personalization_from, personalization_message, created_time, site_id, expiration_date, payment_status, qrcode, campaign_id', 'safe'),
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
            'flexible_price' => 'Flexible Price',
            'total_price' => 'Total Price',
            'owner' => 'Owner',
            'owner2' => 'Owner2',
            'owner3' => 'Owner3',
            'owner4' => 'Owner4',
            'owner5' => 'Owner5',
            'owner6' => 'Owner6',
            'email' => 'Email',
            'ecard' => 'Ecard',
            'ecardid' => 'Ecardid',
            'personalize' => 'Personalize',
            'personalization_from' => 'Personalization From',
            'personalization_message' => 'Personalization Message',
            'created_time' => 'Created Time',
            'site_id' => 'Site',
            'type_expiration' => 'Type Expiration',
            'expiration_date' => 'Expiration Date',
            'payment_status' => 'Payment Status',
            'qrcode' => 'Qrcode',
            'campaign_id' => 'Campaign'
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
        $criteria->compare('flexible_price', $this->flexible_price, true);
        $criteria->compare('total_price', $this->total_price, true);
        $criteria->compare('owner', $this->owner, true);
        $criteria->compare('owner2', $this->owner2, true);
        $criteria->compare('owner3', $this->owner3, true);
        $criteria->compare('owner4', $this->owner4, true);
        $criteria->compare('owner5', $this->owner5, true);
        $criteria->compare('owner6', $this->owner6, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('ecard', $this->ecard);
        $criteria->compare('ecardid', $this->ecardid, true);
        $criteria->compare('personalize', $this->personalize);
        $criteria->compare('personalization_from', $this->personalization_from, true);
        $criteria->compare('personalization_message', $this->personalization_message, true);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('site_id', $this->site_id, true);
        $criteria->compare('expiration_date', $this->expiration_date, true);
        $criteria->compare('payment_status', $this->payment_status);
        $criteria->compare('qrcode', $this->qrcode, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return GiftCardOrder the static model class
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

    public static function getOrders() {
        $results = array();
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('gift_card_order')
                ->where('payment_status=:payment_status', array(':payment_status' => 'Completed'))
                ->order('created_time DESC')
                ->queryAll();
        if ($data) {
            foreach ($data as $order) {
                $results[$order['id']] = $order;
                $results[$order['id']]['items'] = self::getItems($order['id']);
            }
        }
        return $results;
    }

    public static function getItems($order_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('gift_card_order_item')
                ->where('order_id=:order_id', array(':order_id' => $order_id))
                ->order('created_time ASC')
                ->queryAll();
        return $data;
    }

}
