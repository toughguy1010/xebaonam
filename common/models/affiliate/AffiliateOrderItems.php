<?php

/**
 * This is the model class for table "affiliate_order_items".
 *
 * The followings are the available columns in table 'affiliate_order_items':
 * @property string $id
 * @property string $user_id
 * @property string $affiliate_id
 * @property string $affiliate_click_id
 * @property string $affiliate_order_id
 * @property string $order_id
 * @property string $product_id
 * @property string $product_price
 * @property string $product_qty
 * @property string $site_id
 * @property string $created_time
 * @property string $track_commission_percent
 * @property string $commission
 */
class AffiliateOrderItems extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'affiliate_order_items';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, affiliate_id, affiliate_click_id, affiliate_order_id, order_id, product_id, product_qty, site_id, created_time', 'length', 'max' => 10),
            array('product_price, track_commission_percent, commission', 'length', 'max' => 16),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, affiliate_id, affiliate_click_id, affiliate_order_id, order_id, product_id, product_price, product_qty, site_id, created_time, aff_percent', 'safe'),
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
            'user_id' => 'User',
            'affiliate_id' => 'Affiliate',
            'affiliate_click_id' => 'Affiliate Click',
            'affiliate_order_id' => 'Affiliate Order',
            'order_id' => 'Order',
            'product_id' => 'Product',
            'product_price' => 'Product Price',
            'product_qty' => 'Product Qty',
            'site_id' => 'Site',
            'created_time' => 'Created Time',
            'aff_percent' =>Yii::t('translate','aff_percent'),
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
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('affiliate_id', $this->affiliate_id, true);
        $criteria->compare('affiliate_click_id', $this->affiliate_click_id, true);
        $criteria->compare('affiliate_order_id', $this->affiliate_order_id, true);
        $criteria->compare('order_id', $this->order_id, true);
        $criteria->compare('product_id', $this->product_id, true);
        $criteria->compare('product_price', $this->product_price, true);
        $criteria->compare('product_qty', $this->product_qty, true);
        $criteria->compare('site_id', $this->site_id, true);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('aff_percent', $this->aff_percent, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AffiliateOrderItems the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        $this->created_time = time();
        return parent::beforeSave();
    }

    public static function getAllOrderItem($user_id, $options = []) {
        $condition = 't.user_id=:user_id';
        $params = [
            ':user_id' => $user_id
        ];
        if (isset($options['start_date']) && $options['start_date']) {
            $condition .= ' AND t.created_time >= :start_date';
            $start_date_string = $options['start_date'] . ' 00:00:00';
            $start_date = strtotime($start_date_string);
            $params[':start_date'] = $start_date;
        }
        if (isset($options['end_date']) && $options['end_date']) {
            $condition .= ' AND t.created_time <= :end_date';
            $end_date_string = $options['end_date'] . ' 23:59:59';
            $end_date = strtotime($end_date_string);
            $params[':end_date'] = $end_date;
        }
        $data = Yii::app()->db->createCommand()
                ->select('t.*, r.order_status, c.created_time AS click_time')
                ->from('affiliate_order_items t')
                ->rightJoin('orders r', 'r.order_id = t.order_id')
                ->leftJoin('affiliate_click c', 'c.id = t.affiliate_click_id')
                ->where($condition, $params)
                ->order('t.id DESC')
                ->queryAll();
        return $data;
    }

    public static function calculatorCommission($data) {
        $config = AffiliateConfig::model()->findByPk(Yii::app()->controller->site_id);
        //
        $keyComplete = Orders::ORDER_COMPLETE;
        $keyWaiting = Orders::ORDER_WAITFORPROCESS;
        $keyDestroy = Orders::ORDER_DESTROY;
        // init commission
        $commission = [
            $keyComplete => 0,
            $keyWaiting => 0,
            $keyDestroy => 0
        ];
        // init total price
        $totalPrice = [
            $keyComplete => 0,
            $keyWaiting => 0,
            $keyDestroy => 0
        ];
        //
        foreach ($data as $item) {
            if ($item['order_status'] == $keyComplete) {
                $totalPrice[$keyComplete] += $item['product_price'] * $item['product_qty'];
            } else if ($item['order_status'] == $keyWaiting) {
                $totalPrice[$keyWaiting] += $item['product_price'] * $item['product_qty'];
            } else if ($item['order_status'] == $keyDestroy) {
                $totalPrice[$keyDestroy] += $item['product_price'] * $item['product_qty'];
            }
        }
        //
        $commission[$keyComplete] = ($totalPrice[$keyComplete] * $config['commission_order']) / 100;
        $commission[$keyWaiting] = ($totalPrice[$keyWaiting] * $config['commission_order']) / 100;
        $commission[$keyDestroy] = ($totalPrice[$keyDestroy] * $config['commission_order']) / 100;
        //
        return $commission;
    }

}
