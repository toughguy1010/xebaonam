<?php

/**
 * This is the model class for table "banners".
 *
 * The followings are the available columns in table 'banners':
 * @property integer $banner_id
 * @property integer $site_id
 * @property string $banner_name
 * @property string $banner_src
 * @property integer $banner_width
 * @property integer $banner_height
 * @property string $banner_link
 * @property integer $banner_order
 * @property string $banner_rules
 * @property integer $created_time
 * @property integer $banner_type
 * @property integer $banner_showall
 * @property integer $start_time
 * @property integer $end_time
 * @property string $store_ids
 */
class Banners extends ActiveRecord {

    const BANNER_TYPE_IMAGE = 1;
    const BANNER_TYPE_FLASH = 2;
    const BANNER_SHOWALL_KEY = 'all';
    const BANNER_HOME_KEY = 'home';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('banner');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('banner_type,banner_name, banner_src, banner_order', 'required'),
            array('banner_width, banner_height, banner_order, created_time, banner_type, banner_group_id', 'numerical', 'integerOnly' => true, 'min' => 0),
            array('banner_link, banner_name, banner_src, banner_link', 'length', 'max' => 255),
            array('banner_video_link', 'url'),
            array('end_time', 'compare', 'compareAttribute' => 'start_time', 'operator' => '>='),
            array('banner_id, site_id, banner_name, banner_src, banner_width, banner_height, banner_link, banner_video_link, banner_order, banner_rules, created_time, banner_type, banner_rules,banner_group_id, banner_description, banner_target,banner_showall, actived, store_ids, start_time, end_time,style', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'banner_id' => 'Banner',
            'site_id' => 'Site',
            'banner_group_id' => Yii::t('banner', 'banner_group'),
            'banner_name' => Yii::t('banner', 'banner_name'),
            'banner_src' => Yii::t('banner', 'banner_src'),
            'banner_width' => Yii::t('banner', 'banner_width'),
            'banner_height' => Yii::t('banner', 'banner_height'),
            'banner_link' => Yii::t('banner', 'banner_link'),
            'banner_video_link' => Yii::t('banner', 'banner_video_link'),
            'banner_order' => Yii::t('banner', 'banner_order'),
            'banner_rules' => Yii::t('banner', 'banner_rules'),
            'created_time' => 'Created Time',
            'banner_type' => Yii::t('banner', 'banner_type'),
            'banner_description' => Yii::t('banner', 'banner_description'),
            'banner_target' => Yii::t('banner', 'banner_target'),
            'banner_size' => Yii::t('common', 'size'),
            'actived' => Yii::t('common', 'show'),
            'store_ids' => Yii::t('shop', 'shop_store'),
            'start_time' => Yii::t('common', 'start_time'),
            'end_time' => Yii::t('common', 'end_time'),
            'style' => Yii::t('common', 'style'),
        );
    }

    function beforeSave() {
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('banner_id', $this->banner_id);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('banner_name', $this->banner_name, true);
        $criteria->compare('banner_src', $this->banner_src, true);
        $criteria->compare('banner_width', $this->banner_width);
        $criteria->compare('banner_height', $this->banner_height);
        $criteria->compare('banner_link', $this->banner_link, true);
        $criteria->compare('banner_video_link', $this->banner_video_link, true);
        $criteria->compare('banner_order', $this->banner_order);
        $criteria->compare('banner_rules', $this->banner_rules, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('banner_type', $this->banner_type);
        $criteria->compare('start_time', $this->start_time);
        $criteria->compare('end_time', $this->end_time);
        $criteria->compare('banner_group_id', $this->banner_group_id);

        $criteria->order = 'created_time DESC';

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
     * @return Banners the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Cho phép những loại file nào
     * @return array
     */
    static function allowExtensions() {
        return array(
            'image/jpeg' => 'image/jpeg',
            'image/gif' => 'image/gif',
            'image/png' => 'image/png',
            'image/bmp' => 'image/bmp',
            'application/x-shockwave-flash' => 'application/x-shockwave-flash',
        );
    }

    //
    /**
     * Lấy loại banner theo extension
     * @param type $extension
     * @return type
     */
    static function getBannerTypeFromEx($extension = '') {
        if (!$extension)
            return;
        switch ($extension) {
            case 'jpg':
            case 'jpeg':
            case 'jpe':
            case 'gif':
            case 'png':
            case 'bmp':
                return self::BANNER_TYPE_IMAGE;
            case 'swf':
                return self::BANNER_TYPE_FLASH;
        }
    }

    static function getBannerTypes() {
        return array(
            self::BANNER_TYPE_IMAGE => Yii::t('banner', 'banner_type_image'),
            self::BANNER_TYPE_FLASH => Yii::t('banner', 'banner_type_flash'),
        );
    }

    /**
     * Lấy loại banner theo url
     * @param type $src
     * @return type
     */
    static function getBannerTypeFromSrc($src = '') {
        $pathinfo = pathinfo($src);
        $extension = isset($pathinfo['extension']) ? $pathinfo['extension'] : '';
        return self::getBannerTypeFromEx($extension);
    }

    /**
     * Lấy tất cả banner của site
     * @param type $site_id
     * @return type
     */
    static function getBannerArr($site_id = 0) {
        if (!$site_id)
            $site_id = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('banner'))
                ->where('site_id=:site_id', array(':site_id' => $site_id))
                ->queryAll();
        $result = array();
        if ($data) {
            foreach ($data as $banner) {
                $result[$banner['banner_id']] = $banner['banner_name'];
            }
        }
        return $result;
    }

    //
    /**
     * Lấy thông tin của banner theo id
     * @param type $banner_id
     */
    static function getBannerData($banner_id = 0) {
        $result = array();
        if ($banner_id) {
            $banner = Banners::model()->findByPk($banner_id);
            if ($banner)
                $result = $banner->attributes;
        }
        //
        return $result;
    }

    /**
     * Lấy tất cả banner của site
     * @param type $site_id
     * @return type
     */
    static function getAllBanner($site_id = 0) {
        if (!$site_id)
            $site_id = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('banner'))
                ->where('site_id=:site_id', array(':site_id' => $site_id))
                ->queryAll();
        $result = array();
        if ($data) {
            foreach ($data as $banner) {
                $result[$banner['banner_id']] = $banner;
            }
        }
        return $result;
    }

    /**
     * Lấy tất cả các nhóm banner do người dùng tạo ra
     * @return type
     */
    static function getAllBannerGroup() {
        $results = array();
        $groups = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('banner_group'))
                ->where('site_id=' . Yii::app()->siteinfo['site_id'])
                ->queryAll();
        foreach ($groups as $group) {
            $results[$group['banner_group_id']] = $group;
        }
        //
        return $results;
    }

    /**
     * Lấy tất cả các nhóm banner do người dùng tạo ra
     * @return type
     */
    static function getBannerGroupArr() {
        $results = array();
        $groups = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('banner_group'))
                ->where('site_id=' . Yii::app()->siteinfo['site_id'])
                ->queryAll();
        foreach ($groups as $group) {
            $results[$group['banner_group_id']] = $group['banner_group_name'];
        }
        //
        return $results;
    }

    /**
     * Lấy tất cả các nhóm banner do người dùng tạo ra
     * @return type
     */
    static function getBannerGroupOptionsArr() {
        $results = array();
        $groups = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('banner_group'))
                ->where('site_id=' . Yii::app()->siteinfo['site_id'])
                ->queryAll();
        foreach ($groups as $group) {
            $results['data'][$group['banner_group_id']] = $group['banner_group_name'];
            $results['options'][$group['banner_group_id']] = array('size' => $group['width'] . '_' . $group['height'], 'data-style' => $group['banner_group_style']);
            $results['style'][$group['banner_group_id']] = ($group['banner_group_style']) ? json_decode($group['banner_group_style'], true) : array();
        }
        //
        return $results;
    }

    /**
     * Lấy tất cả banner trong group
     * @param type $group_id
     * @return array
     */
    static function getBannersInGroup($group_id = 0, $options = array()) {
        if (!isset($options['limit']) || !$options['limit'])
            $options['limit'] = self::MIN_DEFAUT_LIMIT;
        //
        $group_id = (int) $group_id;
        $result = array();


        if ($group_id) {

            $condition = 'site_id=:site_id AND banner_group_id=:banner_group_id AND actived=:actived';
            $params = array(
                ':site_id' => Yii::app()->siteinfo['site_id'],
                ':banner_group_id' => $group_id,
                ':actived' => self::STATUS_ACTIVED
            );

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
            if (isset($options['enable_start_end_time']) && $options['enable_start_end_time']) {
                $condition .= " AND :start_time >= `start_time` ";
                $params[':start_time'] = time();
                $condition .= ' AND :end_time <= end_time';
                $params[':end_time'] = time();
            }
            //

            $bannes = Yii::app()->db->createCommand()->select()
                    ->from(ClaTable::getTable('banner'))
                    ->where($condition, $params)
                    ->limit($options['limit'])
                    ->order('banner_order')
                    ->queryAll();
            return $bannes;
        }
        return $result;
    }

    /**
     * Filter banner có thỏa mãn rules ko
     * @param type $banners
     * @param type $rules
     * @param type $options
     */
    static function filterBanners($banners = array(), $options = array()) {
        $pagekey = (isset($options['pagekey'])) ? $options['pagekey'] : ClaSite::getLinkKey();
        $homepagekey = (isset($options['homepagekey'])) ? $options['homepagekey'] : ClaSite::getHomeKey();
        //
        $results = array();
        foreach ($banners as $banner) {
            if (self::checkShowBanner($banner, array('pagekey' => $pagekey, 'homepagekey' => $homepagekey)))
                $results[$banner['banner_id']] = $banner;
        }
        //
        return $results;
    }

    /**
     * Kiểm tra xem banner này có được phép hiển thị ở trang này hay không?
     * @param type $banner
     * @param type $options
     * @return boolean
     */
    static function checkShowBanner($banner = null, $options = array()) {
        $pagekey = (isset($options['pagekey'])) ? $options['pagekey'] : ClaSite::getLinkKey();
        $homepagekey = (isset($options['homepagekey'])) ? $options['homepagekey'] : ClaSite::getHomeKey();
        if ($pagekey == $homepagekey)
            $pagekey = self::BANNER_HOME_KEY;
        //
        if ($banner['banner_showall'])
            return true;
        else {
            $_rules = $banner['banner_rules'];
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
            $check = false;
            switch ($pagekey) {
                case 'economy/product/category': {
                        $cat_id = Yii::app()->request->getParam('id', 0);
                        $subPageKey = 'ppage_' . $cat_id;
                        if (in_array($pagekey, $rules) || in_array($subPageKey, $rules)) {
                            $check = true;
                        }
                    }break;
                case 'news/news/category': {
                        $cat_id = Yii::app()->request->getParam('id', 0);
                        $subPageKey = 'newscat_' . $cat_id;
                        if (in_array($pagekey, $rules) || in_array($subPageKey, $rules)) {
                            $check = true;
                        }
                    }break;
                default : {
                        if (in_array($pagekey, $rules)) {
                            $check = true;
                        }
                    }break;
            }
        }
        return $check;
    }

    //

    /**
     * Kiểm tra target và trả về mã
     * @param type $banner
     */
    static function getTarget($banner = null) {
        $target = '';
        if ($banner && isset($banner['banner_target'])) {
            if ($banner['banner_target'] == Menus::TARGET_BLANK)
                $target = 'target="_blank"';
        }
        return $target;
    }

    /**
     * trả về amngr các key của trang theo banner
     * @return type
     */
    static function getPageKeyArr() {
        $pages = [];
        $pages[1] = array(
            self::BANNER_HOME_KEY => Yii::t('menu', 'menu_link_home'),
            'sanpham' => Yii::t('menu', 'menu_link_product'),
            'danhmucsanpham' => Yii::t('product', 'product_category'),
            'chitietsanpham' => Yii::t('product', 'product_detail'),
            'danhmuctour' => Yii::t('product', 'danh_muc_tour'),
            'chitiettour' => Yii::t('product', 'chi_tiet_tour'),
            'dangkitour' => Yii::t('product', 'dang_ki_tour'),
            'tintuc' => Yii::t('menu', 'menu_link_news'),
            'danhmuctintuc' => Yii::t('news', 'news_category'),
            'chitiettintuc' => Yii::t('news', 'news_detail'),
            'khoahoc' => Yii::t('course', 'name'),
            'danhmuckhoahoc' => Yii::t('course', 'course_category'),
            'chitietkhoahoc' => Yii::t('course', 'course_detail') . ' ' . Yii::t('course', 'name'),
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
            $pages[2]['cpage_' . $pa['id']] = $pa['title'];
        }
        $list_category = ClaCategory::getAllProductCategoryPage(['limit' => 10000]);
        foreach ($list_category as $ca) {
            $pages[3]['ppage_' . $ca['cat_id']] = $ca['cat_name'];
        }
        //
        $newCategories = NewsCategories::getAllCategory();
        foreach ($newCategories as $cat) {
            $pages[4]['newscat_' . $cat['cat_id']] = $cat['cat_name'];
        }
        //
        return $pages;
    }

    /**
     * trả về amngr các key của trang theo banner
     * @return type
     */
    static function getPageKeyArrAdmin() {
        $pages = array(
            self::BANNER_HOME_KEY => Yii::t('menu', 'menu_link_home'),
            'sanpham' => Yii::t('menu', 'menu_link_product'),
            'danhmucsanpham' => Yii::t('product', 'product_category'),
            'chitietsanpham' => Yii::t('product', 'product_detail'),
            'danhmuctour' => Yii::t('product', 'danh_muc_tour'),
            'chitiettour' => Yii::t('product', 'chi_tiet_tour'),
            'dangkitour' => Yii::t('product', 'dang_ki_tour'),
            'tintuc' => Yii::t('menu', 'menu_link_news'),
            'danhmuctintuc' => Yii::t('news', 'news_category'),
            'chitiettintuc' => Yii::t('news', 'news_detail'),
            'khoahoc' => Yii::t('course', 'name'),
            'danhmuckhoahoc' => Yii::t('course', 'course_category'),
            'chitietkhoahoc' => Yii::t('course', 'course_detail') . ' ' . Yii::t('course', 'name'),
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
            $pages['cpage_' . $pa['id']] = $pa['title'];
        }
        $list_category = ClaCategory::getAllProductCategoryPage(['limit' => 10000]);
        foreach ($list_category as $ca) {
            $pages['ppage_' . $ca['cat_id']] = $ca['cat_name'];
        }
        //
        $newCategories = NewsCategories::getAllCategory();
        foreach ($newCategories as $cat) {
            $pages['newscat_' . $cat['cat_id']] = $cat['cat_name'];
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
            case self::BANNER_SHOWALL_KEY:
                return self::BANNER_SHOWALL_KEY;
            case self::BANNER_HOME_KEY:
                return self::BANNER_HOME_KEY;
            case 'album':
                return 'media/album/all';
            case 'video':
                return 'media/video/all';
            case 'sanpham':
                return 'economy/product/';
            case 'danhmucsanpham':
                return 'economy/product/category';
            case 'danhmuctour':
                return 'tour/tour/category';
            case 'chitietsanpham':
                return 'economy/product/detail';
            case 'chitiettour':
                return 'tour/tour/detail';
            case 'dangkitour':
                return 'tour/booking/';
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
            case 'khoahoc': {
                    return 'economy/course/';
                }
            case 'danhmuckhoahoc' : {
                    return 'economy/course/category';
                }
            case 'chitietkhoahoc': {
                    return 'economy/course/detail';
                }
            case 'cpage':
                return 'page/category/detail_' . $keys[1];
            case 'ppage':
                return 'ppage_' . $keys[1];
            case 'newscat':
                return 'newscat_' . $keys[1];
        }
        //
        return '';
    }

    public function getImages() {
        $result = array();
        if ($this->isNewRecord)
            return $result;
        $result = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('banner_partial'))
                ->where('banner_id=:banner_id AND site_id=:site_id', array(':banner_id' => $this->banner_id, ':site_id' => Yii::app()->controller->site_id))
                ->order('created_time')
                ->queryAll();

        return $result;
    }

    public static function getBannerPartial($id, $limit = 1) {
        $result = array();
        $result = Yii::app()->db->createCommand()
                ->select('*')
                ->from(ClaTable::getTable('banner_partial'))
                ->where('banner_id=:banner_id', array(':banner_id' => $id))
                ->order('position ASC')
                ->limit($limit)
                ->queryAll();

        return $result;
    }

}
