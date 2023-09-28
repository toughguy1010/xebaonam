<?php

/**
 * @author minhbn <minhbachngoc@orenj.com>
 * @date 01/10/2014
 *
 * The followings are the available columns in table 'sites':
 * @property integer $site_id
 * @property integer $site_type
 * @property integer $user_id
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $site_logo
 * @property string $site_watermark
 * @property string $site_title
 * @property integer $expiry_date
 * @property string $time_zone
 * @property string $site_skin
 * @property string $admin_email
 * @property string $google_analytics
 * @property integer $created_time
 * @property integer $modified_time
 * @property string $contact
 * @property string $footercontent
 * @property string $domain_default
 * @property string $favicon
 * @property string $language
 * @property string $phone
 * @property string $stylecustom
 * @property interger $pagesize
 * @property string $mobile_skin_default
 * @property enum $admin_default
 * @property string $meta_title
 * @property string $languages_for_site
 * @property int $status
 * @property int $expiration_date
 * @property integer $percent_vat
 * @property integer $related_products_module
 * @property integer $products_360_module
 * @property integer $dealers_discount
 * @property integer $multi_store
 * @property integer $sim_store
 * @property integer $store_default
 * @property string $map_api_key
 * @property integer $load_main_css
 * @property integer $load_new_url
 * @property integer $fake_access
 * @property string $avatar_path
 * @property string $zipcode
 * @property string $address
 * @property string $address2
 * @property string $country
 * @property string $city
 * @property string $state
 * @property string $use_shoppingcart_set
 * @property string $rating_point
 * @property integer $rating_count
 * @property string $iframe_map
 * @property string $allowed_seo
 * @property string $admin_phone   // chỉ dùng để gửi thông tin cho admin, khong hien thi ngoai frontend
 * @property string $fb_admins_id   // Tài khoản quản trị của FB
 * @property string $post_end_script   // Script nhung trước thể đóng body
 * @property integer $header_showall   // Script nhung trước thể đóng body
 * @property string $header_rules   // Script nhung trước thể đóng body
 * @property integer $footer_showall   // Script nhung trước thể đóng body
 * @property string $footer_rules   // Script nhung trước thể đóng body
 * @property string $currency   // Đơn vị tiền tệ cho site
 * @property integer $search_exact

 */
class SiteSettings extends ActiveRecord {

    const SITE_DEFAUTL_LIMIT = 10;
    const SITE_TYPE_NEWS = 1;
    const SITE_STATUS_EXPIRE = 1; // Hết hạn
    const SITE_STATUS_JUST_EXPIRE = 2; // Gần Hết hạn
    const SITE_STATUS_RUNNING = 3; // Đang hoạt động
    const SITE_STATUS_NOT_EXPIRE = 4; // Vô hạn

    public $avatar = '';
    public $audio = '';
    public $addAdmin = false;

    const HF_SHOWALL_KEY = 'all';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('site');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('site_title,site_skin, admin_email, domain_default', 'required'),
            array('site_title, avatar_path, avatar_name, secret_key', 'length', 'max' => 255),
            array('site_logo, site_watermark', 'length', 'max' => 240),
            array('time_zone', 'length', 'max' => 100),
            array('site_skin', 'length', 'max' => 50),
            array('google_analytics', 'length', 'max' => 10000),
            array('post_end_script', 'length', 'max' => 3000),
            array('admin_email', 'length', 'max' => 200),
            array('admin_email', 'checkEmail'),
            // array('domain_id', 'checkDomain', 'on' => 'addmore'),
            // array('admin_email', 'email'),
            array('language', 'isLanguage'),
            array('pagesize', 'numerical', 'min' => 1, 'max' => 200),
            array('day_send_sms_jobs', 'numerical'),
            array('storage_limit, storage_used, load_new_url, fake_access', 'numerical'),
            array('phone_callback,site_id, site_type, product_highlights , user_id, meta_keywords, meta_description,meta_title, site_logo, site_watermark, site_title, expiry_date, time_zone, site_skin, admin_email, google_analytics, created_time, modified_time, contact, footercontent, domain_default, favicon, language, phone, stylecustom, pagesize, mobile_skin_default,admin_default,languages_for_site,status, default_page_path, default_page_params, expiration_date, admin_language, storage_limit, storage_used, app_id, percent_vat,related_products_module, products_360_module, dealers_discount, multi_store, sim_store, store_default, map_api_key, load_main_css, show_adsnano, load_new_url, fake_access, avatar_path, avatar_name, avatar, zipcode, address, address2, country, city, state, use_shoppingcart_set, type_service, rating_count, rating_point, iframe_map, audio_path, audio_name, audio, location_latitude, location_longitude, allowed_seo, admin_phone, allowed_page_size, fb_admins_id, post_end_script, wholesale, header_showall, header_rules, footer_showall, footer_rules, currency, languages_map, enable_snow, search_exact, news_in_multi_cat, day_send_sms_jobs, config_mail_send, secret_key,phone_sell, phone_safe', 'safe'),
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
     * validate domain
     * @param type $attribute
     * @param type $params
     */
    function checkEmail($attribute, $params) {
        if (!ClaRE::checkEmail($this->$attribute)) {
            $this->addError($attribute, Yii::t('errors', 'email_invalid'));
            return false;
        }
        return true;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'site_id' => 'ID',
            'site_type' => Yii::t('setting', 'site_type'),
            'site_title' => Yii::t('setting', 'site_title'),
            'site_logo' => Yii::t('setting', 'site_logo'),
            'google_analytics' => Yii::t('setting', 'google_analytics'),
            'time_zone' => Yii::t('setting', 'time_zone'),
            'site_skin' => Yii::t('setting', 'site_skin'),
            'admin_email' => Yii::t('setting', 'admin_email'),
            'meta_keywords' => Yii::t('common', 'meta_keywords'),
            'meta_description' => Yii::t('common', 'meta_description'),
            'meta_title' => Yii::t('common', 'meta_title'),
            'contact' => Yii::t('setting', 'contact'),
            'footercontent' => Yii::t('setting', 'footercontent'),
            'site_watermark' => Yii::t('setting', 'site_watermark'),
            'favicon' => Yii::t('setting', 'site_favicon'),
            'language' => Yii::t('site', 'language'),
            'domain_default' => Yii::t('site', 'domain_default'),
            'phone' => Yii::t('common', 'phone'),
            'stylecustom' => Yii::t('site', 'style'),
            'pagesize' => Yii::t('site', 'pagesize'),
            'languages_for_site' => Yii::t('site', 'languages_for_site'),
            'status' => Yii::t('common', 'status'),
            'admin_language' => Yii::t('site', 'admin_language'),
            'expiration_date' => Yii::t('site', 'expiration_date'),
            'storage_limit' => Yii::t('site', 'storage_limit'),
            'storage_used' => Yii::t('site', 'storage_used'),
            'app_id' => 'Facebook App ID',
            'percent_vat' => Yii::t('site', 'percent_vat'),
            'dealers_discount' => Yii::t('site', 'dealers_discount'),
            'related_products_module' => Yii::t('site', 'related_products_module'),
            'products_360_module' => Yii::t('site', 'products_360_module'),
            'load_new_url' => Yii::t('site', 'load_new_url'),
            'fake_access' => Yii::t('site', 'fake_access'),
            'use_shoppingcart_set' => Yii::t('site', 'use_shoppingcart_set'),
            'avatar' => Yii::t('common', 'cover'),
            'zipcode' => Yii::t('site', 'zipcode'),
            'address' => Yii::t('site', 'address'),
            'address2' => Yii::t('site', 'address2'),
            'country' => Yii::t('site', 'country'),
            'city' => Yii::t('site', 'city'),
            'state' => Yii::t('site', 'state'),
            'type_service' => Yii::t('site', 'type_service'),
            'iframe_map' => 'Iframe Map',
            'sim_store' => Yii::t('site', 'sim_store'),
            'audio' => Yii::t('site', 'audio_help'),
            'fb_admins_id' => Yii::t('site', 'fb_admins_id'),
            'post_end_script' => Yii::t('setting', 'post_end_script'),
            'wholesale' => Yii::t('site', 'wholesale'),
            'show_adsnano' => 'Hiển thị quảng cáo của Nanoweb',
            'currency' => Yii::t('product', 'currency'),
            'languages_map' => Yii::t('site', 'languages_map'),
            'product_highlights' => Yii::t('site','Sử dụng hình ảnh sản phẩm nổi bật'),
            'enable_snow' => Yii::t('site','Hiển thị tuyết rơi'),
            'day_send_sms_jobs' => Yii::t('site','day_send_sms_jobs'),
            'search_exact' => 'Search Exact',
            'config_mail_send' => Yii::t('site','config_mail_send'),
            'secret_key' => Yii::t('site','secret_key'),
            'phone_sell' => 'Gọi mua',
            'phone_safe' => 'Bảo hành',
            'phone_callback' => 'Phản ánh',
        );
    }

    /**
     * add rule: checking language
     * @param type $attribute
     * @param type $params
     */
    public function isLanguage($attribute, $params) {
        $languages = ClaSite::getLanguageSupport();
        if (!$this->$attribute)
            return true;
        if (!isset($languages[$this->$attribute])) {
            $this->addError($attribute, Yii::t('errors', 'language_invalid'));
            return false;
        }
        return true;
    }

    /**
     * add rule: checking phone number
     * @param type $attribute
     * @param type $params
     */
    public function isPhone($attribute, $params) {
        if (!$this->$attribute)
            return true;
        if (!ClaRE::isPhoneNumber($this->$attribute))
            $this->addError($attribute, Yii::t('errors', 'phone_invalid'));
    }

    public function beforeSave() {
        if ($this->isNewRecord) {
            $this->domain_default = strtolower($this->domain_default);
            $this->created_time = time();
            $this->addAdmin = true;
        } else
            $this->modified_time = time();
        //
        return parent::beforeSave();
    }

    function afterSave() {
        if($this->addAdmin){
            $adminSite = new SitesAdmin();
            $adminSite->attributes = $this->attributes;
            $adminSite->save();
        }
        //
        $translate_language = ClaSite::getLanguageTranslate();
        //
        Yii::app()->cache->delete(ClaSite::CACHE_SITEINFO_PRE . $this->site_id . $translate_language);
        //
        parent::afterSave();
    }

    /**
     * get site setting
     * @return array site info
     */
    public static function getSiteSettings() {
        $site_id = ClaSite::getCurrentSiteId();
        $site = self::model()->findByPk($site_id);
        if ($site)
            return $site->attributes;
        return array();
    }

    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('site_type', $this->site_type);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('meta_keywords', $this->meta_keywords, true);
        $criteria->compare('meta_description', $this->meta_description, true);
        $criteria->compare('site_logo', $this->site_logo, true);
        $criteria->compare('site_title', $this->site_title, true);
        $criteria->compare('expiry_date', $this->expiry_date);
        $criteria->compare('time_zone', $this->time_zone, true);
        $criteria->compare('site_watermark', $this->site_watermark, true);
        $criteria->compare('site_skin', $this->site_skin, true);
        $criteria->compare('admin_email', $this->admin_email, true);
        $criteria->compare('google_analytics', $this->google_analytics, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('contact', $this->contact, true);
        $criteria->compare('footercontent', $this->footercontent, true);
        $criteria->compare('domain_default', $this->domain_default, true);
        $criteria->compare('favicon', $this->favicon, true);
        $criteria->order = 'created_time DESC';
        $type = Yii::app()->request->getParam('type', '');
        if ($type) {
            $criteria->join = 'INNER JOIN sites_admin sa ON t.site_id = sa.site_id';
            $currentTime = time();
            switch ($type) {
                case self::SITE_STATUS_EXPIRE: {
                        $criteria->addCondition("sa.expiration_date < $currentTime AND sa.expiration_date > 100");
                        $criteria->order = 'sa.expiration_date DESC,created_time DESC';
                    }break;
                case self::SITE_STATUS_JUST_EXPIRE: {
                        $criteria->addCondition("sa.expiration_date > $currentTime AND sa.expiration_date < " . ($currentTime + Yii::app()->params['trial_date'] * 86400 * 4));
                        $criteria->order = 'sa.expiration_date DESC,created_time DESC';
                    }break;
                case self::SITE_STATUS_RUNNING: {
                        $criteria->addCondition("sa.expiration_date > " . ($currentTime + Yii::app()->params['trial_date'] * 86400));
                    }break;
                case self::SITE_STATUS_NOT_EXPIRE: {
                        // 5 year
                        $fiveYear = $currentTime + 5 * 365 * 86400;
                        $criteria->addCondition("sa.expiration_date = 0 OR sa.expiration_date > $fiveYear");
                    }break;
            }
            $criteria->addCondition("domain_default NOT LIKE '%" . W3N_POSTFIX . "'");
        }
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
     * @return SiteSettings the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * delete a site
     * @param type $site_id
     */
    static function deleteSite($site_id) {
        if (!(int) $site_id)
            return false;
        if (!ClaUser::isSupperAdmin())
            return false;
        // Khoong co site_id in these tables
        $ignoreTables = array('cache', 'district', 'province', 'log_bpn_baokim', 'log_payment_nganluong', 'log_vtcpay', 'requests', 'shoppingcart_objects', 'site_types', 'sms_provider', 'themes', 'tokens', 'trades', 'ward');
        $query = 'SELECT T.TABLE_NAME FROM INFORMATION_SCHEMA.tables T WHERE T.table_type = \'BASE TABLE\'';
        $tables = Yii::app()->db->createCommand($query)->queryAll();
        $sql = '';
        foreach ($tables as $tableName) {
            $tableName = $tableName['TABLE_NAME'];
            if (in_array($tableName, $ignoreTables)) {
                continue;
            }
            $sql.='DELETE FROM ' . $tableName . ' WHERE site_id=' . $site_id . ";\n";
        }
        echo $sql;
        die;
        //
        if ($sql) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                Yii::app()->db->createCommand($sql)->execute();
                $transaction->commit();
                Yii::app()->cache->delete(ClaSite::CACHE_SITEINFO_PRE . $site_id);
                return true;
            } catch (Exception $e) {
                echo 'Have errors';
                $transaction->rollback();
                Yii::app()->end();
            }
        }
        return false;
    }

    /**
     * get languages_for_site of this object
     */
    function getLanguageForSite() {
        $results = array();
        if ($this->languages_for_site) {
            $languages_for_sites = explode(' ', $this->languages_for_site);
            foreach ($languages_for_sites as $lfs)
                $results[$lfs] = $lfs;
        }
        return $results;
    }

    /**
     * return status arr
     */
    function getStatusArr() {
        return array(
            1 => Yii::t('common', 'Không khóa site'),
            ClaSite::SITE_STATUS_DISABLE => Yii::t('common', 'Khóa site'),
            ClaSite::SITE_STATUS_UPGRADE => Yii::t('common', 'Tạm dừng để nâng cấp'),
        );
    }

    static function getSiteExpireTextByType() {
        $type = Yii::app()->request->getParam('type', '');
        $text = '';
        if ($type) {
            $currentTime = time();
            switch ($type) {
                case self::SITE_STATUS_EXPIRE: {
                        $text = 'Hết hạn';
                    }break;
                case self::SITE_STATUS_JUST_EXPIRE: {
                        $text = 'Sắp hết hạn';
                    }break;
                case self::SITE_STATUS_RUNNING: {
                        $text = 'Còn nhiều thời gian';
                    }break;
                case self::SITE_STATUS_NOT_EXPIRE: {
                        $text = 'Không giới hạn';
                    }break;
            }
            return $text;
        }
    }

    public static function getSitesByConditions($type, $options = array()) {
        if (!isset($options['limit'])) {
            $options['limit'] = self::SITE_DEFAUTL_LIMIT;
        }
        $order = 'created_time DESC';
        if (isset($options['order'])) {
            $order = $options['order'];
        }
        if (isset($options['order_rank']) && $options['order_rank']) {
            $order = 'rating_point DESC';
        }
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from(ClaTable::getTable('site'))
                ->where('site_type=:site_type and expiration_date > :time', array(':site_type' => $type, ':time' => time()))
                ->order($order)
                ->limit($options['limit'])
                ->queryAll();
        return $data;
    }

    public static function getSiteInType($type, $options = array()) {
        //select
        $select = 't.*';
        $condition = 't.site_type=:site_type AND (t.expiration_date=0 OR t.expiration_date > :time)';
        $params = array(':site_type' => $type, ':time' => time());
        //
        if (isset($options['zipcode']) && $options['zipcode']) {
            $condition .= ' AND t.zipcode LIKE :zipcode';
            $params[':zipcode'] = '%' . $options['zipcode'] . '%';
        }
        if (isset($options['service_name']) && $options['service_name']) {
            $condition .= ' AND (t.site_title LIKE :name OR r.name LIKE :name)';
            $params[':name'] = '%' . $options['service_name'] . '%';
            //
        }
        if (isset($options['rating_point_from']) && floatval($options['rating_point_from'])) {
            $condition .= " AND rating_point >= " . floatval($options['rating_point_from']);
        }
        if (isset($options['rating_point_to']) && floatval($options['rating_point_to'])) {
            $condition .= " AND rating_point <= " . floatval($options['rating_point_to']);
        }
        if (isset($options['range']) && $options['range'] && isset($options['lat']) && isset($options['lng'])) {
            $lat = doubleval($options['lat']);
            $lng = doubleval($options['lng']);
            $range = doubleval($options['range']); //Km
            $select.=",(ACOS(SIN(RADIANS(t.location_latitude))*SIN(RADIANS($lat)) + COS(RADIANS(t.location_latitude))*COS(RADIANS($lat))*COS(RADIANS(t.location_longitude-$lng)))*6370) as distance";
            $condition .= " AND (ACOS(SIN(RADIANS(t.location_latitude))*SIN(RADIANS($lat)) + COS(RADIANS(t.location_latitude))*COS(RADIANS($lat))*COS(RADIANS(t.location_longitude-$lng)))*6370) <=" . $range;
        }
        //
        if (!isset($options['limit'])) {
            $options['limit'] = self::SITE_DEFAUTL_LIMIT;
        }
        $type = (int) $type;
        if (!$type) {
            return array();
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int) $options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        //
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        //
        if (isset($options['service_name']) && $options['service_name']) {
            $data = Yii::app()->db->createCommand()
                    ->select($select)
                    ->from(ClaTable::getTable('site') . ' t')
                    ->join(ClaTable::getTable('se_services') . ' r', 'r.site_id = t.site_id')
                    ->where($condition, $params)
                    ->order('t.site_id DESC')
                    ->limit($options['limit'], $offset)
                    ->queryAll();
        } else {
            $data = Yii::app()->db->createCommand()
                    ->select($select)
                    ->from(ClaTable::getTable('site') . ' t')
                    ->where($condition, $params)
                    ->order('t.site_id DESC')
                    ->limit($options['limit'], $offset)
                    ->queryAll();
        }
        //
        return $data;
    }

    public static function countSiteInType($type = 0, $options = array()) {
        if (!$type) {
            return 0;
        }
        //
        $condition = 'site_type=:site_type AND expiration_date > :time';
        $params = array(':site_type' => $type, ':time' => time());
        //
        if (isset($options['zipcode']) && $options['zipcode']) {
            $condition .= ' AND t.zipcode LIKE :zipcode';
            $params[':zipcode'] = '%' . $options['zipcode'] . '%';
        }
        if (isset($options['service_name']) && $options['service_name']) {
            $condition .= ' AND (t.site_title LIKE :name OR r.name LIKE :name)';
            $params[':name'] = '%' . $options['service_name'] . '%';
        }
        if (isset($options['rating_point_from']) && floatval($options['rating_point_from'])) {
            $condition .= " AND rating_point >= " . floatval($options['rating_point_from']);
        }
        if (isset($options['rating_point_to']) && floatval($options['rating_point_to'])) {
            $condition .= " AND rating_point <= " . floatval($options['rating_point_to']);
        }
        if (isset($options['range']) && $options['range'] && isset($options['lat']) && isset($options['lng'])) {
            $lat = doubleval($options['lat']);
            $lng = doubleval($options['lng']);
            $range = doubleval($options['range']); //Km
            $condition .= " AND (ACOS(SIN(RADIANS(t.location_latitude))*SIN(RADIANS($lat)) + COS(RADIANS(t.location_latitude))*COS(RADIANS($lat))*COS(RADIANS(t.location_longitude-$lng)))*6370) <=" . $range;
        }
        //
        if (isset($options['service_name']) && $options['service_name']) {
            $count = Yii::app()->db->createCommand()
                    ->select('count(*)')
                    ->from(ClaTable::getTable('site') . ' t')
                    ->join(ClaTable::getTable('se_services') . ' r', 'r.site_id = t.site_id')
                    ->where($condition, $params)
                    ->queryScalar();
        } else {
            $count = Yii::app()->db->createCommand()
                    ->select('count(*)')
                    ->from(ClaTable::getTable('site') . ' t')
                    ->where($condition, $params)
                    ->queryScalar();
        }
        return $count;
    }

    public static function arrayTypeService() {
        return array(
            1 => 'Both types',
            2 => 'At business',
            3 => 'Mobile'
        );
    }

    /**
     * trả về amngr các key của trang theo banner
     * @return type
     */
    static function getPageKeyArr() {
        $pages = [];
        $pages['normal'] = array(
            'home' => Yii::t('menu', 'menu_link_home'),
            'sanpham' => Yii::t('menu', 'menu_link_product'),
            'danhmucsanpham' => Yii::t('product', 'product_category'),
            'chitietsanpham' => Yii::t('product', 'product_detail'),
            'tintuc' => Yii::t('menu', 'menu_link_news'),
            'danhmuctintuc' => Yii::t('news', 'news_category'),
            'chitiettintuc' => Yii::t('news', 'news_detail'),
            'gioithieu' => Yii::t('menu', 'menu_link_introduce'),
            'lienhe' => Yii::t('menu', 'menu_link_contact'),
            'tuyendung' => Yii::t('work', 'work'),
            'chitiettuyendung' => Yii::t('work', 'work_detail'),
            'timkiem' => Yii::t('common', 'search'),
            'album' => Yii::t('common', 'album'),
            'video' => Yii::t('common', 'video'),
        );
        $listpage = CategoryPage::getAllCategoryPage();
        foreach ($listpage as $pa) {
            $pages['categorypage']['cpage_' . $pa['id']] = $pa['title'];
        }
        $list_category = ClaCategory::getAllProductCategoryPage();
        foreach ($list_category as $ca) {
            $pages['productcategory']['ppage_' . $ca['cat_id']] = $ca['cat_name'];
        }
        //
        $newCategories = NewsCategories::getAllCategory();
        foreach ($newCategories as $cat) {
            $pages['newscategory']['newscat_' . $cat['cat_id']] = $cat['cat_name'];
        }
        //
        $productGroup = ProductGroups::getProductGroupArr();
        foreach ($productGroup as $group_id => $group_name) {
            $pages['productgroup']['productgroup_' . $group_id] = $group_name;
        }
        //
        return $pages;
    }

    /**
     * trả về key thực tế của một page theo banner
     * @param type $key
     */
    static function getRealPageKey($key = '') {
        $keys = explode('_', $key);
        switch ($keys[0]) {
            case self::HF_SHOWALL_KEY:
                return self::HF_SHOWALL_KEY;
            case 'home':
                return 'home';
            case 'album':
                return 'media/album/all';
            case 'video':
                return 'media/video/all';
            case 'sanpham':
                return 'economy/product/';
            case 'danhmucsanpham':
                return 'economy/product/category';
            case 'chitietsanpham':
                return 'economy/product/detail';
            case 'tintuc':
                return 'news/news/';
            case 'danhmuctintuc':
                return 'news/news/category';
            case 'chitiettintuc':
                return 'news/news/detail';
            case 'gioithieu':
                return 'site/site/introduce';
            case 'lienhe':
                return 'site/site/contact';
            case 'timkiem':
                return 'search/search/search';
            case 'tuyendung':
                return 'work/job/';
            case 'chitiettuyendung':
                return 'work/job/detail';
            case 'cpage':
                return 'page/category/detail_' . $keys[1];
            case 'ppage':
                return 'ppage_' . $keys[1];
            case 'newscat':
                return 'newscat_' . $keys[1];
            case 'productgroup':
                return 'economy/product/group_' . $keys[1];
        }
        //
        return '';
    }

}
