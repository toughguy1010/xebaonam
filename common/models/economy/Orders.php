<?php

/**
 * This is the model class for table "orders".
 *
 * The followings are the available columns in table 'orders':
 * @property integer $order_id
 * @property integer $user_id
 * @property string $shipping_name
 * @property string $shipping_email
 * @property string $shipping_address
 * @property string $shipping_phone
 * @property string $shipping_city
 * @property string $shipping_district
 * @property string $billing_name
 * @property string $billing_email
 * @property string $billing_address
 * @property string $billing_phone
 * @property string $billing_zipcode
 * @property string $billing_city
 * @property string $billing_district
 * @property string $payment_method
 * @property string $transport_method
 * @property string $coupon_code
 * @property integer $order_status
 * @property double $order_total
 * @property double $transport_freight
 * @property double $vat
 * @property string $currency
 * @property string $ip_address
 * @property string $key
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $site_id
 * @property integer $bonus_point_used
 * @property integer $shop_id
 * @property double $discount_for_dealers
 * @property double $old_order_total
 * @property double $wait_bonus_point
 * @property double $donate_total
 * @property string $tax_code
 * @property string $transaction_data
 */
class Orders extends ActiveRecord
{

    const ORDER_WAITFORPROCESS = 0;
    const ORDER_WAITFORPAYMENT = 1;
    const ORDER_WAITFORCOMPLETE = 2;
    const ORDER_WAITFORDISBURSE = 3; // Chờ xuất hàng
    const ORDER_WAITFORRECEIVE = 4; // Chờ nhận hàng
    const ORDER_DESTROY = 5; // Hủy đơn hàng
    const ORDER_COMPLETE = 6; // Hoàn thành
    //
    const ORDER_PAYMENT_STATUS_NONE = 0; // chưa xử lý
    const ORDER_PAYMENT_STATUS_PAID = 1; // đã thanh toán
    const ORDER_PAYMENT_STATUS_PROCESSING = 2; // đang xử lý
    //
    const ORDER_TRANSPORT_NONE = 0; // Chưa giao hàng
    const ORDER_TRANSPORT_PROCESSING = 2; // Đang giao hàng
    const ORDER_TRANSPORT_SUCCESS = 1; // Đã giao hàng
    //
    const PAYMENT_METHOD_AFTER = 2;
    const PAYMENT_METHOD_ONLINE = 3;
    const PAYMENT_METHOD_ONEPAY = 8; // thanh toán one pay
    const PAYMENT_METHOD_ONEPAY_QUOCTE = 9; // thanh toán one pay quốc tế
    const PAYMENT_METHOD_PAYPAL = 10; // thanh toán paypal
    //
    const PAYMENT_METHOD_VTCPAY = 20; // thanh toán online với vtc pay
    //
    // Khóa bí mật - được cấp bởi OnePAY
    const SECURE_SECRET = 'A3EFDFABA8653DF2342E8DAC29B51AF0';
    //
    const ORDER_NOTVIEWED = 0;
    const ORDER_VIEWED = 1;
    //
    const PAYMENT_METHOD_TTTM = 'TTTM'; // thanh toán tiền mặt
    const PAYMENT_METHOD_NL = 'NL'; // thanh toán bằng ví điện tử ngân lượng
    const PAYMENT_METHOD_ATM_ONLINE = 'ATM_ONLINE'; // thanh toán online bằng thẻ ngân hàng nội địa
    const PAYMENT_METHOD_IB_ONLINE = 'IB_ONLINE'; // thanh toán bằng Internet Banking
    const PAYMENT_METHOD_ATM_OFFLINE = 'ATM_OFFLINE'; // thanh toán atm offline
    const PAYMENT_METHOD_NH_OFFLINE = 'NH_OFFLINE'; // thanh toán tại văn phòng ngân hàng
    const PAYMENT_METHOD_VNPAY = 'VNPAY'; // thanh toán tại văn phòng ngân hàng
    const PAYMENT_METHOD_VISA = 'VISA'; // thanh toán bằng thẻ visa hoặc mastercard
    //
    const PAYMENT_AMORTIZATION = 'AMORTIZATION'; // thanh toán trả góp

    public $from_date = null;
    public $to_date = null;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return $this->getTableName('orders');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('shipping_address, billing_name, billing_address, payment_method, transport_method, ip_address, key', 'required'),
            array('user_id, order_status, created_time, modified_time', 'numerical', 'integerOnly' => true),
            array('order_total, order_total_paid, payment_status, transport_status, bonus_point_used, donate_total, price_ship', 'numerical'),
            array('shipping_name, shipping_email, shipping_address, billing_name, billing_email, billing_address, key', 'length', 'max' => 100),
            array('shipping_city, billing_city', 'length', 'max' => 4),
            array('shipping_district, billing_district, billing_ward', 'length', 'max' => 5),
            array('billing_phone, shipping_phone, coupon_code', 'length', 'max' => 32),
//            array('discount_for_dealers','numerical', 'integerOnly'=>true, 'min'=>0, 'max' => 100),
            array('payment_method, transport_method', 'length', 'max' => 128),
            array('payment_method_child', 'length', 'max' => 10),
            array('ip_address', 'length', 'max' => 96),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('bank_id,order_id, user_id, shipping_name, shipping_email, shipping_address, shipping_phone, shipping_city, shipping_ward, billing_name, billing_email, billing_address, billing_phone, billing_city, billing_zipcode, payment_method, payment_method_child, transport_method, coupon_code, order_status, order_total, order_total_paid, ip_address, key, created_time, modified_time,note, site_id, transport_freight, payment_status, transport_status, shipping_district, billing_district, vat,bonus_point_used, shop_id,discount_for_dealers,old_order_total,to_date,from_date,wait_bonus_point, donate_total, discount_percent, tax_code, transaction_data', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'order_id' => Yii::t('shoppingcart', 'order'),
            'user_id' => 'User',
            'shipping_name' => 'Shipping Name',
            'shipping_email' => 'Shipping Email',
            'shipping_address' => 'Shipping Address',
            'shipping_phone' => 'Shipping Phone',
            'shipping_city' => 'Shipping City',
            'billing_name' => 'Billing Name',
            'billing_email' => 'Billing Email',
            'billing_address' => 'Billing Address',
            'billing_phone' => 'Billing Phone',
            'billing_city' => 'Billing City',
            'billing_zipcode' => 'Billing Zipcode',
            'payment_method' => Yii::t('shoppingcart', 'payment_method'),
            'transport_method' => Yii::t('shoppingcart', 'transport_method'),
            'coupon_code' => 'Coupon Code',
            'order_total' => Yii::t('common', 'total'),
            'ip_address' => 'Ip Address',
            'key' => 'Key',
            'created_time' => Yii::t('common', 'created_time2'),
            'note' => Yii::t('common', 'note'),
            'modified_time' => 'Modified Time',
            'order_status' => Yii::t('shoppingcart', 'order_status'),
            'payment_status' => Yii::t('shoppingcart', 'payment_status'),
            'transport_status' => Yii::t('shoppingcart', 'transport_status'),
            'bank_id' => Yii::t('shoppingcart', 'Tài khoản ngân hàng'),
            'vat' => 'VAT',
            'discount_for_dealers' => Yii::t('shoppingcart', 'discount_for_dealers'),
            'old_order_total' => Yii::t('shoppingcart', 'old_order_total'),
            'bonus_point_used' => Yii::t('shoppingcart', 'bonus_point_used'),
            'from_date' => Yii::t('shoppingcart', 'from_date'),
            'to_date' => Yii::t('shoppingcart', 'to_date'),
            'wait_bonus_point' => Yii::t('shoppingcart', 'wait_bonus_point'),
            'donate_total' => Yii::t('shoppingcart', 'donate_total'),
            'tax_code' => Yii::t('shoppingcart', 'tax_code'),
            'discount_percent' => Yii::t('shoppingcart', 'discount_percent'),
            'transport_freight' => Yii::t('shoppingcart', 'transport_freight')
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
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        if (!$this->site_id) {
            $this->site_id = Yii::app()->controller->site_id;
        }
        $criteria->compare('order_id', $this->order_id);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('shipping_name', $this->shipping_name, true);
        $criteria->compare('shipping_email', $this->shipping_email, true);
        $criteria->compare('shipping_address', $this->shipping_address, true);
        $criteria->compare('shipping_phone', $this->shipping_phone, true);
        $criteria->compare('shipping_city', $this->shipping_city, true);
        $criteria->compare('billing_name', $this->billing_name, true);
        $criteria->compare('billing_email', $this->billing_email, true);
        $criteria->compare('billing_address', $this->billing_address, true);
        $criteria->compare('billing_phone', $this->billing_phone, true);
        $criteria->compare('billing_city', $this->billing_city, true);
        $criteria->compare('payment_method', $this->payment_method, true);
        $criteria->compare('transport_method', $this->transport_method, true);
        $criteria->compare('coupon_code', $this->coupon_code, true);
        $criteria->compare('order_status', $this->order_status);
        $criteria->compare('order_total', $this->order_total);
        $criteria->compare('ip_address', $this->ip_address, true);
        $criteria->compare('key', $this->key, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('shop_id', $this->shop_id);
        $criteria->compare('wait_bonus_point', $this->wait_bonus_point);
        $criteria->compare('donate_total', $this->donate_total);
        $criteria->addCondition('order_status<>' . self::STATUS_DELETED);
        if ($this->from_date) {
            $this->from_date = (int)strtotime($this->from_date);
        } else {
            $this->from_date = 0;
        }
        if ($this->to_date) {
            $this->to_date = (int)strtotime($this->to_date);
        } else {
            $this->to_date = time();
        }
        $criteria->addBetweenCondition('created_time', $this->from_date, $this->to_date, "AND");
        //
        $criteria->order = 'created_time DESC';
        //

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                'pageVar' => ClaSite::PAGE_VAR,
            ),
        ));
    }

    public function searchBonusPoint($point_used = false)
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        if (!$this->site_id) {
            $this->site_id = Yii::app()->controller->site_id;
        }

        $criteria->compare('order_id', $this->order_id);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('shipping_name', $this->shipping_name, true);
        $criteria->compare('shipping_email', $this->shipping_email, true);
        $criteria->compare('shipping_address', $this->shipping_address, true);
        $criteria->compare('shipping_phone', $this->shipping_phone, true);
        $criteria->compare('shipping_city', $this->shipping_city, true);
        $criteria->compare('billing_name', $this->billing_name, true);
        $criteria->compare('billing_email', $this->billing_email, true);
        $criteria->compare('billing_address', $this->billing_address, true);
        $criteria->compare('billing_phone', $this->billing_phone, true);
        $criteria->compare('billing_city', $this->billing_city, true);
        $criteria->compare('payment_method', $this->payment_method, true);
        $criteria->compare('transport_method', $this->transport_method, true);
        $criteria->compare('coupon_code', $this->coupon_code, true);
        $criteria->compare('order_status', $this->order_status);
        $criteria->compare('order_total', $this->order_total);
        $criteria->compare('ip_address', $this->ip_address, true);
        $criteria->compare('key', $this->key, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('shop_id', $this->shop_id);
        $criteria->compare('wait_bonus_point', $this->wait_bonus_point);
        $criteria->compare('donate_total', $this->donate_total);
        $criteria->addCondition('wait_bonus_point<>' . 0);
        $criteria->addCondition('order_status<>' . 5);
        if ($point_used) {
            $criteria->addCondition('bonus_point_used >' . 0);
        } else {
            $criteria->addCondition('order_status<>' . self::STATUS_DELETED);
        }
        if ($this->from_date) {
            $this->from_date = (int)strtotime($this->from_date);
        } else {
            $this->from_date = 0;
        }
        if ($this->to_date) {
            $this->to_date = (int)strtotime($this->to_date);
        } else {
            $this->to_date = time();
        }
        $criteria->addBetweenCondition('created_time', $this->from_date, $this->to_date, "AND");
        //
        $criteria->order = 'created_time DESC';
        //

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                'pageVar' => ClaSite::PAGE_VAR,
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Orders the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeSave()
    {
        if ($this->isNewRecord) {
//            $this->user_id = Yii::app()->user->id;
            $this->created_time = time();
        } else {
            $this->modified_time = time();
        }
        return parent::beforeSave();
    }

    function getLabelId()
    {
        return '#OR-' . $this->order_id;
    }

    /**
     * delete order
     * @return boolean
     * @throws CDbException
     */
    public function delete()
    {
        if (!$this->getIsNewRecord()) {
            Yii::trace(get_class($this) . '.delete()', 'system.db.ar.CActiveRecord');
            if ($this->beforeDelete()) {
                $this->order_status = self::STATUS_DELETED;
                $result = $this->save();
                $this->afterDelete();
                return $result;
            } else {
                return false;
            }
        } else {
            throw new CDbException(Yii::t('yii', 'The active record cannot be deleted because it is new.'));
        }
    }

    /**
     * return payment method
     * @return type
     */
    public static function getPaymentMethod()
    {

        // khong dung key 3 vi dang dung cho thanh toan online check bien self::PAYMENT_METHOD_ONLINE
        $site_id = Yii::app()->controller->site_id;
        //Nếu là nhà hàng gia vien
        $res = array(
            1 => Yii::t('shoppingcart', 'payment_atshop'),
            2 => Yii::t('shoppingcart', 'payment_receive'),
            self::PAYMENT_METHOD_ATM_OFFLINE => Yii::t('shoppingcart', 'payment_atm'),
        );


        // check payment one pay
        if (SitePayment::checkPaymentType(SitePayment::TYPE_ONEPAY)) {
            $res[self::PAYMENT_METHOD_ONEPAY] = Yii::t('shoppingcart', 'payment_onepay');
        }
        if (SitePayment::checkPaymentType(SitePayment::TYPE_ONEPAY_QUOCTE)) {
            $res[self::PAYMENT_METHOD_ONEPAY_QUOCTE] = Yii::t('shoppingcart', 'payment_onepay_quocte');
        }
        if (SitePayment::checkPaymentType(SitePayment::TYPE_BAOKIM)) {
            $res[self::PAYMENT_METHOD_ONLINE] = Yii::t('shoppingcart', 'payment_online');
        }
        if (SitePayment::checkPaymentType(SitePayment::TYPE_VTCPAY)) {
            $res[self::PAYMENT_METHOD_VTCPAY] = Yii::t('shoppingcart', 'payment_vtc');
        }
        if (SitePayment::checkPaymentType(SitePayment::TYPE_PAYPAL)) {
            $res[self::PAYMENT_METHOD_PAYPAL] = 'Thanh toán Paypal';
        }
//        if (SitePayment::checkPaymentType(SitePayment::TYPE_ALEPAY)) {
//            $res[self::PAYMENT_AMORTIZATION] = 'Thanh toán trả góp qua Alepay';
//        }
        return $res;
    }

    public static function vOnline()
    {
        return array(
            1 => Yii::t('shoppingcart', 'payment_online_vn'),
            //'baokim' => Yii::t('shoppingcart', 'payment_online_baokim'),
            //3 => Yii::t('shoppingcart', 'payment_online_internet_banking'),
            //4 => Yii::t('shoppingcart', 'payment_online_atm_transfer'),
            //5 => Yii::t('shoppingcart', 'payment_online_bank_transfer'),
            //2 => Yii::t('shoppingcart', 'payment_online_visa'),
        );
    }

    /**
     * get payment method info
     * @param type $method_id
     * @return type
     */
    public static function getPaymentMethodInfo($method_id)
    {
        if ($method_id) {
            if (self::isPaymentMethodNganluong($method_id)) {
                $pm = self::nganluongArray();
                return isset($pm[$method_id]) ? $pm[$method_id] : null;
            } else {
                $pm = self::getPaymentMethod();
                return isset($pm[$method_id]) ? $pm[$method_id] : null;
            }
        }
    }

    /**
     * return transport method
     */
    public static function getTranportMethod()
    {
        return array(
            1 => array(
                'name' => 'Miễn phí vận chuyển trong 5km',
                'price' => 0,
                'time' => 0,
            ),
        );
    }

    public static function getOrdersByUserIds($options = [])
    {
        $condition = "user_id=:user_id";
        if (isset($options['order_status'])) {
            if ($options['order_status'] == 1000) {
                $condition .= " AND order_status!=4";
            } else {
                $condition .= " AND order_status=" . $options['order_status'];
            }
        }
        $params[':user_id'] = Yii::app()->user->id;
        if (isset($options['user_id']) && $options['user_id']) {
            $params[':user_id'] = $options['user_id'];
        }
        $orders = Yii::app()->db->createCommand()->select()
            ->from(self::model()->getTableName('orders'))
            ->order('order_id DESC')
            ->where($condition, $params)
            ->queryAll();
        if ($orders) {
            foreach ($orders as $key => $order) {
                $orders[$key]['products'] = OrderProducts::getProductsDetailInOrder($order['order_id']);
            }
        }
        return $orders;
    }


    /**
     * get transport method info
     * @param type $method_id
     * @return type
     */
    public static function getTransportMethodInfo($method_id)
    {
        if ($method_id) {
            $tm = self::getTranportMethod();
            return isset($tm[$method_id]) ? $tm[$method_id] : null;
        }
    }

    /**
     * @hungtm
     * trả về các trạng thái của đơn hàng
     * @return type
     */
    public static function getStatusArr()
    {
        return array(
            self::ORDER_WAITFORPROCESS => Yii::t('shoppingcart', 'order_waitforprocess'),
            self::ORDER_DESTROY => Yii::t('shoppingcart', 'order_destroy'),
            self::ORDER_COMPLETE => Yii::t('shoppingcart', 'order_complete'),
//            11 => Yii::t('shoppingcart', 'order_destroy'),
        );
    }

    /**
     * @hungtm
     * trả về các trạng thái thanh toán của đơn hàng
     * @return type
     */
    public static function getPaymentStatusArr()
    {
        return array(
            self::ORDER_PAYMENT_STATUS_NONE => Yii::t('shoppingcart', 'payment_none'),
            self::ORDER_PAYMENT_STATUS_PAID => Yii::t('shoppingcart', 'payment_paid'),
        );
    }

    /**
     * @hungtm
     * trả về các trạng thái giao hàng của đơn hàng
     * @return type
     */
    public static function getTransportStatusArr()
    {
        return array(
            self::ORDER_TRANSPORT_NONE => Yii::t('shoppingcart', 'transport_none'),
            self::ORDER_TRANSPORT_PROCESSING => Yii::t('shoppingcart', 'transport_processing'),
            self::ORDER_TRANSPORT_SUCCESS => Yii::t('shoppingcart', 'transport_success'),
        );
    }

    /**
     * return total price text
     */
    public function getTotalPriceText()
    {
        if ($this->isNewRecord) {
            return '';
        }

        return Product::getPriceText(array('price' => $this->order_total, 'currency' => $this->currency));
    }

    /**
     * get response description from OnePAY
     * @param type $responseCode
     * @return string
     */
    public static function getResponseDescription($responseCode)
    {
        switch ($responseCode) {
            case "0":
                $result = "Giao dịch thành công - Approved";
                break;
            case "1":
                $result = "Ngân hàng từ chối giao dịch - Bank Declined";
                break;
            case "3":
                $result = "Mã đơn vị không tồn tại - Merchant not exist";
                break;
            case "4":
                $result = "Không đúng access code - Invalid access code";
                break;
            case "5":
                $result = "Số tiền không hợp lệ - Invalid amount";
                break;
            case "6":
                $result = "Mã tiền tệ không tồn tại - Invalid currency code";
                break;
            case "7":
                $result = "Lỗi không xác định - Unspecified Failure ";
                break;
            case "8":
                $result = "Số thẻ không đúng - Invalid card Number";
                break;
            case "9":
                $result = "Tên chủ thẻ không đúng - Invalid card name";
                break;
            case "10":
                $result = "Thẻ hết hạn/Thẻ bị khóa - Expired Card";
                break;
            case "11":
                $result = "Thẻ chưa đăng ký sử dụng dịch vụ - Card Not Registed Service(internet banking)";
                break;
            case "12":
                $result = "Ngày phát hành/Hết hạn không đúng - Invalid card date";
                break;
            case "13":
                $result = "Vượt quá hạn mức thanh toán - Exist Amount";
                break;
            case "21":
                $result = "Số tiền không đủ để thanh toán - Insufficient fund";
                break;
            case "99":
                $result = "Người sủ dụng hủy giao dịch - User cancel";
                break;
            default:
                $result = "Giao dịch thất bại - Failured";
        }
        return $result;
    }

    /**
     * @hungtm
     * get total shipfee
     */
    public static function getShipfee($province_id, $district_id)
    {
        $shipfee_weight = self::getShipfeeWeight();
        if ($province_id && $district_id) {
            $shipfee_position = self::getShipfeeProvinceDistrict($province_id, $district_id);
        } else if ($province_id) {
            $shipfee_position = self::getShipfeeProvince($province_id);
        }
        return $shipfee_weight + $shipfee_position;
    }

    public static function getShipfeeProvinceDistrict($province_id, $district_id)
    {
        $shipfee = 0;
        $data_shipfee = SiteConfigShipfee::getAllConfigShipfee();
        $data_compare = array();
        foreach ($data_shipfee as $shipfee_item) {
            $key = $shipfee_item['province_id'] . $shipfee_item['district_id'];
            $data_compare[$key] = $shipfee_item;
        }
        $key_compare1 = $province_id . $district_id;
        $key_compare2 = $province_id . 'all';
        $key_compare3 = 'allall';
        if (isset($data_compare[$key_compare1]) && !empty($data_compare[$key_compare1])) {
            $shipfee += $data_compare[$key_compare1]['price'];
        } else if (isset($data_compare[$key_compare2]) && !empty($data_compare[$key_compare2])) {
            $shipfee += $data_compare[$key_compare2]['price'];
        } else if (isset($data_compare[$key_compare3]) && !empty($data_compare[$key_compare3])) {
            $shipfee += $data_compare[$key_compare3]['price'];
        }
        return $shipfee;
    }

    /**
     * get shipfee by province
     */
    public static function getShipfeeProvince($province_id)
    {
        $shipfee = 0;
        $data_shipfee = SiteConfigShipfee::getAllConfigShipfee();
        $data_compare = array();
        foreach ($data_shipfee as $shipfee_item) {
            $key = $shipfee_item['province_id'] . $shipfee_item['district_id'];
            $data_compare[$key] = $shipfee_item;
        }
        $key_compare1 = $province_id . 'all';
        $key_compare2 = 'allall';
        if (isset($data_compare[$key_compare1]) && !empty($data_compare[$key_compare1])) {
            $temp = $data_compare[$key_compare1]['price'];
            $shipfee += $temp;
        } else if (isset($data_compare[$key_compare2]) && !empty($data_compare[$key_compare2])) {
            $shipfee += $data_compare[$key_compare2]['price'];
        }
        return $shipfee;
    }

    /**
     * get shipfee by weight
     */
    public static function getShipfeeWeight()
    {
        $shoppingCart = Yii::app()->customer->getShoppingCart();
        $products = $shoppingCart->findAllProducts();
        $weight = (float)0;
        $shipfee = (float)0;
        foreach ($products as $product) {
            $weight += $product['weight'];
        }
        $data_config = SiteConfigShipfeeWeight::getAllConfigShipfeeWeight();
        if (isset($data_config) && count($data_config)) {
            foreach ($data_config as $config) {
                if ($weight == 0) {
                    if ((int)$config['from'] == 0) {
                        $shipfee += $config['price'];
                    }
                } else {
                    if ($weight > $config['from'] && $weight <= $config['to']) {
                        $shipfee += $config['price'];
                    }
                }
            }
        }
        return $shipfee;
    }

    /**
     * Đếm số lượng đơn hàng
     */
    public static function getCountOrder()
    {
        $site_id = Yii::app()->controller->site_id;
        $model = Yii::app()->db->createCommand()->select('count(*)')
            ->from(self::model()->getTableName('orders'))
            ->where('order_status=:order_status AND site_id=:site_id', array(':order_status' => Orders::ORDER_WAITFORPROCESS, ':site_id' => $site_id))
            ->queryScalar();
        return $model;
    }

    /**
     * get orders by ids
     */
    public static function getOrdersByIds($ids)
    {
        $orders = Yii::app()->db->createCommand()->select()
            ->from(self::model()->getTableName('orders'))
            ->where(array('in', 'order_id', $ids))
            ->queryAll();
        return $orders;
    }

    public function isPaymentNganluong()
    {
        return in_array($this->payment_method, array(
            self::PAYMENT_METHOD_TTTM,
            self::PAYMENT_METHOD_NL,
            self::PAYMENT_METHOD_ATM_ONLINE,
            self::PAYMENT_METHOD_IB_ONLINE,
//            self::PAYMENT_METHOD_ATM_OFFLINE,
            self::PAYMENT_METHOD_NH_OFFLINE,
            self::PAYMENT_METHOD_VISA
        ));
    }

    public static function isPaymentMethodNganluong($payment_method)
    {
        return in_array($payment_method, array(
            self::PAYMENT_METHOD_TTTM,
            self::PAYMENT_METHOD_NL,
            self::PAYMENT_METHOD_ATM_ONLINE,
            self::PAYMENT_METHOD_IB_ONLINE,
            self::PAYMENT_METHOD_ATM_OFFLINE,
            self::PAYMENT_METHOD_NH_OFFLINE,
            self::PAYMENT_METHOD_VISA
        ));
    }

    public static function nganluongArray()
    {
        return array(
            self::PAYMENT_METHOD_TTTM => 'Thanh toán tiền mặt',
            self::PAYMENT_METHOD_NL => 'Thanh toán bằng ví điện tử Ngân Lượng',
            self::PAYMENT_METHOD_ATM_ONLINE => 'Thanh toán online bằng thẻ ngân hàng nội địa',
            self::PAYMENT_METHOD_IB_ONLINE => 'Thanh toán bằng Internet Banking',
            self::PAYMENT_METHOD_ATM_OFFLINE => 'Thanh toán chuyển khoản',
            self::PAYMENT_METHOD_NH_OFFLINE => 'Thanh toán tại văn phòng ngân hàng',
            self::PAYMENT_METHOD_VISA => 'Thanh toán bằng thẻ Visa hoặc Mastercard'
        );
    }

    /**
     * Xử lý giá
     */
    function processPrice()
    {
        if ($this->discount_percent)
            $this->discount_percent = floatval(str_replace(array('.', ', '), array('', '.'), $this->discount_percent + ''));
        if ($this->donate_total)
            $this->donate_total = floatval(str_replace(array('.', ', '), array('', '.'), $this->donate_total + ''));
        if ($this->old_order_total)
            $this->old_order_total = floatval(str_replace(array('.', ', '), array('', '.'), $this->old_order_total + ''));
        if ($this->discount_for_dealers)
            $this->discount_for_dealers = floatval(str_replace(array('.', ', '), array('', '.'), $this->discount_for_dealers + ''));
        if ($this->transport_freight)
            $this->transport_freight = floatval(str_replace(array('.', ', '), array('', '.'), $this->transport_freight + ''));
    }

}
