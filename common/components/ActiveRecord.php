<?php

/**
 * An ActiveRecord object for whole project
 * This class is extended from CActiveRecord
 * @author minhb <minhcoltech@gmail.com>
 * @date 02/03/2014
 */
class ActiveRecord extends CActiveRecord {
    /* const status for objects */

    const STATUS_ACTIVED = 1;
    const STATUS_DEACTIVED = 0;
    const STATUS_PRODUCT_NEW = 2; //sản phẩm mới
    const STATUS_NEWS_INTERNAL = 3; // tikn nội bộ
    const STATUS_QUESTION_NOT_ANSWER = 5; // CHƯA TRẢ LỜI
    const STATUS_QUESTION_HAD_ANSWER = 6; // ĐÃ TRẢ LỜI
    const STATUS_WAITING_REALESTATE = 2;
    const STATUS_DELETED = 11;
    const STATUS_EVENT_ACTIVED = 1;
    const STATUS_EVENT_WAITING = 0;
    const DEFAUT_LIMIT = 100;
    const MIN_DEFAUT_LIMIT = 10;
    const SHOW_IN_HOME = 1;
    const STATUS_WAITING = 1;
    const STATUS_SUCCESS = 2;
    const STATUS_CANCEL = 3;
    const PAYMENT_CASH = 1;
    const PAYMENT_TRANSFER_BY_BANK = 2;
    const DELIVERY_HOME = 1;
    const NOT_DELIVERY = 2;
    const PAYMENT_STATUS_WAITING = 1;
    const PAYMENT_STATUS_SUCCESS = 2;
    const STATUS_USER_WAITING = 2;
    const TYPE_COMMERCIAL = 1;
    const TYPE_INTERNAL = 2;
    const TYPE_FOR_LEASE = 3;
    const TYPE_NEED_LEASE = 4;
    const TYPE_INTERNAL_USER = 1; // user nội bộ
    const TYPE_NORMAL_USER = 2; // user thường
    const TYPE_LEADER_USER = 3; // user leader
    const TYPE_DEALERS_USER = 4; // user dealer
    const TYPE_INVESTOR_USER = 5; // user dealer nha dau tu
    const TYPE_STARTUP_COMPANY_USER = 6; // user dealer nha dau tu

    public $translate = true;
    public $language = '';

    const TYPE_SITE_NORMAL = 1;
    const TYPE_SITE_B2B_FASHION = 2;
    const OPTION_INTERIOR = 'interior';
    const OPTION_EXTERIOR = 'exterior';
    const OPTION_PRODUCT_360 = 'product360';
    const TYPE_HAS_ADDRESS = 1; // Gian hàng có địa chỉ cụ thể, Sàn thời trang
    const TYPE_SELL_ONLINE = 2; // Gian hàng online
    const TYPE_BEST_LIKE = 3; // Gian hàng được yêu thích nhất
    const TYPE_COMFORTS_HOTEL = 1; //Tiện nghi khách sạn
    const TYPE_COMFORTS_ROOM = 2; //Tiện nghi phòng khách sạn
    const TYPE_PRODUCT_NORMAL = 1; // sản phẩm thường
    const TYPE_PRODUCT_VOUCHER = 2; // sản phẩm voucher
    const TYPE_QUESTION_QUESTION = 3; // sản phẩm voucher
    const TYPE_QUESTION_TIP = 2; // sản phẩm voucher
    const TYPE_QUESTION_GUIDE = 1; // sản phẩm voucher
    
    const SEX_MALE = 1; // Nam
    const SEX_FEMALE = 2; // Nữ

    /**
     * array status for selectbox
     * @return array
     */

    public static function statusArray() {
        return array(
            self::STATUS_ACTIVED => Yii::t('status', self::STATUS_ACTIVED),
            self::STATUS_DEACTIVED => Yii::t('status', self::STATUS_DEACTIVED),
        );
    }

    public static function statusArrayEventRegister() {
        return array(
            self::STATUS_EVENT_ACTIVED => Yii::t('event', self::STATUS_EVENT_ACTIVED),
            self::STATUS_EVENT_WAITING => Yii::t('event', self::STATUS_EVENT_WAITING),
        );
    }

    /**
     * @hungtm
     * thêm trạng thái sắp ra mắt
     * @return array
     */
    public static function statusArrayProduct() {
        return array(
            self::STATUS_ACTIVED => Yii::t('status', self::STATUS_ACTIVED),
            self::STATUS_DEACTIVED => Yii::t('status', self::STATUS_DEACTIVED),
            self::STATUS_PRODUCT_NEW => Yii::t('status', self::STATUS_PRODUCT_NEW),
        );
    }

    public static function typeCommentArray() {
        return array(
            Comment::COMMENT_PRODUCT => Yii::t('comment', Comment::COMMENT_PRODUCT),
            Comment::COMMENT_NEWS => Yii::t('comment', Comment::COMMENT_NEWS),
            Comment::COMMENT_QUESTION => Yii::t('comment', Comment::COMMENT_QUESTION),
            Comment::COMMENT_CATEGORY_NEWS => Yii::t('comment', Comment::COMMENT_CATEGORY_NEWS),
        );
    }

    public static function typeProductArray() {
        return array(
            self::TYPE_PRODUCT_NORMAL => Yii::t('product', self::TYPE_PRODUCT_NORMAL),
            self::TYPE_PRODUCT_VOUCHER => Yii::t('product', self::TYPE_PRODUCT_VOUCHER),
        );
    }

    //hatv cac loai question
    public static function typeQuestionArray() {
        return array(
            self::TYPE_QUESTION_GUIDE => Yii::t('question', self::TYPE_QUESTION_GUIDE),
            self::TYPE_QUESTION_QUESTION => Yii::t('question', self::TYPE_QUESTION_QUESTION),
            self::TYPE_QUESTION_TIP => Yii::t('question', self::TYPE_QUESTION_TIP),
        );
    }

    /**
     * @hungtm
     * thêm trạng thái tin nội bộ cho tin tức
     * thành viên đăng nhập mới nhìn được tin nội bộ
     * @return array
     */
    public static function statusArrayNews() {
        return array(
            self::STATUS_ACTIVED => Yii::t('status', self::STATUS_ACTIVED),
            self::STATUS_DEACTIVED => Yii::t('status', self::STATUS_DEACTIVED),
            self::STATUS_NEWS_INTERNAL => Yii::t('status', self::STATUS_NEWS_INTERNAL),
        );
    }

    /**
     * @hungtm
     * thêm trạng thái tin nội bộ cho tin tức
     * thành viên đăng nhập mới nhìn được tin nội bộ
     * @return array
     */
    public static function statusArrayQuestion() {
        return array(
            self::STATUS_ACTIVED => Yii::t('status', self::STATUS_ACTIVED),
            self::STATUS_DEACTIVED => Yii::t('status', self::STATUS_DEACTIVED),
            self::STATUS_QUESTION_NOT_ANSWER => Yii::t('question', self::STATUS_QUESTION_NOT_ANSWER),
            self::STATUS_QUESTION_HAD_ANSWER => Yii::t('question', self::STATUS_QUESTION_HAD_ANSWER),
        );
    }

    /**
     * Kiểu của gian hàng
     * 1: có địa chỉ cụ thể
     * 2: gian hàng online
     */
    public static function typeShopSell() {
        return array(
            self::TYPE_HAS_ADDRESS => Yii::t('shop', 'type_has_address'),
            self::TYPE_SELL_ONLINE => Yii::t('shop', 'type_sell_online'),
        );
    }

    /**
     * Tiện nghi của khách sạn hoặc phòng khách sạn
     * 1: tiện nghi chung của khách sạn
     * 2: tiện nghi riêng cho từng phòng
     * @return array
     */
    public static function typeComfortsHotel() {
        return array(
            self::TYPE_COMFORTS_HOTEL => Yii::t('tour', 'type_comfort_hotel'),
            self::TYPE_COMFORTS_ROOM => Yii::t('tour', 'type_comfort_room'),
        );
    }

    /**
     * Kiểu của site
     * TYPE_SITE_B2B_FASHION: dùng cho site sàn thời trang
     * @return array
     */
    public static function typeSite() {
        return array(
            self::TYPE_SITE_NORMAL => Yii::t('site', 'type_site_normal'),
            self::TYPE_SITE_B2B_FASHION => Yii::t('site', 'type_site_b2b_fashion'),
        );
    }

    public static function statusArrayRealestate() {
        return array(
            self::STATUS_ACTIVED => Yii::t('realestate', 'actived'),
            self::STATUS_DEACTIVED => Yii::t('realestate', 'deactived'),
            self::STATUS_WAITING_REALESTATE => Yii::t('realestate', 'waiting')
        );
    }

    public static function statusArrayUser() {
        return array(
            self::STATUS_USER_WAITING => Yii::t('user', 'user_waiting'),
            self::STATUS_DEACTIVED => Yii::t('user', 'user_block'),
            self::STATUS_ACTIVED => Yii::t('user', 'user_success'),
        );
    }

    /**
     * for salesviet
     * @return array
     */
    public static function typeArrayUser() {
        return array(
            self::TYPE_INTERNAL_USER => Yii::t('user', 'user_internal'),
            self::TYPE_NORMAL_USER => Yii::t('user', 'user_normal'),
            self::TYPE_LEADER_USER => Yii::t('user', 'user_leader'),
        );
    }

    /**
     * for 21six
     * @return array
     */
    public static function typeArrayUserNormal() {
        return array(
            self::TYPE_INTERNAL_USER => Yii::t('user', 'user_internal'),
            self::TYPE_DEALERS_USER => Yii::t('user', 'user_dealers'),
            self::TYPE_NORMAL_USER => Yii::t('user', 'user_normal'),
        );
    }

    /**
     * for Iangel
     * @return array
     */
    public static function typeArrayUserEvent() {
        return array(
            self::TYPE_INVESTOR_USER => Yii::t('user', 'user_investor'),
            self::TYPE_NORMAL_USER => Yii::t('event', 'user_normal'),
        );
    }

    public static function typeRealestateArray() {
        return array(
            self::TYPE_COMMERCIAL => Yii::t('realestate', self::TYPE_COMMERCIAL),
            self::TYPE_INTERNAL => Yii::t('realestate', self::TYPE_INTERNAL)
        );
    }

    public static function statusPrintImageArray() {
        return array(
            self::STATUS_WAITING => Yii::t('shoppingcart', 'order_waitforprocess'),
            self::STATUS_SUCCESS => Yii::t('shoppingcart', 'order_complete'),
            self::STATUS_CANCEL => Yii::t('shoppingcart', 'order_destroy'),
        );
    }

    public static function statusPaymentMethod() {
        return array(
            self::PAYMENT_CASH => Yii::t('shoppingcart', 'payment_cash'),
            self::PAYMENT_TRANSFER_BY_BANK => Yii::t('shoppingcart', 'payment_transfer_by_bank'),
        );
    }

    public static function transportMethod() {
        return array(
            self::DELIVERY_HOME => Yii::t('shoppingcart', 'delivery_home'),
            self::NOT_DELIVERY => Yii::t('shoppingcart', 'not_delivery'),
        );
    }

    public static function statusPayment() {
        return array(
            self::PAYMENT_STATUS_WAITING => Yii::t('shoppingcart', 'order_waitforpayment'),
            self::PAYMENT_STATUS_SUCCESS => Yii::t('shoppingcart', 'order_complete'),
        );
    }

    public static function genderArray() {
        return array(
            self::STATUS_ACTIVED => Yii::t('user', 'sex_male'),
            self::STATUS_DEACTIVED => Yii::t('user', 'sex_female')
        );
    }

    public static function statisStatusArray($none = false) {
        if ($none)
            $return[''] = 'All';
        $return [self::STATUS_ACTIVED] = Yii::t('status', self::STATUS_ACTIVED);
        $return [self::STATUS_DEACTIVED] = Yii::t('status', self::STATUS_DEACTIVED);
        //
        return $return;
    }

    /**
     * add rule: checking phone number
     * @param type $attribute
     * @param type $params
     */
    public function isAlias($attribute, $params) {
        if (!ClaRE::isAlias($this->$attribute)) {
            $this->addError($attribute, Yii::t('errors', 'alias_invalid'));
            return false;
        }
        return true;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TokenCommonModel the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Overriding default, so it works correct with arrays of AR models when you
     * use JSON::encode($models) for example (by default it won't use toJSON).
     * Might be fixed by overriding JSON::encode method to use static instead of self,
     * but it'll be difficult to maintain. Waiting for Yii2.
     * @return CMapIterator
     */
    public function getIterator() {
        $attributes = $this->toJSON();
        return new CMapIterator($attributes);
    }

    public function toJSON() {
        $attributes = $this->getAttributes();
        return $attributes;
    }

    /**
     * @author: minhbn
     * endcode html for attributes
     * @param array $attributes an array attributes
     *  if array attributes is null, Chtmlencode all attributes
     * return ActiveRecord $model
     */
    public function CHtmlEncodeAttributes($attributes = array()) {
        ClaModel::ChtmlEncodeAttributes($this, $attributes);
        return $this;
    }

    /**
     * @author  minhbn <mincoltech@gmail.com>
     *
     * json_encode Errors
     */
    function getJsonErrors() {
        $listerrors = array();
        foreach ($this->getErrors() as $attribute => $mess)
            $listerrors[CHtml::activeId($this, $attribute)] = $mess;
        $errors = function_exists('json_encode') ? json_encode($listerrors) : CJSON::encode($listerrors);
        return $errors;
    }

    /**
     * return boolean
     * @return type
     */
    function getTranslate() {
        return $this->translate;
    }

    /**
     * set translate
     * @param boolean $translate
     */
    function setTranslate($translate = true) {
        $this->translate = $translate;
        $this->refreshMetaData();
    }

    /**
     * return table if set translate is true
     * @param type $tableName
     */
    function getTableName($tableName = '') {
        $table = ClaTable::getTable($tableName, array('translate' => $this->getTranslate(), 'language' => $this->getLanguage()));
        return $table;
    }

    /**
     * return languate
     * @return type
     */
    function getLanguage() {
//        if(!$this->language){
//            return Yii::app()->language;
//        }
        return $this->language;
    }

    /**
     * set language
     * @param type $language
     */
    function setLanguage($language = '', $force = false) {
        if ($force) {
            $this->language = $language;
            $this->refreshMetaData();
        } else {
            $languageSupport = ClaSite::getLanguageSupport();
            if (isset($languageSupport[$language])) {
                $this->language = $language;
                $this->refreshMetaData();
            }
        }
    }

    /**
     * Check this ActiveRecord is translate
     * @param type $language
     */
    function isTranslate($language = '') {
        if (!$language) {
            return false;
        }
        if ($this->isNewRecord) {
            return false;
        }
        $backLanguage = $this->getLanguage();
        $this->setLanguage($language);
        $translateModel = $this->findByPk($this->getPrimaryKey());
        $this->setLanguage($backLanguage, true);
        if ($translateModel) {
            return true;
        }
        return false;
    }

    /**
     * @author hungtm
     * @date 24/05/2019
     * @param $text
     * @return null|string|string[]
     */
    public static function remove_utf8_bom($text)
    {
        $bom = pack('H*','EFBBBF');
        $text = preg_replace("/^$bom/", '', $text);
        return $text;
    }

}
