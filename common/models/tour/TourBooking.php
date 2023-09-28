<?php

/**
 * This is the model class for table "tour_booking".
 *
 * The followings are the available columns in table 'tour_booking':
 * @property string $booking_id
 * @property integer $user_id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $address
 * @property string $province_id
 * @property string $payment_method
 * @property string $bankcode
 * @property integer $status_payment
 * @property integer $status
 * @property string $coupon_code
 * @property string $note
 * @property string $ip_address
 * @property integer $checking_in
 * @property integer $checking_out
 * @property integer $type
 * @property integer $departure_date
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $site_id
 */
class TourBooking extends ActiveRecord {

    const TYPE_BOOKING_ROOM = 1;
    const TYPE_BOOKING_TOUR = 2;
    const STATUS_WAITING = 1; // đang xác nhận đơn đặt
    const STATUS_SUCCESS = 2; // đặt thành công
    const STATUS_CANCEL = 3; // hủy đặt
    const STATUS_WAITING_PAYMENT = 1; // chưa thanh toán
    const STATUS_SUCCESS_PAYMENT = 2; // đã thanh toán
//    const PAYMENT_METHOD_CASH = 13;
//    const PAYMENT_METHOD_TRANSFER = 14;
//    const PAYMENT_METHOD_ATM_ONLINE = 1;
//    const PAYMENT_METHOD_VISA = 2;
//    const PAYMENT_METHOD_BAOKIM = 'baokim';
    const PAYMENT_METHOD_TTTM = 'TTTM'; // thanh toán tiền mặt
    const PAYMENT_METHOD_NL = 'NL'; // thanh toán bằng ví điện tử ngân lượng
    const PAYMENT_METHOD_ATM_ONLINE = 'ATM_ONLINE'; // thanh toán online bằng thẻ ngân hàng nội địa
    const PAYMENT_METHOD_IB_ONLINE = 'IB_ONLINE'; // thanh toán bằng Internet Banking
    const PAYMENT_METHOD_ATM_OFFLINE = 'ATM_OFFLINE'; // thanh toán atm offline
    const PAYMENT_METHOD_NH_OFFLINE = 'NH_OFFLINE'; // thanh toán tại văn phòng ngân hàng
    const PAYMENT_METHOD_VISA = 'VISA'; // thanh toán bằng thẻ visa hoặc mastercard

    /**
     * @return string the associated database table name
     */

    public function tableName() {
        return $this->getTableName('tour_booking');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, phone, email', 'required'),
            array('checking_in, checking_out, adults, bed_type, name, phone', 'required', 'on' => 'book_room'),
            array('user_id, status_payment, status, type, departure_date, created_time, modified_time, site_id', 'numerical', 'integerOnly' => true),
            array('name, email, address, note, passport, places_to_visit', 'length', 'max' => 255),
            array('phone, bankcode', 'length', 'max' => 20),
            array('province_id, length, star_rating, tour_style', 'length', 'max' => 5),
            array('payment_method', 'length', 'max' => 128),
            array('coupon_code, flight_number', 'length', 'max' => 50),
            array('ip_address', 'length', 'max' => 96),
            array('booking_total', 'length', 'max' => 16),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('booking_id, user_id, name, phone, email, address, province_id, payment_method, bankcode, payment_method_child, status_payment, status, coupon_code, note, ip_address, checking_in, checking_out, type, departure_date, created_time, modified_time, site_id, booking_total, adults, children, age_children, bed_type, extra_bed, sex, company, transfer_request, arrival_time, travel_time, payment_methods', 'safe'),
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
            'booking_id' => 'Booking',
            'user_id' => 'User',
            'name' => Yii::t('tour_booking', 'name'),
            'phone' => Yii::t('tour_booking', 'phone'),
            'email' => Yii::t('tour_booking', 'email'),
            'address' => Yii::t('tour_booking', 'address'),
            'province_id' => Yii::t('tour_booking', 'province_id'),
            'payment_method' => Yii::t('tour_booking', 'payment_method'),
            'payment_method_child' => Yii::t('tour_booking', 'payment_method'),
            'status_payment' => Yii::t('tour_booking', 'status_payment'),
            'status' => Yii::t('tour_booking', 'status'),
            'coupon_code' => Yii::t('tour_booking', 'coupon_code'),
            'note' => Yii::t('tour_booking', 'note'),
            'ip_address' => Yii::t('tour_booking', 'ip_address'),
            'checking_in' => Yii::t('tour_booking', 'checking_in'),
            'checking_out' => Yii::t('tour_booking', 'checking_out'),
            'type' => 'Type',
            'departure_date' => Yii::t('tour', 'departure_date'),
            'created_time' => Yii::t('tour_booking', 'created_time'),
            'modified_time' => Yii::t('tour_booking', 'modified_time'),
            'site_id' => 'Site',
            'adults' => Yii::t('book_room', 'adults'),
            'children' => Yii::t('book_room', 'children'),
            'age_children' => Yii::t('book_room', 'age_children'),
            'bed_type' => Yii::t('book_room', 'bed_type'),
            'extra_bed' => Yii::t('book_room', 'extra_bed'),
            'sex' => Yii::t('book_room', 'sex'),
            'company' => Yii::t('book_room', 'company'),
            'transfer_request' => Yii::t('book_room', 'transfer_request'),
            'arrival_time' => Yii::t('book_room', 'arrival_time'),
            'travel_time' => Yii::t('book_room', 'travel_time'),
            'places_to_visit' => Yii::t('book_room', 'places_to_visit'),
            'flight_number' => Yii::t('tour_booking', 'flight_number'),
            'length' => Yii::t('tour_booking', 'length'),
            'passport' => Yii::t('tour_booking', 'passport'),
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

        $criteria->compare('booking_id', $this->booking_id, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('province_id', $this->province_id, true);
        $criteria->compare('payment_method', $this->payment_method, true);
        $criteria->compare('status_payment', $this->status_payment);
        $criteria->compare('status', $this->status);
        $criteria->compare('coupon_code', $this->coupon_code, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('ip_address', $this->ip_address, true);
        $criteria->compare('checking_in', $this->checking_in);
        $criteria->compare('checking_out', $this->checking_out);
        $criteria->compare('type', $this->type);
        $criteria->compare('departure_date', $this->departure_date);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('site_id', $this->site_id);

        $criteria->order = 'created_time DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TourBooking the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->modified_time = $this->created_time = time();
        } else {
            $this->modified_time = time();
        }
        //
        return parent::beforeSave();
    }

    public static function statusArray() {
        return array(
            self::STATUS_WAITING => Yii::t('tour_booking', 'status_waiting'),
            self::STATUS_SUCCESS => Yii::t('tour_booking', 'status_success'),
            self::STATUS_CANCEL => Yii::t('tour_booking', 'status_cancel'),
        );
    }

    public static function statusPaymentArray() {
        return array(
            self::STATUS_WAITING_PAYMENT => Yii::t('tour_booking', 'status_waiting_payment'),
            self::STATUS_SUCCESS_PAYMENT => Yii::t('tour_booking', 'status_success_payment'),
        );
    }

//    public static function getPaymentMethod() {
//        return array(
//            self::PAYMENT_METHOD_CASH => Yii::t('tour_booking', 'payment_method_cash'),
//            self::PAYMENT_METHOD_TRANSFER => Yii::t('tour_booking', 'payment_method_transfer'),
//            self::PAYMENT_METHOD_ATM_ONLINE => Yii::t('tour_booking', 'payment_method_atm_online'),
//            self::PAYMENT_METHOD_VISA => Yii::t('tour_booking', 'payment_method_visa'),
//        );
//    }
//    public static function getPaymentMethodOnline() {
//        return array(
//            self::PAYMENT_METHOD_ATM_ONLINE => Yii::t('tour_booking', 'payment_method_atm_online'),
//            self::PAYMENT_METHOD_VISA => Yii::t('tour_booking', 'payment_method_visa'),
//                //self::PAYMENT_METHOD_BAOKIM => Yii::t('tour_booking', 'payment_method_baokim'),
//        );
//    }

    public function isPaymentOnline() {
        return in_array($this->payment_method, array(
            self::PAYMENT_METHOD_NL,
            self::PAYMENT_METHOD_ATM_ONLINE,
            self::PAYMENT_METHOD_IB_ONLINE,
            self::PAYMENT_METHOD_ATM_OFFLINE,
            self::PAYMENT_METHOD_NH_OFFLINE,
            self::PAYMENT_METHOD_VISA
        ));
    }

    public static function getPaymentMethodName() {
        return array(
            self::PAYMENT_METHOD_TTTM => 'Thanh toán tiền mặt',
            self::PAYMENT_METHOD_NL => 'Thanh toán bằng ví điện tử ngân lượng',
            self::PAYMENT_METHOD_ATM_ONLINE => 'Thanh toán online bằng thẻ ngân hàng nội địa',
            self::PAYMENT_METHOD_IB_ONLINE => 'Thanh toán bằng Internet Banking',
            self::PAYMENT_METHOD_ATM_OFFLINE => 'Thanh toán ATM offline',
            self::PAYMENT_METHOD_NH_OFFLINE => 'Thanh toán tại văn phòng ngân hàng',
            self::PAYMENT_METHOD_VISA => 'Thanh toán bằng thẻ visa hoặc mastercard',
        );
    }

}
