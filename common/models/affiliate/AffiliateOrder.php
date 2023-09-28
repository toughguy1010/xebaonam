<?php

/**
 * This is the model class for table "affiliate_order".
 *
 * The followings are the available columns in table 'affiliate_order':
 * @property string $id
 * @property string $user_id
 * @property string $affiliate_id
 * @property string $affiliate_click_id
 * @property string $order_id
 * @property string $product_ids
 * @property string $site_id
 * @property string $created_time
 */
class AffiliateOrder extends ActiveRecord {
    
    const TYPE_PRODUCT = 0;
    const TYPE_TRANSLATE = 2;
    const TYPE_INTERPRETATION = 3;
    const TYPE_BPO = 4;
    const TYPE_CONTACT = 5;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'affiliate_order';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, affiliate_id, affiliate_click_id, order_id, site_id, created_time', 'length', 'max' => 10),
            array('product_ids', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, affiliate_id, order_id, site_id, created_time, type, translate_order_id, bpo_order_id, interpretation_order_id, contact_id', 'safe'),
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
            'affiliate_id' => 'Affiliate',
            'affiliate_click_id' => 'Affiliate Click',
            'order_id' => 'Order',
            'product_ids' => 'Products',
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
        $criteria->compare('affiliate_id', $this->affiliate_id, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('order_id', $this->order_id, true);
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
     * @return AffiliateOrder the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        $this->created_time = time();
        return parent::beforeSave();
    }

    public static function countOrder($order_status, $user_id, $options = []) {
        $condition = 't.user_id=:user_id AND r.order_status=:order_status';
        $params = [
            ':user_id' => $user_id,
            ':order_status' => $order_status
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
        $count = Yii::app()->db->createCommand()
                ->select('COUNT(*)')
                ->from('affiliate_order AS t')
                ->rightJoin('orders AS r', 'r.order_id=t.order_id')
                ->where($condition, $params)
                ->queryScalar();
        return $count;
    }

    public static function getOrder($order_status, $user_id) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('affiliate_order as t')
                ->rightJoin('orders AS r', 'r.order_id = t.order_id')
                ->where('t.user_id=:user_id AND r.order_status=:order_status', [
                    ':user_id' => $user_id,
                    ':order_status' => $order_status
                ])
                ->queryAll();
        return $data;
    }

    public static function getAllOrder($user_id, $options = []) {
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
                ->select('t.*, c.operating_system, r.campaign_source, r.aff_type, r.campaign_name')
                ->from('affiliate_order t')
                ->leftJoin('affiliate_click c', 'c.id = t.affiliate_click_id')
                ->leftJoin('affiliate_link r', 'r.id = t.affiliate_id')
                ->where($condition, $params)
                ->queryAll();
        return $data;
    }

    public static function getOrderStatusName($order_status) {
        $return = '';
        if ($order_status == Orders::ORDER_COMPLETE) {
            $return = 'Thành công';
        } else if ($order_status == Orders::ORDER_DESTROY) {
            $return = 'Hủy';
        } else if ($order_status == Orders::ORDER_WAITFORPROCESS) {
            $return = 'Chờ duyệt';
        }
        return $return;
    }

//    expertrans

    public static function countContact($order_status, $user_id, $options = []) {
        $condition = 'r.status=:status';
        $params = [
            ':status' => $order_status
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
        $count = Yii::app()->db->createCommand()
            ->select('COUNT(*)')
            ->from('expertrans_contact_form AS t')
            ->where($condition, $params)
            ->queryScalar();
        return $count;
    }
    public static function affiliateOrderExpertrans($order_status, $user_id, $options = []) {
        $condition = 'r.status=:status';
        $params = [
            ':status' => $order_status
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

        $count = Yii::app()->db->createCommand()
            ->select('COUNT(*)')
            ->from('expertrans_contact_form AS t')
            ->where($condition, $params)
            ->queryScalar();
        return $count;
    }

    public static function countOrderExpertrans($order_status, $user_id, $options = []) {
        $condition = 't.user_id=:user_id AND r.`status`=:order_status';
        $params = [
            ':user_id' => $user_id,
            ':order_status' => $order_status,
        ];
        if($options['type']){
            $condition .= ' AND t.type=:type';
            $params[':type'] = $options['type'];
        }

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
        $count = Yii::app()->db->createCommand()
            ->select('COUNT(*)')
            ->from('affiliate_order AS t');
           if ($options['type'] == AffiliateOrder::TYPE_TRANSLATE) {
               $count->Join('translate_order AS r', 'r.id=t.order_id');
           } elseif ($options['type'] == AffiliateOrder::TYPE_INTERPRETATION) {
               $count->Join('interpretation_order AS r', 'r.id=t.order_id');
           } elseif ($options['type'] == AffiliateOrder::TYPE_BPO) {
               $count->Join('bpo_form AS r', 'r.id=t.order_id');
           } elseif ($options['type'] == AffiliateOrder::TYPE_CONTACT) {
               $count->Join('expertrans_contact_form AS r', 'r.id=t.order_id');
           };
        $count->where($condition, $params);

        $result = $count->queryScalar();

        return $result;
    }

    public static function getOrderExpertrans($order_status, $user_id, $options = []) {
        $condition = 't.user_id=:user_id AND r.`status`=:order_status';
        $params = [
            ':user_id' => $user_id,
            ':order_status' => $order_status,
        ];
        if($options['type']){
            $condition .= ' AND t.type=:type';
            $params[':type'] = $options['type'];
        }

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
        $count = Yii::app()->db->createCommand()
            ->select('*')
            ->from('affiliate_order AS t');
        if ($options['type'] == AffiliateOrder::TYPE_TRANSLATE) {
            $count->Join('translate_order AS r', 'r.id=t.order_id');
        } elseif ($options['type'] == AffiliateOrder::TYPE_INTERPRETATION) {
            $count->Join('interpretation_order AS r', 'r.id=t.order_id');
        } elseif ($options['type'] == AffiliateOrder::TYPE_BPO) {
            $count->Join('bpo_form AS r', 'r.id=t.order_id');
        } elseif ($options['type'] == AffiliateOrder::TYPE_CONTACT) {
            $count->Join('expertrans_contact_form AS r', 'r.id=t.order_id');
        };
        $count->where($condition, $params);

        $data = $count->queryAll();
        $result = 0;
        if(count($data)){
            foreach ($data as $value){
                $result+= ($value['aff_percent'] * (float) $value['total_price'] /100);
            }
        }
        return (float)$result;
    }

    public static function calculatorCommissionExpertrans($user_id, $options) {
        // Đơn hàng chờ
        $options['type'] = AffiliateOrder::TYPE_TRANSLATE;
        $orderWaitingCount = AffiliateOrder::getOrderExpertrans(TranslateOrder::ORDER_WAITFORPROCESS, $user_id, $options);
        // Đơn hàng hoàn thành
        $orderCompleteCount = AffiliateOrder::getOrderExpertrans(TranslateOrder::ORDER_COMPLETE, $user_id, $options);
        // Đơn hàng hủy
        $orderDestroyCount = AffiliateOrder::getOrderExpertrans(TranslateOrder::ORDER_DESTROY, $user_id, $options);
        //

        $options['type'] = AffiliateOrder::TYPE_BPO;
        $orderBpoWaitingCount = AffiliateOrder::getOrderExpertrans(BpoForm::ORDER_WAITFORPROCESS, $user_id, $options);
        // Đơn hàng hoàn thành
        $orderBpoCompleteCount = AffiliateOrder::getOrderExpertrans(BpoForm::ORDER_COMPLETE, $user_id, $options);
        // Đơn hàng hủy
        $orderBpoDestroyCount = AffiliateOrder::getOrderExpertrans(BpoForm::ORDER_COMPLETE, $user_id, $options);

        $options['type'] = AffiliateOrder::TYPE_CONTACT;
        $orderContactWaitingCount = AffiliateOrder::getOrderExpertrans(ExpertransContactFormModel::STATUS_WAITING, $user_id, $options);
        // Đơn hàng hoàn thành
        $orderContactCompleteCount = AffiliateOrder::getOrderExpertrans(ExpertransContactFormModel::STATUS_ACTIVED, $user_id, $options);
        // Đơn hàng hủy
        $orderContactDestroyCount = AffiliateOrder::getOrderExpertrans(ExpertransContactFormModel::STATUS_DEACTIVED, $user_id, $options);

        $options['type'] = AffiliateOrder::TYPE_INTERPRETATION;
        $orderInterWaitingCount = AffiliateOrder::getOrderExpertrans(InterpretationOrder::ORDER_WAITFORPROCESS, $user_id, $options);

        // Đơn hàng hoàn thành
        $orderInterCompleteCount = AffiliateOrder::getOrderExpertrans(InterpretationOrder::ORDER_COMPLETE, $user_id, $options);
        // Đơn hàng hủy
        $orderInterDestroyCount = AffiliateOrder::getOrderExpertrans(InterpretationOrder::ORDER_DESTROY, $user_id, $options);

        $config = AffiliateConfig::model()->findByPk(Yii::app()->controller->site_id);
        //
        $keyComplete = TranslateOrder::ORDER_COMPLETE;
        $keyWaiting = TranslateOrder::ORDER_WAITFORPROCESS;
        $keyDestroy = TranslateOrder::ORDER_DESTROY;
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
        $commission[$keyWaiting] = $orderWaitingCount + $orderBpoWaitingCount + $orderContactWaitingCount + $orderInterWaitingCount;
        $commission[$keyComplete] =  $orderCompleteCount +  $orderBpoCompleteCount + $orderContactCompleteCount + $orderInterCompleteCount;
        $commission[$keyDestroy] = $orderDestroyCount +  $orderBpoDestroyCount + $orderContactDestroyCount + $orderInterDestroyCount;
        //
        return $commission;
    }

    public static function calAffMoneyByTranslateOrderId($id){
        $order = TranslateOrder::model()->findByPk($id);
        if($order){

        }
        return 0;
    }


}
