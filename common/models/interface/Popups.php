<?php

/**
 * This is the model class for table "popups".
 * The followings are the available columns in table 'popups':
 * @property integer $id
 * @property integer $site_id
 * @property string $popup_name
 * @property string $popup_src
 * @property integer $popup_width
 * @property integer $popup_height
 * @property integer $popup_order
 * @property string $popup_rules
 * @property integer $created_time
 * @property integer $popup_type
 * @property integer $popup_showall
 * @property integer $start_time
 * @property integer $end_time
 * @property string $store_ids
 */
class Popups extends ActiveRecord
{

    const POPUP_TYPE_IMAGE = 1;
    const POPUP_TYPE_FLASH = 2;
    //Config
    const POPUP_SHOW_ALL = 0;
    const POPUP_SHOW_FIRST_TIME = 1;
    const POPUP_SHOW_SECOND_TIME = 2;
    const POPUP_SHOW_MEMBER = 3;

    //Time Type
    const TYPE_SEC = 0;
    const TYPE_MINUTE = 1;
    const TYPE_HOUR = 2;
    const TYPE_DAY = 3;
    const TYPE_MONTH = 4;

    const POPUP_SHOWALL_KEY = 'all';
    const POPUP_HOME_KEY = 'home';

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return $this->getTableName('popup');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('popup_name,popup_order,', 'required'),
            array('popup_width, popup_height, popup_order, created_time, popup_type, popup_config, store_time, store_time_type, delay_time, start_time, end_time', 'numerical', 'integerOnly' => true, 'min' => 0),
            array('popup_name', 'length', 'max' => 255),
            array('end_time', 'compare', 'compareAttribute' => 'start_time', 'operator' => '>=', 'message' => Yii::t('popup', '{attribute} must larger than {compareAttribute}')),
            array('id, site_id, popup_name, popup_width, popup_height, popup_order, popup_rules, created_time, popup_type, popup_rules, popup_description, popup_showall, actived, store_ids, start_time, store_time_type, end_time, popup_config,store_time,delay_time', 'safe'),
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
            'id' => 'Banner',
            'site_id' => 'Site',
            'popup_name' => Yii::t('popup', 'popup_name'),
            'popup_width' => Yii::t('popup', 'popup_width'),
            'popup_height' => Yii::t('popup', 'popup_height'),
            'popup_order' => Yii::t('popup', 'popup_order'),
            'popup_rules' => Yii::t('popup', 'popup_rules'),
            'created_time' => 'Created Time',
            'popup_type' => Yii::t('popup', 'popup_type'),
            'popup_description' => Yii::t('popup', 'popup_description'),
            'popup_size' => Yii::t('common', 'size'),
            'actived' => Yii::t('common', 'show'),
            'store_ids' => Yii::t('shop', 'shop_store'),
            'start_time' => Yii::t('popup', 'start_time'),
            'end_time' => Yii::t('popup', 'end_time'),
            'delay_time' => Yii::t('popup', 'delay_time'),
            'store_time' => Yii::t('popup', 'store_time'),
            'store_time_type' => Yii::t('popup', 'store_time_type'),
        );
    }

    function beforeSave()
    {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
        }
        return parent::beforeSave();
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

        $criteria->compare('id', $this->id);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('popup_name', $this->popup_name, true);
//        $criteria->compare('popup_src', $this->popup_src, true);
        $criteria->compare('popup_width', $this->popup_width);
        $criteria->compare('popup_height', $this->popup_height);
        $criteria->compare('popup_order', $this->popup_order);
        $criteria->compare('popup_rules', $this->popup_rules, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('popup_type', $this->popup_type);
        $criteria->compare('start_time', $this->start_time);
        $criteria->compare('store_time_type', $this->store_time_type);
        $criteria->compare('end_time', $this->end_time);
        $criteria->compare('delay_time', $this->delay_time);
        $criteria->compare('store_time', $this->store_time);
        $criteria->order = 'popup_order ASC,created_time DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                'pageVar' => 'page',
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Popups the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * get config arr
     * const POPUP_SHOW_ALL = 0;
     * const POPUP_SHOW_FIRST_TIME = 1;
     * const POPUP_SHOW_SECOND_TIME = 2;
     * const POPUP_SHOW_MEMBER = 3;
     * @return array
     */
    public static function getConfigArr()
    {
        return array(
            self::POPUP_SHOW_ALL => Yii::t('popup', 'for_all'),
            self::POPUP_SHOW_FIRST_TIME => Yii::t('popup', 'for_first_time'),
            self::POPUP_SHOW_SECOND_TIME => Yii::t('popup', 'for_second_time'),
            self::POPUP_SHOW_MEMBER => Yii::t('popup', 'for_member'),
        );
    }

    /**
     * get config arr
     * const TYPE_SEC = 0;
     * const TYPE_MINUTE = 1;
     * const TYPE_HOUR = 2;
     * const TYPE_DAY = 3;
     * const TYPE_MONTH = 4;
     * @return array
     */
    public static function getTimeType()
    {
        return array(
            self::TYPE_SEC => Yii::t('popup', 'TYPE_SEC'),
            self::TYPE_MINUTE => Yii::t('popup', 'TYPE_MINUTE'),
            self::TYPE_HOUR => Yii::t('popup', 'TYPE_HOUR'),
            self::TYPE_DAY => Yii::t('popup', 'TYPE_DAY'),
            self::TYPE_MONTH => Yii::t('popup', 'TYPE_MONTH'),
        );
    }

    /**
     * Lấy loại popup theo url
     * @param type $src
     * @return type
     */
    static function getBannerTypeFromSrc($src = '')
    {
        $pathinfo = pathinfo($src);
        $extension = isset($pathinfo['extension']) ? $pathinfo['extension'] : '';
        return self::getBannerTypeFromEx($extension);
    }

    /**
     * Lấy tất cả popup của site
     * @param type $site_id
     * @return type
     */
    static function getPopupArr($site_id = 0)
    {
        if (!$site_id)
            $site_id = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('popup'))
            ->where('site_id=:site_id', array(':site_id' => $site_id))
            ->queryAll();
        $result = array();
        if ($data) {
            foreach ($data as $popup) {
                $result[$popup['id']] = $popup['popup_name'];
            }
        }
        return $result;
    }

    //

    /**
     * Lấy thông tin của popup theo id
     * @param type $id
     */
    static function getPopupData($id = 0)
    {
        $result = array();
        if ($id) {
            $popup = Popups::model()->findByPk($id);
            if ($popup)
                $result = $popup->attributes;
        }
        //
        return $result;
    }

    /**
     * Lấy tất cả popup của site
     * @param type $site_id
     * @return array
     */
    static function getAllPopup($site_id = 0)
    {
        if (!$site_id)
            $site_id = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('popup'))
            ->where('site_id=:site_id', array(':site_id' => $site_id))
            ->queryAll();
        $result = array();
        if ($data) {
            foreach ($data as $popup) {
                $result[$popup['id']] = $popup;
            }
        }
        return $result;
    }

    /**
     * Lấy tất cả popup trong group
     * @param type $group_id
     * @return array
     */
    static function getPopups($options = array())
    {
        if (!isset($options['limit']) || !$options['limit'])
            $options['limit'] = 10;

        $condition = 'site_id=:site_id AND actived=:actived';
        $params = array(
            ':site_id' => Yii::app()->siteinfo['site_id'],
            ':actived' => self::STATUS_ACTIVED
        );
        if(Yii::app()->user->isGuest){
            $condition .= ' AND popup_config<>:member_config';
            $params = array_merge($params, array('member_config' => Popups::POPUP_SHOW_MEMBER));
        }
        // add conditin store
        if (isset(Yii::app()->siteinfo['multi_store']) && Yii::app()->siteinfo['multi_store'] == 1) {
            $store_id = (isset($_SESSION['store']) && $_SESSION['store']) ? $_SESSION['store'] : 0;
            if ($store_id == 0) {
                if (isset(Yii::app()->siteinfo['store_default']) && Yii::app()->siteinfo['store_default']) {
                    $store_id = Yii::app()->siteinfo['store_default'];
                }
            }
            $condition .= " AND store_ids LIKE '%" . $store_id . "%'";
        }
        //
//        if (isset($options['enable_start_end_time']) && $options['enable_start_end_time']) {
            $condition .= " AND ((:start_time >= `start_time`";
            $params[':start_time'] = time();
            $condition .= ' AND :end_time <= end_time';
            $params[':end_time'] = time();
            $params[':end_time'] = time();
            $condition .= ') OR  start_time is null)';
//        }
        //
        $bannes = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('popup'))
            ->where($condition, $params)
//            ->limit($options['limit'])
            ->order('popup_order')
            ->queryAll();
        if(count($bannes)){
            foreach($bannes as $key => $banner){
                $bannes[$key]['store_time_unix'] = self::convert2Unix($banner['store_time'],$banner['store_time_type']);
            }
        }
        return $bannes;
    }

    public static function convert2Unix($time,$type){
        $result = 0;
        if(!isset($time) || !$time){
            return $result;
        }
        switch ($type) {
            case self::TYPE_SEC:
                $result = $time * 1000;
            break;
            case self::TYPE_MINUTE:
                $result = $time * 60 *1000;
            break;
            case self::TYPE_HOUR:
                $result = $time * 60 *60 *1000;
            break;
            case self::TYPE_DAY:
                $result = $time * 60 *60 * 24 *1000;
            break;
            case self::TYPE_MONTH:
                $result = $time * 60 *60 * 24 * 30 * 1000;
            break;
        }
        return $result;
    }

    /**
     * Filter popup có thỏa mãn rules ko
     * @param type $popups
     * @param type $rules
     * @param type $options
     */
    static function filterPopups($popups = array(), $options = array())
    {
        $pagekey = (isset($options['pagekey'])) ? $options['pagekey'] : ClaSite::getLinkKey();
        $homepagekey = (isset($options['homepagekey'])) ? $options['homepagekey'] : ClaSite::getHomeKey();
        //
        $results = array();
        foreach ($popups as $popup) {
            if (self::checkShowPopup($popup, array('pagekey' => $pagekey, 'homepagekey' => $homepagekey)))
                $results[$popup['id']] = $popup;
        }
        //
        return $results;
    }

    /**
     * Kiểm tra xem popup này có được phép hiển thị ở trang này hay không?
     * @param type $popup
     * @param type $options
     * @return boolean
     */
    static function checkShowPopup($popup = null, $options = array())
    {
        $pagekey = (isset($options['pagekey'])) ? $options['pagekey'] : ClaSite::getLinkKey();
        $homepagekey = (isset($options['homepagekey'])) ? $options['homepagekey'] : ClaSite::getHomeKey();
        if ($pagekey == $homepagekey)
            $pagekey = self::POPUP_HOME_KEY;
        //
        if ($popup['popup_showall'])
            return true;
        else {
            $_rules = $popup['popup_rules'];
            $rules = explode(',', $_rules);
            // Check rule for product category
            if ($pagekey != 'economy/product/category') {
                if (in_array($pagekey, $rules)) {
                    return true;
                }
            } else {
                $cat_id = Yii::app()->request->getParam('id', 0);
                $subPageKey = 'ppage_' . $cat_id;
                if (in_array($pagekey, $rules) || in_array($subPageKey, $rules)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * trả về mang các key của trang theo popup
     * @return type
     */
    static function getPageKeyArr()
    {
        $pages = array(
            self::POPUP_HOME_KEY => Yii::t('menu', 'menu_link_home'),
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
        );
        $listpage = CategoryPage::getAllCategoryPage();
        foreach ($listpage as $pa) {
            $pages['cpage_' . $pa['id']] = $pa['title'];
        }
        $list_category = ClaCategory::getAllProductCategoryPage();
        foreach ($list_category as $ca) {
            $pages['ppage_' . $ca['cat_id']] = $ca['cat_name'];
        }
        //
        return $pages;
    }

    /**
     * trả về key thực tế của một page theo popup
     * @param type $key
     */
    static function getRealPageKey($key = '')
    {
        $keys = explode('_', $key);
        switch ($keys[0]) {
            case self::POPUP_SHOWALL_KEY:
                return self::POPUP_SHOWALL_KEY;
            case self::POPUP_HOME_KEY:
                return self::POPUP_HOME_KEY;
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
        }
        //
        return '';
    }
}
