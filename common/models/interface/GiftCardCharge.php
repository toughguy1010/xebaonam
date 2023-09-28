<?php

/**
 * This is the model class for table "gift_card_charge".
 *
 * The followings are the available columns in table 'gift_card_charge':
 * @property string $id
 * @property string $order_item_id
 * @property string $charge_amount
 * @property string $value
 * @property string $balance
 * @property string $charge_date
 * @property string $created_time
 * @property integer $site_id
 */
class GiftCardCharge extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gift_card_charge';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('order_item_id', 'required'),
            array('order_item_id', 'length', 'max' => 100),
            array('charge_amount, value, balance', 'length', 'max' => 16),
            array('created_time, charge_date', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, order_item_id, charge_amount, value, balance, charge_date, created_time, site_id', 'safe'),
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
            'order_item_id' => 'Order Item',
            'charge_amount' => 'Charge Amount',
            'value' => 'Value',
            'balance' => 'Balance',
            'created_time' => 'Created Time',
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
        $criteria->compare('order_item_id', $this->order_item_id, true);
        $criteria->compare('charge_amount', $this->charge_amount, true);
        $criteria->compare('value', $this->value, true);
        $criteria->compare('balance', $this->balance, true);
        $criteria->compare('created_time', $this->created_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return GiftCardCharge the static model class
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

    public static function getHistory($item_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('gift_card_charge')
                ->where('order_item_id=:order_item_id', array(':order_item_id' => $item_id))
                ->order('created_time ASC')
                ->queryAll();
        //
        return $data;
    }

}
