<?php

/**
 * This is the model class for table "gift_card_order_item".
 *
 * The followings are the available columns in table 'gift_card_order_item':
 * @property string $id
 * @property string $order_id
 * @property string $owner
 * @property string $flexible_price
 * @property string $total_price
 * @property string $balance
 * @property string $site_id
 * @property string $created_time
 * @property integer $block
 */
class GiftCardOrderItem extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gift_card_order_item';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('order_id, owner', 'required'),
            array('id, order_id', 'length', 'max' => 100),
            array('owner', 'length', 'max' => 255),
            array('flexible_price, total_price, balance', 'length', 'max' => 16),
            array('site_id, created_time', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, order_id, owner, flexible_price, total_price, balance, site_id, created_time, block', 'safe'),
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
            'owner' => 'Owner',
            'flexible_price' => 'Flexible Price',
            'total_price' => 'Total Price',
            'balance' => 'Balance',
            'site_id' => 'Site',
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
        $criteria->compare('order_id', $this->order_id, true);
        $criteria->compare('owner', $this->owner, true);
        $criteria->compare('flexible_price', $this->flexible_price, true);
        $criteria->compare('total_price', $this->total_price, true);
        $criteria->compare('balance', $this->balance, true);
        $criteria->compare('site_id', $this->site_id, true);
        $criteria->compare('created_time', $this->created_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return GiftCardOrderItem the static model class
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

    public static function getItemsByOrderid($order_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('gift_card_order_item')
                ->where('order_id=:order_id', array(':order_id' => $order_id))
                ->order('created_time ASC')
                ->queryAll();
        return $data;
    }

}
