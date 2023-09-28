<?php

/**
 *
 * The followings are the available columns in table 'menus':
 * @property integer $menu_id
 * @property integer $site_id
 * @property integer $user_id
 * @property string $menu_title
 * @property integer $parent_id
 * @property integer $menu_linkto
 * @property string $menu_link
 * @property string $menu_basepath
 * @property string $menu_pathparams
 * @property integer $menu_order
 * @property string $alias
 * @property integer $status
 * @property integer $menu_target
 * @property string $menu_values
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $modified_by
 * @property integer $menu_group
 * @property string $icon_path
 * @property string $icon_name
 * @property string $background_path
 * @property string $background_name
 * @property string $store_ids
 */
class Menus extends ActiveRecord
{

    const LINKTO_OUTER = 0;
    const LINKTO_INNER = 1;
    const TARGET_BLANK = 0;
    const TARGET_UNBLANK = 1;
    const FILE_SIZE_MIN = 1; // file size min 1bit 
    const FILE_SIZE_MAX = 1000000; // file size max 100Kb
    // group for menu
    //const MENU_GROUP_MAIN = 1;
    //const MENU_GrOUP_FOOTER = 2;
    //
    const MENU_TYPE_MAIN = 1;
    const MENU_TYPE_CUSTOM = 0;
    //
    const MENUTYPE_MAX = 2;
    //
    const MENUTYPE_NORMAL = 1; // Normal as: about us, 
    const MENUTYPE_NEWS = 2; // News
    const MENUTYPE_PRODUCT = 4; // Product
    const MENUTYPE_SHAREHOLDER_RELATIONS = 39; // Quan hệ cổ đông
    const MENUTYPE_CATEGORYPAGE = 3; // Trang chuyên mục
    const MENUTYPE_POST = 9; // Post
    const MENUTYPE_ALBUMS = 17; // Albums
    const MENUTYPE_COURSE = 18; // Course
    const MENUTYPE_EVENT = 25; // Course
    const MENUTYPE_REALESTATE = 19; // Bất động sản
    const MENUTYPE_REALESTATENEWS = 20; // Tin bất động sản rao vặt
    const MENUTYPE_CAR = 33; // Tin bất động sản rao vặt
    const MENUTYPE_CAR_DETAIL = 21; // Tin bất động sản rao vặt
    const MENUTYPE_CAR_CATEGORY = 35; // Tin bất động sản rao vặt
    const MENUTYPE_TOUR = 22; // Tin bất động sản rao vặt
    const MENUTYPE_TOUR_HOTEL = 34; // Khách sạn
    const MENUTYPE_VIDEO = 23; // Video
    const MENUTYPE_CUSTOMFORM = 24;
    const MENUTYPE_PROJECT_CONFIG = 26;
    const MENUTYPE_SERVICE = 27; // Dịch vụ
    const MENUTYPE_BANNER = 28;
    const MENUTYPE_BRAND = 29; // thương hiệu
    const MENUTYPE_GIFT_CARD = 30; // gift card campaign
    const MENUTYPE_QUESTION_CAMPAIGN = 31; // question campaign
    const MENUTYPE_FOLDER = 32; // question campaign
    //
    //
    const MENUTYPE_OBJECT_NEWSCATEGORY = 5;
    const MENUTYPE_OBJECT_PRODUCTCATEGORY = 6;
    const MENUTYPE_OBJECT_PRODUCT_PROMOTION = 10;
    const MENUTYPE_OBJECT_PRODUCTCATEGORY_LEVEL_ONE = 9;
    const MENUTYPE_OBJECT_NEWSDETAIL = 7;
    const MENUTYPE_OBJECT_PRODUCTDETAIL = 8;
    const MENUTYPE_OBJECT_TOURDETAIL = 109;
    const MENUTYPE_OBJECT_PRODUCTGROUP = 81;
    const MENUTYPE_OBJECT_MANUFACTURER = 107;
    const MENUTYPE_OBJECT_SHOPDETAIL = 112;
    const MENUTYPE_OBJECT_PRODUCT_CATEGORY_GROUP = 116;
    const MENUTYPE_OBJECT_POSTCATEGORY = 91;
    const MENUTYPE_OBJECT_POSTDETAIL = 92;
    const MENUTYPE_OBJECT_ALBUMSCATEGORY = 97;
    const MENUTYPE_OBJECT_COURSECATEGORY = 98;
    const MENUTYPE_OBJECT_EVENTCATEGORY = 102;
    const MENUTYPE_OBJECT_REALESTATECATEGORY = 99;
    const MENUTYPE_OBJECT_REALESTATEPROJECTCATEGORY = 104;
    const MENUTYPE_OBJECT_CARDETAIL = 100;
    const MENUTYPE_OBJECT_CARCATEGORY = 123;
    const MENUTYPE_OBJECT_PROJECT_DETAIL = 102;
    const MENUTYPE_OBJECT_TOURCATEGORY = 101;
    const MENUTYPE_OBJECT_TOURGROUP = 181;
    const MENUTYPE_OBJECT_TOURSTYLE = 187;
    const MENUTYPE_OBJECT_TOUR_HOTEL_DETAIL = 182;
    const MENUTYPE_OBJECT_TOUR_HOTEL_GROUP = 183;
    const MENUTYPE_OBJECT_VIDEOSCATEGORY = 97;
    const MENUTYPE_OBJECT_BANNERGROUP = 103;
    const MENUTYPE_OBJECT_SERVICECATEGORY = 271;
    const MENUTYPE_OBJECT_SHAREHOLDER = 272;
    const MENUTYPE_OBJECT_ALBUMSDETAIL = 333;
    const MENUTYPE_OBJECT_FOLDER = 334;
    //
    const MENU_NONE = 0;
    const MENU_HOME = 1;
    const MENU_CONTACT = 2;
    const MENU_INTRODUCE = 3;
    const MENU_LOGIN = 4;
    const MENU_SIGNUP = 5;
    const MENU_FORGOTPASSS = 6;
    const MENU_PROFILE = 7;
    const MENU_NEWS = 8;
    const MENU_PRODUCT = 9;
    const MENU_INTRODUCEPAGE = 10;
    const MENU_ALBUM = 11;
    const MENU_VIDEO = 12;
    const MENU_WORK = 13;
    const MENU_WORK_INTERVIEW = 14;
    const MENU_PRICING = 19;
    const MENU_CHOICETHEME = 20;
    const MENU_FOLDER = 21;
    const MENU_FOLDER_CATEGORY = 108;
    const MENU_COURSE = 29;
    const MENU_SITE_CONTACT_FORM = 30;
    const MENU_LECTURER = 31;
    const MENU_REALESTATE_PROJECT = 32;
    const MENU_REALESTATE_CREATE = 33;
    const MENU_REALESTATE_PROJECT_CREATE = 34;
    const MENU_REALESTATE_ADVERTISING = 35;
    const MENU_CAR_DETAIL = 38;
    const MENU_CAR_CATEGORY = 57;
    const MENU_TOUR = 36;
    const MENU_HOTEL = 37;
    const MENU_EVENT = 40;
    const MENU_CONSULTANT = 41;
    const MENU_REALESTATE_PROJECT_CONFIG = 42;
    const MENU_MANUFACTURER = 43;
    const MENU_NEW_PRODUCT = 91;
    const MENU_HOT_PRODUCT = 97;
    const MENU_GROUP_PRODUCT_ALL = 96;
    const MENU_PRODUCT_ADVANCED_SEARCH = 110;
    const MENU_SALE_PRODUCT = 92;
    const MENU_SHOP_STORE = 93;
    //
    const MENU_BOOK_TABLE = 94;
    const MENU_QUESTION = 95;
    const MENU_RMA = 111;
    const MENU_DOMAIN = 500;
    //
    const MENU_DIRECT_LEFT = 'left';
    const MENU_DIRECT_RIGHT = 'right';
    const MENU_DEFAULT_LIMIT = 500;
    const MENU_COLSMAX = 12;
    // MENU SERVICE
    const MENU_LIST_NAIL = 100;
    const MENU_LIST_SERVICE = 101;
    const MENU_BOOK_SERVICE = 102;
    const MENU_GIFT_CARD = 103;
    const MENU_SERVICE_PROVIDER = 104;
    //
    const MENU_QUESTION_CAMPAIGN = 105;
    const MENU_BOOK_SERVICE_NEW = 106;

    public $iconFile = '';
    public $backgroundFile = '';
    public $backStore = array();

    //

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return $this->getTableName('menus');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('menu_title, menu_linkto,menu_group', 'required'),
            array('site_id, user_id, menu_linkto, menu_order, status, menu_target, created_time, modified_time, modified_by', 'numerical', 'integerOnly' => true),
            array('menu_title, menu_basepath', 'length', 'max' => 255),
            array('menu_link', 'length', 'max' => 5000),
            array('alias', 'length', 'max' => 500),
            array('alias', 'isAlias'),
            array('menu_pathparams', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('menu_id, site_id, user_id, menu_title, parent_id, menu_linkto, menu_link, menu_basepath, menu_pathparams, menu_order, alias, status, menu_target, created_time, modified_time, modified_by, menu_values, menu_group, description, is_default_page, type_site, store_ids', 'safe'),
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
            'menu_id' => 'Menu',
            'site_id' => 'Site',
            'user_id' => 'User',
            'menu_title' => Yii::t('menu', 'menu_title'),
            'parent_id' => Yii::t('menu', 'menu_parent'),
            'menu_linkto' => Yii::t('menu', 'menu_linkto'),
            'menu_link' => Yii::t('menu', 'menu_link'),
            'menu_basepath' => 'Base path',
            'menu_pathparams' => 'Params',
            'menu_order' => Yii::t('common', 'order'),
            'alias' => Yii::t('common', 'alias'),
            'status' => Yii::t('status', 'status'),
            'menu_target' => Yii::t('menu', 'menu_target'),
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'modified_by' => 'Modified By',
            'menu_group' => Yii::t('menu', 'menu_group'),
            'iconFile' => Yii::t('menu', 'iconFile'),
            'backgroundFile' => Yii::t('menu', 'backgroundFile'),
            'description' => Yii::t('common', 'description'),
            'is_default_page' => Yii::t('setting', 'is_default_page'),
            'type_site' => Yii::t('site', 'type_site'),
            'store_ids' => Yii::t('shop', 'shop_store'),
        );
    }

    /**
     * Cho phép những loại file nào
     * @return type
     */
    static function allowExtensions()
    {
        return array(
            'image/jpeg' => 'image/jpeg',
            'image/gif' => 'image/gif',
            'image/png' => 'image/png',
            'image/bmp' => 'image/bmp',
            'image/x-icon' => 'image/x-icon',
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
        $model = new Menus;
        $model->menu_target = Menus::TARGET_UNBLANK;
        $clamenu = new ClaMenu(array(
            'create' => true,
            'group_id' => $this->menu_group,
            'showAll' => true,
        ));
        //
        $data = $clamenu->createArrayDataProvider(ClaMenu::MENU_ROOT);
        //
        return new CArrayDataProvider($data, array(
            'id' => 'NewsCategories',
            'keyField' => 'cat_id',
            'keys' => array('cat_id'),
            'pagination' => array(
                'pageSize' => count($data),
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Menus the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    function beforeSave()
    {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->user_id = Yii::app()->user->id;
            $this->modified_time = $this->created_time;
        } else {
            if (ClaSite::isDemoDomain()) {
                $this->created_time = time();
            }
            $this->modified_by = Yii::app()->user->id;
            $this->modified_time = time();
            if (!trim($this->alias) && $this->menu_title)
                $this->alias = HtmlFormat::parseToAlias($this->menu_title);
        }
        if ($this->store_ids) {
            $this->backStore = explode(' ', $this->store_ids);
        }
        return parent::beforeSave();
    }

    /**
     * Delete cache
     */
    function afterSave()
    {
        $claMenu = new ClaMenu(array('group_id' => $this->menu_group));
        $claMenu->deleteCache();
        $stores = array();
        if ($this->store_ids) {
            $stores = explode(' ', $this->store_ids);
        }
        $cacheStores = array_unique(array_merge($this->backStore, $stores));
        if ($cacheStores) {
            foreach ($cacheStores as $store) {
                $claMenu->deleteCache('', $store);
            }
        }
        parent::afterSave();
    }

    /**
     * Sau khi xóa menu thì xóa các menu con của nó
     */
    function afterDelete()
    {
        $menus = self::model()->findAllByAttributes(array(
            'parent_id' => $this->menu_id,
        ));
        if ($menus) {
            foreach ($menus as $menu)
                $menu->delete();
        }
        // Clear cache
        $claMenu = new ClaMenu(array('group_id' => $this->menu_group));
        $claMenu->deleteCache();
    }

    /**
     * get array link to
     * @return type
     */
    public static function getLinkToArr()
    {
        return array(
            self::LINKTO_OUTER => Yii::t('menu', 'menu_linkto_outer'),
            self::LINKTO_INNER => Yii::t('menu', 'menu_linkto_inner'),
        );
    }

    static function getMenuGroupArr()
    {
        $results = array();
        $groups = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('menu_group'))
            ->where('site_id=' . Yii::app()->siteinfo['site_id'])
            ->queryAll();
        foreach ($groups as $group) {
            $results[$group['menu_group_id']] = $group['menu_group_name'];
        }
        //
        return $results;
    }

    /**
     * get target arr
     * @return type
     */
    public static function getTagetArr()
    {
        return array(
            self::TARGET_UNBLANK => Yii::t('menu', 'menu_target_unblank'),
            self::TARGET_BLANK => Yii::t('menu', 'menu_target_blank'),
        );
    }

    /**
     * get Inner Link
     * @param type $options
     * @return type
     */
    static function getInnerLinks($options = array())
    {
        $array[Yii::t('menu', 'menu_type_normal')] = self::getNormalLink();
        $array[Yii::t('menu', 'menu_type_service')] = self::getServiceLink();
        $array[Yii::t('menu', 'menu_type_product')] = self::getProductLink();
        $array[Yii::t('realestate', 'realestate')] = self::getRealestateLink();
        if (!isset($options['siteinfo'])) {
            $options['siteinfo'] = Yii::app()->siteinfo;
        }
        $array = array_merge($array, self::getLinkFollowSiteType($options['siteinfo']['site_type']));
        $categoriespage = self::getCategoryPageLink();

        if (count($categoriespage)) {
            $array = array_merge($array, array(Yii::t('menu', 'menu_type_categorypage') => $categoriespage));
        }

        $customform = self::getCustomformLink();

        if (count($customform)) {
            $array = array_merge($array, array(Yii::t('menu', 'custom_form') => $customform));
        }
        return $array;
    }

    /**
     * Get Product link
     * @return type
     */
    static function getProductLink()
    {
        $product = array(
            json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_PRODUCT)) => Yii::t('menu', 'menu_link_product'),
            json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_NEW_PRODUCT)) => Yii::t('menu', 'menu_link_new_product'),
            json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_HOT_PRODUCT)) => Yii::t('menu', 'menu_link_hot_product'),
            json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_GROUP_PRODUCT_ALL)) => Yii::t('menu', 'menu_link_group_product_all'),
            json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_SALE_PRODUCT)) => Yii::t('menu', 'menu_link_sale_product'),
            json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_PRODUCT_ADVANCED_SEARCH)) => Yii::t('menu', 'menu_link_advanced_search'),
            json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_SHOP_STORE)) => Yii::t('menu', 'menu_link_shop_store'),
        );
        return $product;
    }

    static function getServiceLink()
    {
        $normal = array(
            json_encode(array('t' => self::MENUTYPE_SERVICE, 'oi' => self::MENU_LIST_NAIL)) => Yii::t('menu', 'menu_link_list_nail'),
            json_encode(array('t' => self::MENUTYPE_SERVICE, 'oi' => self::MENU_LIST_SERVICE)) => Yii::t('menu', 'menu_link_list_service'),
            json_encode(array('t' => self::MENUTYPE_SERVICE, 'oi' => self::MENU_BOOK_SERVICE)) => Yii::t('menu', 'menu_book_service'),
            json_encode(array('t' => self::MENUTYPE_SERVICE, 'oi' => self::MENU_BOOK_SERVICE_NEW)) => Yii::t('menu', 'menu_book_service_new'),
            json_encode(array('t' => self::MENUTYPE_SERVICE, 'oi' => self::MENU_GIFT_CARD)) => Yii::t('menu', 'menu_gift_card'),
            json_encode(array('t' => self::MENUTYPE_SERVICE, 'oi' => self::MENU_SERVICE_PROVIDER)) => Yii::t('menu', 'menu_service_provider'),
        );
        return $normal;
    }

    public static function getQuestionCampaignLink()
    {
        $normal = array(
            json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_QUESTION_CAMPAIGN)) => Yii::t('menu', 'menu_question_campaign'),
        );
        return $normal;
    }

    public static function getQuestionCampaignDetailLink()
    {
        $results = array();
        $listcampaign = QuestionCampaign::getAllCampaignsLink();
        foreach ($listcampaign as $campaign) {
            $results[json_encode(array('t' => self::MENUTYPE_QUESTION_CAMPAIGN, 'oi' => (int)$campaign['id']))] = $campaign['name'];
        }
        return $results;
    }

    /**
     * Get Normal link
     * @return type
     */
    static function getNormalLink()
    {
        $normal = array(
            json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_NONE)) => Yii::t('menu', 'menu_link_none'),
            json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_HOME)) => Yii::t('menu', 'menu_link_home'),
            json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_CONTACT)) => Yii::t('menu', 'menu_link_contact'),
            json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_INTRODUCE)) => Yii::t('menu', 'menu_link_introduce'),
            json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_WORK)) => Yii::t('menu', 'menu_link_work'),
            json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_WORK_INTERVIEW)) => Yii::t('menu', 'menu_link_work_interview'),
            json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_LOGIN)) => Yii::t('menu', 'menu_link_login'),
            json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_SIGNUP)) => Yii::t('menu', 'menu_link_signup'),
            json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_FORGOTPASSS)) => Yii::t('menu', 'menu_link_forgotpass'),
            json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_PROFILE)) => Yii::t('menu', 'menu_link_profile'),
            json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_NEWS)) => Yii::t('menu', 'menu_link_news'),
            json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_MANUFACTURER)) => Yii::t('menu', 'menu_manufacturer'),
            json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_TOUR)) => Yii::t('menu', 'menu_link_tour'),
            json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_HOTEL)) => Yii::t('menu', 'menu_link_hotel'),
            json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_LECTURER)) => Yii::t('menu', 'menu_link_lecturer'),
            json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_CONSULTANT)) => Yii::t('menu', 'menu_link_consultant'),
            json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_COURSE)) => Yii::t('menu', 'menu_link_course'),
            json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_EVENT)) => Yii::t('menu', 'menu_link_event'),
            json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_ALBUM)) => Yii::t('menu', 'menu_link_album'),
            json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_VIDEO)) => Yii::t('menu', 'menu_link_video'),
            json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_FOLDER)) => Yii::t('menu', 'menu_link_folder'),
            json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_SITE_CONTACT_FORM)) => Yii::t('menu', 'form_site_contact'),
            json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_BOOK_TABLE)) => Yii::t('menu', 'menu_book_table'),
            json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_QUESTION)) => Yii::t('menu', 'menu_question'),
            json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_RMA)) => Yii::t('menu', 'menu_rma'),
            json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_DOMAIN)) => Yii::t('menu', 'menu_domain'),
        );
        if (Yii::app()->controller->site_id == ClaSite::ROOT_SITE_ID) {
            $normal += array(
                json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_CHOICETHEME)) => Yii::t('common', 'choicetheme'),
                json_encode(array('t' => self::MENUTYPE_NORMAL, 'oi' => self::MENU_PRICING)) => Yii::t('common', 'pricing'),
            );
        }
        return $normal;
    }

    static function getRealestateLink()
    {
        $realestate = array(
            json_encode(array('t' => self::MENUTYPE_REALESTATE, 'oi' => self::MENU_REALESTATE_PROJECT)) => Yii::t('realestate', 'page_realestate_project'),
            json_encode(array('t' => self::MENUTYPE_REALESTATE, 'oi' => self::MENU_REALESTATE_PROJECT_CONFIG)) => Yii::t('bds_project_config', 'page_project_config'),
            json_encode(array('t' => self::MENUTYPE_REALESTATE, 'oi' => self::MENU_REALESTATE_PROJECT_CREATE)) => Yii::t('realestate', 'realestate_project_create'),
            json_encode(array('t' => self::MENUTYPE_REALESTATE, 'oi' => self::MENU_REALESTATE_CREATE)) => Yii::t('realestate', 'realestate_create'),
            json_encode(array('t' => self::MENUTYPE_REALESTATE, 'oi' => self::MENU_REALESTATE_ADVERTISING)) => Yii::t('realestate', 'classifiedadvertising'),
        );
        return $realestate;
    }

    /**
     *  get category page link, link đến trang chuyên mục
     * @return type
     */
    static function getCategoryPageLink()
    {
        $results = array();
        $listpage = CategoryPage::getAllCategoryPage();
        foreach ($listpage as $pa) {
            $results[json_encode(array('t' => self::MENUTYPE_CATEGORYPAGE, 'oi' => (int)$pa['id']))] = $pa['title'];
        }
        return $results;
    }

    /**
     *  get category page link, link đến trang chuyên mục
     * @return array
     */
    static function getFolderLink()
    {
        $results = array();
        $listFolder = Folders::getAllFolders();
        foreach ($listFolder as $pa) {
            $results[json_encode(array('t' => self::MENUTYPE_FOLDER, 'oi' => (int)$pa['folder_id']))] = $pa['folder_name'];
        }
        return $results;
    }

    static function getGiftCardCampaignLink()
    {
        $results = array();
        $listcampaign = GiftCardCampaign::getAllCampaign();
        foreach ($listcampaign as $campaign) {
            $results[json_encode(array('t' => self::MENUTYPE_GIFT_CARD, 'oi' => (int)$campaign['id']))] = $campaign['title'];
        }
        return $results;
    }

    /**
     *  get brand link, link đến trang thương hiệu
     * @return type
     */
    public static function getBrandLink()
    {
        $results = array();
        $listpage = Brand::getAllBrand();
        foreach ($listpage as $pa) {
            $results[json_encode(array('t' => self::MENUTYPE_BRAND, 'oi' => (int)$pa['id']))] = $pa['name'];
        }
        return $results;
    }

    /**
     * get custom form link, link đến trang customform
     * @return type
     */
    static function getCustomformLink()
    {
        $results = array();
        $listform = Forms::getAllForm();
        foreach ($listform as $form) {
            $results[json_encode(array('t' => self::MENUTYPE_CUSTOMFORM, 'oi' => (int)$form['form_id']))] = $form['form_name'];
        }
        return $results;
    }

    /**
     * get link follow site type
     * @param type $site_type
     * @param type $siteinfo
     * @return array
     */
    static function getLinkFollowSiteType($site_type = 0, $siteinfo = array())
    {
        $site_type = (int)$site_type;
        $results = array();
        if (!$site_type)
            return $results;
        switch ($site_type) {
            case ClaSite::SITE_TYPE_ECONOMY:
            case ClaSite::SITE_TYPE_INTRODUCE:
                {
                    //Get News category
                    $newscategories = self::getNewsCategoryLink();
                    if ($newscategories && count($newscategories))
                        $results[Yii::t('news', 'news_category')] = $newscategories;
                    // Product cate
                    $productcategories = self::getProductCategoryLink();
                    if (count($productcategories))
                        $results[Yii::t('product', 'product_category')] = $productcategories;
                    // Product product
                    $productpromotion = self::getProductPromotion();
                    if (count($productpromotion))
                        $results[Yii::t('product', 'product_promotion')] = $productpromotion;

//                $productcategories_level_one = self::getProductCategoryLevelOneLink(); // Danh mục sản phẩm lấy
//                if (count($productcategories))
//                    $results[Yii::t('product', 'product_category_level_one')] = $productcategories_level_one;

                    $groups = self::getProductGroupLink();
                    if (count($groups))
                        $results[Yii::t('product', 'product_group')] = $groups;

                    $productManufacturer = self::getProductManufacturerLink();
                    if (count($productManufacturer))
                        $results[Yii::t('product', 'product_manufacturer_detail')] = $productManufacturer;

                    $news = self::getNewsDetailLink();
                    if (count($news))
                        $results[Yii::t('news', 'news_detail')] = $news;
                    // get menu albums category
                    $albumscategories = self::getAlbumsCategoryLink();
                    if ($albumscategories && count($albumscategories)) {
                        $results[Yii::t('album', 'album_category')] = $albumscategories;
                    }
                    // get menu videos category
                    $videoscategories = self::getVideosCategoryLink();
                    if ($videoscategories && count($videoscategories)) {
                        $results[Yii::t('video', 'video_category')] = $videoscategories;
                    }
                    // get menu course category
                    $coursecategories = self::getCourseCategoryLink();
                    if ($coursecategories && count($coursecategories)) {
                        $results[Yii::t('course', 'course_category')] = $coursecategories;
                    }
                    // get menu event category
                    $eventcategories = self::getEventCategoryLink();
                    if ($eventcategories && count($eventcategories)) {
                        $results[Yii::t('event', 'event_category')] = $eventcategories;
                    }
                    $realestatecategories = self::getRealestateCategoryLink();
                    if ($realestatecategories && count($realestatecategories)) {
                        $results[Yii::t('realestate', 'realestate_category')] = $realestatecategories;
                    }
                    //Get car detail Link
                    $cars = self::getCarDetailLink();
                    if (count($cars))
                        $results[Yii::t('car', 'car_detail')] = $cars;

                    // get car category link
                    $cars_category = self::getCarCategoryLink();
                    if (count($cars_category)) {
                        $results[Yii::t('car', 'car_category')] = $cars_category;
                    }

                    $projectConfig = self::getProjectConfigDetailLink();
                    if (count($projectConfig))
                        $results[Yii::t('real_estate', 'project_detail')] = $projectConfig;
                    // get menu tour category
                    $tourcategories = self::getTourCategoryLink();
                    if ($tourcategories && count($tourcategories)) {
                        $results[Yii::t('tour', 'tour_category')] = $tourcategories;
                    }
                }
            case ClaSite::SITE_TYPE_NEWS:
                {
                    $newscategories = self::getNewsCategoryLink();
                    if (count($newscategories))
                        $results[Yii::t('news', 'news_category')] = $newscategories;
                    $news = self::getNewsDetailLink();
                    if (count($news))
                        $results[Yii::t('news', 'news_detail')] = $news;
                }
                break;
        }

        $postcategories = self::getPostCategoryLink();
        if (count($postcategories))
            $results[Yii::t('post', 'post_category')] = $postcategories;
        //
        return $results;
    }

    /**
     * get link of post categoríe
     * @return type
     */
    static function getPostCategoryLink()
    {
        //
        $results = array();
        //
        $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_POST, 'showAll' => true, 'create' => true));
        //
        //
        $listcate = $category->createOptionArray();
        $listcate = ClaArray::removeFirstElement($listcate);
        //
        foreach ($listcate as $cat_id => $catname) {
            $results[json_encode(array('t' => self::MENUTYPE_POST, 'ot' => self::MENUTYPE_OBJECT_POSTCATEGORY, 'oi' => (int)$cat_id))] = $catname;
        }

        return $results;
    }

    /**
     * Lấy link đến chi tiết bài viết
     */
    static function getPostsDetailLink()
    {
        $posts = Posts::getAllPosts(array('limit' => self::MENU_DEFAULT_LIMIT));
        //
        $results = array();
        //
        foreach ($posts as $post) {
            $results[json_encode(array('t' => self::MENUTYPE_POST, 'ot' => self::MENUTYPE_OBJECT_POSTDETAIL, 'oi' => (int)$post['id']))] = $post['title'];
        }
        return $results;
    }

    /**
     * get link of news categoríe
     * @return type
     */
    static function getNewsCategoryLink()
    {
        //
        $results = array();
        //
        $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_NEWS, 'showAll' => true, 'create' => true));
        //
        //
        $listcate = $category->createOptionArray();
        $listcate = ClaArray::removeFirstElement($listcate);
        //
        foreach ($listcate as $cat_id => $catname) {
            $results[json_encode(array('t' => self::MENUTYPE_NEWS, 'ot' => self::MENUTYPE_OBJECT_NEWSCATEGORY, 'oi' => (int)$cat_id))] = $catname;
        }

        return $results;
    }

    static function getBannerGroupLink()
    {
        $results = array();
        $groups = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('banner_group'))
            ->where('site_id=' . Yii::app()->siteinfo['site_id'])
            ->queryAll();

        foreach ($groups as $group) {
            $results[json_encode(array('t' => self::MENUTYPE_BANNER, 'ot' => self::MENUTYPE_OBJECT_BANNERGROUP, 'oi' => (int)$group['banner_group_id']))] = $group['banner_group_name'];
        }

        return $results;
    }

    static function getMenuLinkShareHolder()
    {
        $results = array();
        $shareholders = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('shareholder_relations'))
            ->where('site_id=' . Yii::app()->siteinfo['site_id'])
            ->queryAll();

        foreach ($shareholders as $shareholder) {
            $results[json_encode(array('t' => self::MENUTYPE_SHAREHOLDER_RELATIONS, 'ot' => self::MENUTYPE_OBJECT_SHAREHOLDER, 'oi' => (int)$shareholder['id']))] = $shareholder['title'];
        }

        return $results;
    }

    /**
     * get link of albums categories
     */
    static function getAlbumsCategoryLink()
    {
        $results = array();
        $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_ALBUMS, 'showAll' => true, 'create' => true));
        $listcate = $category->createOptionArray();
        $listcate = ClaArray::removeFirstElement($listcate);

        foreach ($listcate as $cat_id => $catname) {
            $results[json_encode(array('t' => self::MENUTYPE_ALBUMS, 'ot' => self::MENUTYPE_OBJECT_ALBUMSCATEGORY, 'oi' => (int)$cat_id))] = $catname;
        }

        return $results;
    }

    static function getVideosCategoryLink()
    {
        $results = array();
        $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_VIDEO, 'showAll' => true, 'create' => true));
        $listcate = $category->createOptionArray();
        $listcate = ClaArray::removeFirstElement($listcate);

        foreach ($listcate as $cat_id => $catname) {
            $results[json_encode(array('t' => self::MENUTYPE_VIDEO, 'ot' => self::MENUTYPE_OBJECT_VIDEOSCATEGORY, 'oi' => (int)$cat_id))] = $catname;
        }

        return $results;
    }

    /**
     * get link of course categories
     */
    static function getCourseCategoryLink()
    {
        $results = array();
        $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_COURSE, 'showAll' => true, 'create' => true));
        $listcate = $category->createOptionArray();
        $listcate = ClaArray::removeFirstElement($listcate);

        foreach ($listcate as $cat_id => $catname) {
            $results[json_encode(array('t' => self::MENUTYPE_COURSE, 'ot' => self::MENUTYPE_OBJECT_COURSECATEGORY, 'oi' => (int)$cat_id))] = $catname;
        }

        return $results;
    }

    /**
     * get link of event categories
     */
    static function getEventCategoryLink()
    {
        $results = array();
        $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_EVENT, 'showAll' => true, 'create' => true));
        $listcate = $category->createOptionArray();
        $listcate = ClaArray::removeFirstElement($listcate);

        foreach ($listcate as $cat_id => $catname) {
            $results[json_encode(array('t' => self::MENUTYPE_EVENT, 'ot' => self::MENUTYPE_OBJECT_EVENTCATEGORY, 'oi' => (int)$cat_id))] = $catname;
        }

        return $results;
    }

    /**
     * get link of tour categories
     */
    static function getTourCategoryLink()
    {
        $results = array();
        $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_TOUR, 'showAll' => true, 'create' => true));
        $listcate = $category->createOptionArray();
        $listcate = ClaArray::removeFirstElement($listcate);

        foreach ($listcate as $cat_id => $catname) {
            $results[json_encode(array('t' => self::MENUTYPE_TOUR, 'ot' => self::MENUTYPE_OBJECT_TOURCATEGORY, 'oi' => (int)$cat_id))] = $catname;
        }

        return $results;
    }

    /**
     * get link of realestate categories
     */
    static function getRealestateCategoryLink()
    {
        $results = array();
        $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_REAL_ESTATE, 'showAll' => true, 'create' => true));
        $listcate = $category->createOptionArray();
        $listcate = ClaArray::removeFirstElement($listcate);

        foreach ($listcate as $cat_id => $catname) {
            $results[json_encode(array('t' => self::MENUTYPE_REALESTATENEWS, 'ot' => self::MENUTYPE_OBJECT_REALESTATECATEGORY, 'oi' => (int)$cat_id))] = $catname;
        }

        return $results;
    }

    /**
     * get link of realestate categories
     */
    static function getRealestateProjectCategoryLink()
    {
        $results = array();
        $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_REAL_ESTATE, 'showAll' => true, 'create' => true));
        $listcate = $category->createOptionArray();
        $listcate = ClaArray::removeFirstElement($listcate);

        foreach ($listcate as $cat_id => $catname) {
            $results[json_encode(array('t' => self::MENUTYPE_REALESTATENEWS, 'ot' => self::MENUTYPE_OBJECT_REALESTATEPROJECTCATEGORY, 'oi' => (int)$cat_id))] = $catname;
        }

        return $results;
    }

    /**
     * Lấy link đến chi tiết tin tức
     */
    static function getNewsDetailLink()
    {
        $news = News::getNewNews(array('limit' => self::MENU_DEFAULT_LIMIT));
        //
        $results = array();
        //
        foreach ($news as $news_id => $ne) {
            $results[json_encode(array('t' => self::MENUTYPE_NEWS, 'ot' => self::MENUTYPE_OBJECT_NEWSDETAIL, 'oi' => (int)$ne['news_id']))] = $ne['news_title'];
        }
        return $results;
    }

    /**
     * Lấy link đến chi tiết cửa hàng
     */

    /**
     * Lấy link đến chi tiết tin tức
     */
    static function getAlbumsDetailLink()
    {
        $albums = Albums::getAllAlbum(array('limit' => self::MENU_DEFAULT_LIMIT));
        //
        $results = array();
        //
        foreach ($albums as $album) {
            $results[json_encode(array('t' => self::MENUTYPE_ALBUMS, 'ot' => self::MENUTYPE_OBJECT_ALBUMSDETAIL, 'oi' => (int)$album['album_id']))] = $album['album_name'];
        }
        return $results;
    }

    /**
     * Lấy link đến chi tiết xe
     * by : Hatv
     */
    static function getCarDetailLink()
    {
        $cars = Car::getAllCars('id,name,alias');

        //
        $results = array();
        //
        foreach ($cars as $car_id => $car) {
            $results[json_encode(array('t' => self::MENUTYPE_CAR, 'ot' => self::MENUTYPE_OBJECT_CARDETAIL, 'oi' => (int)$car['id']))] = $car['name'];
        }
        return $results;
    }

    /**
     * Lấy link đến danh mục xe
     * by : Hatv
     */
    static function getCarCategoryLink()
    {
        $cars_category = CarCategories::getAllCarcategory('cat_id,cat_name,alias');
        //
        $results = array();
        //
        foreach ($cars_category as $cat_id => $cat) {
            $results[json_encode(array('t' => self::MENUTYPE_CAR, 'ot' => self::MENUTYPE_OBJECT_CARCATEGORY, 'oi' => (int)$cat['cat_id']))] = $cat['cat_name'];
        }
        return $results;
    }

    /**
     * Lấy link đến chi dự án bất động sản amber
     * by : Hatv
     */
    static function getProjectConfigDetailLink()
    {
        $realestateConfigProjects = BdsProjectConfig::getAllProjectMenus('id,name,alias');
        //
        $results = array();
        //
        foreach ($realestateConfigProjects as $item_id => $item) {
            $results[json_encode(array('t' => self::MENUTYPE_REALESTATENEWS, 'ot' => self::MENUTYPE_OBJECT_PROJECT_DETAIL, 'oi' => (int)$item['id']))] = $item['name'];
        }
        return $results;
    }

    /**
     * get link of news categoríe
     * @return type
     */
    static function getProductCategoryLink()
    {
        //
        $results = array();
        //
        $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_PRODUCT, 'showAll' => true, 'create' => true));
        //
        $listcate = $category->createOptionArray();
        $listcate = ClaArray::removeFirstElement($listcate);
        //
        foreach ($listcate as $cat_id => $catname) {
            $results[json_encode(array('t' => self::MENUTYPE_PRODUCT, 'ot' => self::MENUTYPE_OBJECT_PRODUCTCATEGORY, 'oi' => (int)$cat_id))] = $catname;
        }

        return $results;
    }

    /**
     * get link of news categoríe
     * @return type
     */
    static function getProductCategoryLevelOneLink()
    {
        //
        $results = array();
        //
        $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_PRODUCT, 'showAll' => true, 'create' => true));
        //
        $listcate = $category->createOptionArray();
        $listcate = ClaArray::removeFirstElement($listcate);
        //
        foreach ($listcate as $cat_id => $catname) {
            $results[json_encode(array('t' => self::MENUTYPE_PRODUCT, 'ot' => self::MENUTYPE_OBJECT_PRODUCTCATEGORY_LEVEL_ONE, 'oi' => (int)$cat_id))] = $catname;
        }

        return $results;
    }

    /**
     * get link of news categoríe
     * @return type
     */
    static function getProductPromotion()
    {
        //
        $results = array();
        //
        $groups = Promotions::getProductPromotionGroupArr();
        foreach ($groups as $group_id => $group_name) {
            $results[json_encode(array('t' => self::MENUTYPE_PRODUCT, 'ot' => self::MENUTYPE_OBJECT_PRODUCT_PROMOTION, 'oi' => (int)$group_id))] = $group_name;
        }
        return $results;
    }

    static function getProductGroupLink()
    {
        //
        $results = array();
        //
        $groups = ProductGroups::getProductGroupArr();
        foreach ($groups as $group_id => $group_name) {
            $results[json_encode(array('t' => self::MENUTYPE_PRODUCT, 'ot' => self::MENUTYPE_OBJECT_PRODUCTGROUP, 'oi' => (int)$group_id))] = $group_name;
        }
        return $results;
    }

    static function getGroupProductCategoryLink()
    {
        //
        $results = array();
        //
        $categories = ProductCategoryGroup::getCategoryGroupArr();
        //
        foreach ($categories as $group_id => $group_name) {
            $results[json_encode(array('t' => self::MENUTYPE_PRODUCT, 'ot' => self::MENUTYPE_OBJECT_PRODUCT_CATEGORY_GROUP, 'oi' => (int)$group_id))] = $group_name;
        }
        return $results;
    }

    static function getProductManufacturerLink()
    {
        //
        $results = array();
        //
        $manufacturer = Manufacturer::getManufacturerArr();
        foreach ($manufacturer as $group_id => $group_name) {
            $results[json_encode(array('t' => self::MENUTYPE_PRODUCT, 'ot' => self::MENUTYPE_OBJECT_MANUFACTURER, 'oi' => (int)$group_id))] = $group_name;
        }
        return $results;
    }

//    cửa hàng chi tiết
    static function getShopStoreDetail()
    {
        //
        $results = array();
        //
        $shops = ShopStore::getAllShopstore();
        foreach ($shops as $group_id => $shop) {
            $results[json_encode(array('t' => self::MENUTYPE_PRODUCT, 'ot' => self::MENUTYPE_OBJECT_SHOPDETAIL, 'oi' => (int)$shop['id']))] = $shop['name'];
        }
        return $results;
    }

    static function getTourGroupLink()
    {
        //
        $results = array();
        //
        $groups = TourGroups::getTourGroupArr();
        foreach ($groups as $group_id => $group_name) {
            $results[json_encode(array('t' => self::MENUTYPE_TOUR, 'ot' => self::MENUTYPE_OBJECT_TOURGROUP, 'oi' => (int)$group_id))] = $group_name;
        }
        return $results;
    }

    static function getTourHotelGroupLink()
    {
        //
        $results = array();
        //
        $groups = TourHotelGroup::getTourHotelGroupArr();
        foreach ($groups as $group_id => $group_name) {
            $results[json_encode(array('t' => self::MENUTYPE_TOUR_HOTEL, 'ot' => self::MENUTYPE_OBJECT_TOUR_HOTEL_GROUP, 'oi' => (int)$group_id))] = $group_name;
        }
        return $results;
    }

    /**
     * Lấy link đến chi tiết sản phẩm
     */
    static function getProductDetailLink()
    {
        $products = Product::getAllProducts(array('limit' => self::MENU_DEFAULT_LIMIT));
        //
        $results = array();
        //
        foreach ($products as $product) {
            $results[json_encode(array('t' => self::MENUTYPE_PRODUCT, 'ot' => self::MENUTYPE_OBJECT_PRODUCTDETAIL, 'oi' => (int)$product['id']))] = $product['name'];
        }
        return $results;
    }

    /**
     * Lấy link đến chi tiết sản phẩm
     */
    static function getTourDetailLink()
    {
        $products = Tour::getAlltours(array('limit' => self::MENU_DEFAULT_LIMIT));
        //
        $results = array();
        //
        foreach ($products as $product) {
            $results[json_encode(array('t' => self::MENUTYPE_TOUR, 'ot' => self::MENUTYPE_OBJECT_TOURDETAIL, 'oi' => (int)$product['id']))] = $product['name'];
        }
        return $results;
    }

    /**
     * Lấy link đến kiểu tour
     */
    static function getTourStyleLink()
    {
        //
        $results = array();
        //
        $styles = TourStyle::getAllstyle();
        foreach ($styles as $id => $style) {
            $results[json_encode(array('t' => self::MENUTYPE_TOUR, 'ot' => self::MENUTYPE_OBJECT_TOURSTYLE, 'oi' => (int)$id))] = $style;
        }
        return $results;
    }

    static function getTourHotelDetailLink()
    {
        $products = TourHotel::getAllHotel(array('limit' => self::MENU_DEFAULT_LIMIT));
        //
        $results = array();
        //
        foreach ($products as $product) {
            $results[json_encode(array('t' => self::MENUTYPE_TOUR_HOTEL, 'ot' => self::MENUTYPE_OBJECT_TOUR_HOTEL_DETAIL, 'oi' => (int)$product['id']))] = $product['name'];
        }
        return $results;
    }

    /**
     * Get info of link
     * @param type $linkinfo
     * @return boolean
     */
    static function getMenuLinkInfo($linkinfo = array())
    {
        if (!isset($linkinfo['t'])) {
            return false;
        }
        $return = array();
        switch ($linkinfo['t']) {
            case self::MENUTYPE_NORMAL:
                {
                    $return = self::getMenuLinkNormal($linkinfo);
                }
                break;
            case self::MENUTYPE_SERVICE:
                {
                    $return = self::getMenuLinkService($linkinfo);
                }
                break;
            case self::MENUTYPE_NEWS:
                {
                    $return = self::getMenuLinkNews($linkinfo);
                }
                break;
            case self::MENUTYPE_PRODUCT:
                {
                    $return = self::getMenuLinkProduct($linkinfo);
                }
                break;
            case self::MENUTYPE_CATEGORYPAGE:
                {
                    $return = self::getMenuLinkCategoryPage($linkinfo);
                }
                break;
            case self::MENUTYPE_FOLDER:
                {
                    $return = self::getMenuLinkFolderPage($linkinfo);
                }
                break;
            case self::MENUTYPE_GIFT_CARD:
                {
                    $return = self::getMenuLinkGiftCard($linkinfo);
                }
                break;
            case self::MENUTYPE_BRAND:
                {
                    $return = self::getMenuLinkBrand($linkinfo);
                }
                break;
            case self::MENUTYPE_POST:
                {
                    $return = self::getMenuLinkPost($linkinfo);
                }
                break;
            case self::MENUTYPE_ALBUMS:
                {
                    $return = self::getMenuLinkAlbum($linkinfo);
                }
                break;
            case self::MENUTYPE_BANNER:
                {
                    $return = self::getMenuLinkBanner($linkinfo);
                }
                break;
            case self::MENUTYPE_SHAREHOLDER_RELATIONS:
                {
                    $return = self::getMenuLinkShareholders($linkinfo);
                }
                break;
            case self::MENUTYPE_VIDEO:
                {
                    $return = self::getMenuLinkVideo($linkinfo);
                }
                break;
            case self::MENUTYPE_COURSE:
                {
                    $return = self::getMenuLinkCourse($linkinfo);
                }
                break;
            case self::MENUTYPE_EVENT:
                {
                    $return = self::getMenuLinkEvent($linkinfo);
                }
                break;
            case self::MENUTYPE_REALESTATE:
                {
                    $return = self::getMenuLinkRealestate($linkinfo);
                }
                break;
            case self::MENUTYPE_REALESTATENEWS:
                {
                    $return = self::getMenuLinkRealestateNews($linkinfo);
                }
                break;
            case self::MENUTYPE_CAR:
                {
                    $return = self::getMenuLinkCar($linkinfo);
                }
                break;
            case self::MENUTYPE_TOUR:
                {
                    $return = self::getMenuLinkTour($linkinfo);
                }
                break;
            case self::MENUTYPE_TOUR_HOTEL:
                {
                    $return = self::getMenuLinkTourHotel($linkinfo);
                }
                break;
            case self::MENUTYPE_CUSTOMFORM:
                {
                    $return = self::getMenuLinkCustomform($linkinfo);
                }
                break;
        }

        return $return;
    }

    /**
     * get url of category page
     * @param type $linkinfo
     * @return boolean
     */
    static function getMenuLinkCategoryPage($linkinfo = array())
    {
        $oid = (int)$linkinfo['oi'];
        if (!$oid)
            return false;
        $return = array();
        $page = CategoryPage::model()->findByPk($oid);
        if ($page) {
            if ($page->site_id == Yii::app()->controller->site_id) {
                $return = array(
                    'menu_basepath' => '/page/category/detail',
                    'menu_pathparams' => json_encode(array(
                        'id' => $oid,
                        'alias' => $page->alias,
                    )),
                );
            }
        }
        return $return;
    }

    /**
     * get url of category page
     * @param array $linkinfo
     * @return boolean
     */
    static function getMenuLinkFolderPage($linkinfo = array())
    {
        $oid = (int)$linkinfo['oi'];
        if (!$oid)
            return false;
        $return = array();
        $page = Folders::model()->findByPk($oid);
        if ($page) {
            if ($page->site_id == Yii::app()->controller->site_id) {
                $return = array(
                    'menu_basepath' => '/media/media/folderDetail',
                    'menu_pathparams' => json_encode(array(
                        'id' => $oid,
                        'alias' => $page->alias,
                    )),
                );
            }
        }
        return $return;
    }

    /**
     * get url of category page
     * @param type $linkinfo
     * @return boolean
     */
    static function getMenuLinkGiftCard($linkinfo = array())
    {
        $oid = (int)$linkinfo['oi'];
        if (!$oid) {
            return false;
        }
        $return = array();
        $campaign = GiftCardCampaign::model()->findByPk($oid);
        if ($campaign) {
            if ($campaign->site_id == Yii::app()->controller->site_id) {
                $return = array(
                    'menu_basepath' => '/media/giftCard/detail',
                    'menu_pathparams' => json_encode(array(
                        'id' => $oid,
                        'alias' => $campaign->alias,
                    )),
                );
            }
        }
        return $return;
    }

    /**
     * get url of brand
     * @param type $linkinfo
     * @return boolean
     */
    static function getMenuLinkBrand($linkinfo = array())
    {
        $oid = (int)$linkinfo['oi'];
        if (!$oid) {
            return false;
        }
        $return = array();
        $brand = Brand::model()->findByPk($oid);
        if ($brand) {
            if ($brand->site_id == Yii::app()->controller->site_id) {
                $return = array(
                    'menu_basepath' => '/economy/brand/detail',
                    'menu_pathparams' => json_encode(array(
                        'id' => $oid,
                        'alias' => $brand->alias,
                    )),
                );
            }
        }
        return $return;
    }

    /**
     * get url of customform
     * @param type $linkinfo
     * @return boolean
     */
    static function getMenuLinkCustomform($linkinfo = array())
    {
        $oid = (int)$linkinfo['oi'];
        if (!$oid) {
            return false;
        }
        $return = array();
        $customform = Forms::model()->findByPk($oid);
        if ($customform) {
            if ($customform->site_id == Yii::app()->controller->site_id) {
                $return = array(
                    'menu_basepath' => '/page/customform/detail',
                    'menu_pathparams' => json_encode(array(
                        'id' => $oid,
                        'alias' => HtmlFormat::parseToAlias($customform->form_name),
                    )),
                );
            }
        }
        return $return;
    }

    static function getMenuLinkBookTable($linkinfo = array())
    {
        $oid = (int)$linkinfo['oi'];
        if (!$oid) {
            return false;
        }
        $return = array();
        $customform = Forms::model()->findByPk($oid);
        if ($customform) {
            if ($customform->site_id == Yii::app()->controller->site_id) {
                $return = array(
                    'menu_basepath' => '/page/customform/detail',
                    'menu_pathparams' => json_encode(array(
                        'id' => $oid,
                        'alias' => HtmlFormat::parseToAlias($customform->form_name),
                    )),
                );
            }
        }
        return $return;
    }

    //

    /**
     * Get info of news link
     * @param type $linkinfo
     * @return boolean
     */
    static function getMenuLinkNews($linkinfo = array())
    {
        $oid = (int)$linkinfo['oi'];
        if (!isset($linkinfo['ot']) || !$oid)
            return false;
        $return = array();
        switch ($linkinfo['ot']) {
            case self::MENUTYPE_OBJECT_NEWSCATEGORY:
                {
                    $newscate = NewsCategories::model()->findByPk($oid);
                    if ($newscate) {
                        if ($newscate->site_id == Yii::app()->controller->site_id) {
                            $return = array(
                                'menu_basepath' => '/news/news/category',
                                'menu_pathparams' => json_encode(array(
                                    'id' => $oid,
                                    'alias' => $newscate->alias,
                                )),
                            );
                        }
                    }
                }
                break;
            case self::MENUTYPE_OBJECT_NEWSDETAIL:
                {
                    $news = News::model()->findByPk($oid);
                    if ($news) {
                        if ($news->site_id == Yii::app()->controller->site_id) {
                            $return = array(
                                'menu_basepath' => '/news/news/detail',
                                'menu_pathparams' => json_encode(array(
                                    'id' => $oid,
                                    'alias' => $news->alias,
                                )),
                            );
                        }
                    }
                }
                break;
        }
        return $return;
    }


    static function getMenuLinkCar($linkinfo = array())
    {
        $oid = (int)$linkinfo['oi'];
        if (!isset($linkinfo['ot']) || !$oid)
            return false;
        $return = array();
        switch ($linkinfo['ot']) {
            case self::MENUTYPE_OBJECT_CARDETAIL:
                {
                    $cars = Car::model()->findByPk($oid);
                    if ($cars) {
                        if ($cars->site_id == Yii::app()->controller->site_id) {
                            $return = array(
                                'menu_basepath' => '/car/car/detail',
                                'menu_pathparams' => json_encode(array(
                                    'id' => $oid,
                                    'alias' => $cars->alias,
                                )),
                            );
                        }
                    }
                }
                break;
            case self::MENUTYPE_OBJECT_CARCATEGORY:
                {
                    $cars = CarCategories::model()->findByPk($oid);
                    if ($cars) {
                        if ($cars->site_id == Yii::app()->controller->site_id) {
                            $return = array(
                                'menu_basepath' => '/car/car/category',
                                'menu_pathparams' => json_encode(array(
                                    'id' => $oid,
                                    'alias' => $cars->alias,
                                )),
                            );
                        }
                    }
                }
                break;
        }
        return $return;
    }

    static function getMenuLinkBanner($linkinfo = array())
    {
        $oid = (int)$linkinfo['oi'];
        if (!isset($linkinfo['ot']) || !$oid)
            return false;
        $return = array();
        switch ($linkinfo['ot']) {
            case self::MENUTYPE_OBJECT_BANNERGROUP:
                {
                    $bannergroup = BannerGroups::model()->findByPk($oid);
                    if ($bannergroup) {
                        if ($bannergroup->site_id == Yii::app()->controller->site_id) {
                            $return = array(
                                'menu_basepath' => '/media/banner/group',
                                'menu_pathparams' => json_encode(array(
                                    'id' => $oid,
                                    'alias' => HtmlFormat::parseToAlias($bannergroup->banner_group_name),
                                )),
                            );
                        }
                    }
                }
                break;
        }
        return $return;
    }

    static function getMenuLinkShareholders($linkinfo = array())
    {
        $oid = (int)$linkinfo['oi'];
        if (!isset($linkinfo['ot']) || !$oid)
            return false;
        $return = array();
        switch ($linkinfo['ot']) {
            case self::MENUTYPE_OBJECT_SHAREHOLDER:
                {
                    $shareholder = Shareholderrelations::model()->findByPk($oid);
                    if ($shareholder) {
                        if ($shareholder->site_id == Yii::app()->controller->site_id) {
                            $return = array(
                                'menu_basepath' => 'economy/shareholderrelations/detail',
                                'menu_pathparams' => json_encode(array(
                                    'id' => $oid,
                                    'alias' => HtmlFormat::parseToAlias($shareholder->alias),
                                )),
                            );
                        }
                    }
                }
                break;
        }
        return $return;
    }


    /**
     * Lấy thông tin về link đến danh mục album
     * @param type $linkinfo
     */
    static function getMenuLinkAlbum($linkinfo = array())
    {
        $oid = (int)$linkinfo['oi'];
        if (!isset($linkinfo['ot']) || !$oid)
            return false;
        $return = array();
        switch ($linkinfo['ot']) {
            case self::MENUTYPE_OBJECT_ALBUMSCATEGORY:
                {
                    $albumcate = AlbumsCategories::model()->findByPk($oid);
                    if ($albumcate) {
                        if ($albumcate->site_id == Yii::app()->controller->site_id) {
                            $return = array(
                                'menu_basepath' => '/media/album/category',
                                'menu_pathparams' => json_encode(array(
                                    'id' => $oid,
                                    'alias' => $albumcate->alias,
                                )),
                            );
                        }
                    }
                }
                break;
            case self::MENUTYPE_OBJECT_ALBUMSDETAIL:
                {
                    $albumdetail = Albums::model()->findByPk($oid);
                    if ($albumdetail) {
                        if ($albumdetail->site_id == Yii::app()->controller->site_id) {
                            $return = array(
                                'menu_basepath' => '/media/album/detail',
                                'menu_pathparams' => json_encode(array(
                                    'id' => $oid,
                                    'alias' => $albumdetail->alias,
                                )),
                            );
                        }
                    }
                }
                break;
        }
        return $return;
    }

    /**
     * Lấy thông tin về link đến danh mục video
     * @param type $linkinfo
     */
    static function getMenuLinkVideo($linkinfo = array())
    {
        $oid = (int)$linkinfo['oi'];
        if (!isset($linkinfo['ot']) || !$oid)
            return false;
        $return = array();
        switch ($linkinfo['ot']) {
            case self::MENUTYPE_OBJECT_VIDEOSCATEGORY:
                {
                    $videocate = VideosCategories::model()->findByPk($oid);
                    if ($videocate) {
                        if ($videocate->site_id == Yii::app()->controller->site_id) {
                            $return = array(
                                'menu_basepath' => '/media/video/category',
                                'menu_pathparams' => json_encode(array(
                                    'id' => $oid,
                                    'alias' => $videocate->alias,
                                )),
                            );
                        }
                    }
                }
                break;
        }
        return $return;
    }

    /**
     * Lấy thông tin về link đến danh mục course
     * @param type $linkinfo
     */
    static function getMenuLinkCourse($linkinfo = array())
    {
        $oid = (int)$linkinfo['oi'];
        if (!isset($linkinfo['ot']) || !$oid)
            return false;
        $return = array();
        switch ($linkinfo['ot']) {
            case self::MENUTYPE_OBJECT_COURSECATEGORY:
                {
                    $coursecate = CourseCategories::model()->findByPk($oid);
                    if ($coursecate) {
                        if ($coursecate->site_id == Yii::app()->controller->site_id) {
                            $return = array(
                                'menu_basepath' => '/economy/course/category',
                                'menu_pathparams' => json_encode(array(
                                    'id' => $oid,
                                    'alias' => $coursecate->alias,
                                )),
                            );
                        }
                    }
                }
                break;
        }
        return $return;
    }

    /**
     * Lấy thông tin về link đến danh mục event
     * @param type $linkinfo
     */
    static function getMenuLinkEvent($linkinfo = array())
    {

        $oid = (int)$linkinfo['oi'];
        if (!isset($linkinfo['ot']) || !$oid)
            return false;
        $return = array();
        switch ($linkinfo['ot']) {
            case self::MENUTYPE_OBJECT_EVENTCATEGORY:
                {
                    $eventcate = EventCategories::model()->findByPk($oid);
                    if ($eventcate) {
                        if ($eventcate->site_id == Yii::app()->controller->site_id) {
                            $return = array(
                                'menu_basepath' => '/economy/event/category',
                                'menu_pathparams' => json_encode(array(
                                    'id' => $oid,
                                    'alias' => $eventcate->alias,
                                )),
                            );
                        }
                    }
                }
                break;
        }
        return $return;
    }

    /**
     * Lấy thông tin về link đến danh mục course
     * @param type $linkinfo
     */
    static function getMenuLinkTour($linkinfo = array())
    {
        $oid = (int)$linkinfo['oi'];
        if (!isset($linkinfo['ot']) || !$oid)
            return false;
        $return = array();
        switch ($linkinfo['ot']) {
            case self::MENUTYPE_OBJECT_TOURCATEGORY:
                {
                    $tourcate = TourCategories::model()->findByPk($oid);
                    if ($tourcate) {
                        if ($tourcate->site_id == Yii::app()->controller->site_id) {
                            $return = array(
                                'menu_basepath' => '/tour/tour/category',
                                'menu_pathparams' => json_encode(array(
                                    'id' => $oid,
                                    'alias' => $tourcate->alias,
                                )),
                            );
                        }
                    }
                }
                break;
            case self::MENUTYPE_OBJECT_TOURGROUP:
                {
                    $group = TourGroups::model()->findByPk($oid);
                    if ($group && $group->site_id == Yii::app()->controller->site_id) {
                        $return = array(
                            'menu_basepath' => '/tour/tour/group',
                            'menu_pathparams' => json_encode(array(
                                'id' => $oid,
                                'alias' => $group->alias,
                            )),
                        );
                    }
                }
                break;
            case self::MENUTYPE_OBJECT_TOURSTYLE:
                {
                    $styles = TourStyle::model()->findByPk($oid);
                    if ($styles) {
                        if ($styles->site_id == Yii::app()->controller->site_id) {
                            $return = array(
                                'menu_basepath' => '/tour/tour/tourstyle',
                                'menu_pathparams' => json_encode(array(
                                    'id' => $oid,
                                    'alias' => $styles->alias,
                                )),
                            );
                        }
                    }
                }
                break;
            case self::MENUTYPE_OBJECT_TOURDETAIL:
                {
                    $tour = Tour::model()->findByPk($oid);
                    if ($tour) {
                        if ($tour->site_id == Yii::app()->controller->site_id) {
                            $return = array(
                                'menu_basepath' => '/tour/tour/detail',
                                'menu_pathparams' => json_encode(array(
                                    'id' => $oid,
                                    'alias' => $tour->alias,
                                )),
                            );
                        }
                    }
                }
                break;
        }
        return $return;
    }

//    Lấy thông tin về khách sạn
    static function getMenuLinkTourHotel($linkinfo = array())
    {
        $oid = (int)$linkinfo['oi'];
        if (!isset($linkinfo['ot']) || !$oid)
            return false;
        $return = array();
        switch ($linkinfo['ot']) {
            case self::MENUTYPE_OBJECT_TOUR_HOTEL_GROUP:
                {
                    $tourcate = TourHotelGroup::model()->findByPk($oid);
                    if ($tourcate) {
                        if ($tourcate->site_id == Yii::app()->controller->site_id) {
                            $return = array(
                                'menu_basepath' => '/tour/tourHotel/CategoryInGroup',
                                'menu_pathparams' => json_encode(array(
                                    'id' => $oid,
                                    'alias' => $tourcate->alias,
                                )),
                            );
                        }
                    }
                }
                break;
            case self::MENUTYPE_OBJECT_TOUR_HOTEL_DETAIL:
                {
                    $tour = TourHotel::model()->findByPk($oid);
                    if ($tour) {
                        if ($tour->site_id == Yii::app()->controller->site_id) {
                            $return = array(
                                'menu_basepath' => '/tour/tourHotel/detail',
                                'menu_pathparams' => json_encode(array(
                                    'id' => $oid,
                                    'alias' => $tour->alias,
                                )),
                            );
                        }
                    }
                }
                break;
        }
        return $return;
    }

    /**
     * Lấy thông tin về link đến danh mục realestate news
     * @param type $linkinfo
     */
    static function getMenuLinkRealestateNews($linkinfo = array())
    {
        $oid = (int)$linkinfo['oi'];
        if (!isset($linkinfo['ot']) || !$oid)
            return false;
        $return = array();
        switch ($linkinfo['ot']) {
//            case self::MENUTYPE_OBJECT_REALESTATECATEGORY: {
//                    $realestatecategory = RealEstateCategories::model()->findByPk($oid);
//                    if ($realestatecategory) {
//                        if ($realestatecategory->site_id == Yii::app()->controller->site_id) {
//                            $return = array(
//                                'menu_basepath' => '/news/realestateNews/category',
//                                'menu_pathparams' => json_encode(array(
//                                    'id' => $oid,
//                                    'alias' => $realestatecategory->alias,
//                                )),
//                            );
//                        }
//                    }
//                }
//                break;
            case self::MENUTYPE_OBJECT_REALESTATEPROJECTCATEGORY:
                {
                    $realestatecategory = RealEstateCategories::model()->findByPk($oid);
                    if ($realestatecategory) {
                        if ($realestatecategory->site_id == Yii::app()->controller->site_id) {
                            $return = array(
                                'menu_basepath' => '/news/realestateProject/category',
                                'menu_pathparams' => json_encode(array(
                                    'id' => $oid,
                                    'alias' => $realestatecategory->alias,
                                )),
                            );
                        }
                    }
                }
                break;
            case self::MENUTYPE_OBJECT_PROJECT_DETAIL:
                {
                    $realEstateProject = BdsProjectConfig::model()->findByPk($oid);
                    if ($realEstateProject) {
                        if ($realEstateProject->site_id == Yii::app()->controller->site_id) {
                            $return = array(
                                'menu_basepath' => '/bds/bdsProjectConfig/detail',
                                'menu_pathparams' => json_encode(array(
                                    'id' => $oid,
                                    'alias' => $realEstateProject->alias,
                                )),
                            );
                        }
                    }
                }
                break;
        }
        return $return;
    }

    /**
     * Lấy thông tin về link đến danh mục sản phẩm
     * @param type $linkinfo
     * @return boolean
     */
    static function getMenuLinkProduct($linkinfo = array())
    {
        $oid = (int)$linkinfo['oi'];
        if (!isset($linkinfo['ot']) || !$oid)
            return false;
        $return = array();
        switch ($linkinfo['ot']) {
            case self::MENUTYPE_OBJECT_PRODUCTCATEGORY:
                {
                    $productcate = ProductCategories::model()->findByPk($oid);
                    if ($productcate) {
                        if ($productcate->site_id == Yii::app()->controller->site_id) {
                            if ($linkinfo['type_site'] == ActiveRecord::TYPE_SITE_NORMAL) {
                                $return = array(
                                    'menu_basepath' => '/economy/product/category',
                                    'menu_pathparams' => json_encode(array(
                                        'id' => $oid,
                                        'alias' => $productcate->alias,
                                    )),
                                );
                            } elseif ($linkinfo['type_site'] == ActiveRecord::TYPE_SITE_B2B_FASHION) {
                                $return = array(
                                    'menu_basepath' => '/economy/shop/category',
                                    'menu_pathparams' => json_encode(array(
                                        'id' => $oid,
                                        'alias' => $productcate->alias,
                                    )),
                                );
                            }
                        }
                    }
                }
                break;
            case self::MENUTYPE_OBJECT_PRODUCTCATEGORY_LEVEL_ONE:
                {
                    $productcate = ProductCategories::model()->findByPk($oid);
                    if ($productcate) {
                        if ($productcate->site_id == Yii::app()->controller->site_id) {
                            if ($linkinfo['type_site'] == ActiveRecord::TYPE_SITE_NORMAL) {
                                $return = array(
                                    'menu_basepath' => '/economy/product/categoryLevelOne',
                                    'menu_pathparams' => json_encode(array(
                                        'id' => $oid,
                                        'alias' => $productcate->alias,
                                    )),
                                );
                            } elseif ($linkinfo['type_site'] == ActiveRecord::TYPE_SITE_B2B_FASHION) {
                                $return = array(
                                    'menu_basepath' => '/economy/shop/category',
                                    'menu_pathparams' => json_encode(array(
                                        'id' => $oid,
                                        'alias' => $productcate->alias,
                                    )),
                                );
                            }
                        }
                    }
                }
                break;
            case self::MENUTYPE_OBJECT_PRODUCTGROUP:
                {
                    $group = ProductGroups::model()->findByPk($oid);
                    if ($group && $group->site_id == Yii::app()->controller->site_id) {
                        $return = array(
                            'menu_basepath' => '/economy/product/group',
                            'menu_pathparams' => json_encode(array(
                                'id' => $oid,
                                'alias' => $group->alias,
                            )),
                        );
                    }
                }
                break;
            //
            case self::MENUTYPE_OBJECT_MANUFACTURER:
                {
                    $group = Manufacturer::model()->findByPk($oid);
                    if ($group && $group->site_id == Yii::app()->controller->site_id) {
                        $return = array(
                            'menu_basepath' => '/economy/product/manufacturerDetail',
                            'menu_pathparams' => json_encode(array(
                                'id' => $oid,
                                'alias' => $group->alias,
                            )),
                        );
                    }
                }
                break;
            case self::MENUTYPE_OBJECT_SHOPDETAIL:
                {
                    $group = ShopStore::model()->findByPk($oid);
                    if ($group && $group->site_id == Yii::app()->controller->site_id) {
                        $return = array(
                            'menu_basepath' => '/economy/shop/storedetail/',
                            'menu_pathparams' => json_encode(array(
                                'id' => $oid,
                            )),
                        );
                    }
                }
                break;
            case self::MENUTYPE_OBJECT_PRODUCT_CATEGORY_GROUP:
                {
                    $group = ProductCategoryGroup::model()->findByPk($oid);
                    if ($group && $group->site_id == Yii::app()->controller->site_id) {
                        $return = array(
                            'menu_basepath' => '/economy/product/groupCategory',
                            'menu_pathparams' => json_encode(array(
                                'id' => $oid,
                                'alias' => $group->alias,
                            )),
                        );
                    }
                }
                break;
            ///
            case self::MENUTYPE_OBJECT_PRODUCT_PROMOTION:
                {
                    $promotion = Promotions::model()->findByPk($oid);
                    if ($promotion && $promotion->site_id == Yii::app()->controller->site_id) {
                        $return = array(
                            'menu_basepath' => '/economy/product/promotion',
                            'menu_pathparams' => json_encode(array(
                                'id' => $oid,
                                'alias' => $promotion->alias,
                            )),
                        );
                    }
                }
                break;
            case self::MENUTYPE_OBJECT_PRODUCTDETAIL:
                {
                    $product = Product::model()->findByPk($oid);
                    if ($product) {
                        if ($product->site_id == Yii::app()->controller->site_id) {
                            $return = array(
                                'menu_basepath' => '/economy/product/detail',
                                'menu_pathparams' => json_encode(array(
                                    'id' => $oid,
                                    'alias' => $product->alias,
                                )),
                            );
                        }
                    }
                }
                break;
        }
        return $return;
    }

    /**
     * Lấy thông tin về link đến danh mục bài viết
     * @param type $linkinfo
     * @return boolean
     */
    static function getMenuLinkPost($linkinfo = array())
    {
        $oid = (int)$linkinfo['oi'];
        if (!isset($linkinfo['ot']) || !$oid)
            return false;
        $return = array();
        switch ($linkinfo['ot']) {
            case self::MENUTYPE_OBJECT_POSTCATEGORY:
                {
                    $postcate = PostCategories::model()->findByPk($oid);
                    if ($postcate) {
                        if ($postcate->site_id == Yii::app()->controller->site_id) {
                            $return = array(
                                'menu_basepath' => '/content/post/category',
                                'menu_pathparams' => json_encode(array(
                                    'id' => $oid,
                                    'alias' => $postcate->alias,
                                )),
                            );
                        }
                    }
                }
                break;
            case self::MENUTYPE_OBJECT_POSTDETAIL:
                {
                    $posts = Posts::model()->findByPk($oid);
                    if ($posts) {
                        if ($posts->site_id == Yii::app()->controller->site_id) {
                            $return = array(
                                'menu_basepath' => '/content/post/detail',
                                'menu_pathparams' => json_encode(array(
                                    'id' => $oid,
                                    'alias' => $posts->alias,
                                )),
                            );
                        }
                    }
                }
        }
        return $return;
    }

    static function getMenuLinkRealestate($linkinfo = array())
    {
        if (!isset($linkinfo['oi'])) {
            return false;
        }
        $return = array();
        switch ($linkinfo['oi']) {
            case self::MENU_REALESTATE_PROJECT:
                {
                    $return = array(
                        'menu_basepath' => '/news/realestateProject/list',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_REALESTATE_PROJECT_CONFIG:
                {
                    $return = array(
                        'menu_basepath' => '/bds/bdsProjectConfig',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_REALESTATE_CREATE:
                {
                    $return = array(
                        'menu_basepath' => '/news/realestate/create',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_REALESTATE_PROJECT_CREATE:
                {
                    $return = array(
                        'menu_basepath' => '/news/realestateProject/create',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_REALESTATE_ADVERTISING:
                {
                    $return = array(
                        'menu_basepath' => '/news/realestate/classifiedAdvertising',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
        }
        return $return;
    }

    static function getMenuLinkService($linkinfo = array())
    {
        if (!isset($linkinfo['oi']))
            return false;
        $oid = (int)($linkinfo['oi']);
        $return = array();
        switch ($linkinfo['ot']) {
            case self::MENUTYPE_OBJECT_SERVICECATEGORY:
                {
                    $cate = SeCategories::model()->findByPk($oid);
                    if ($cate) {
                        if ($cate->site_id == Yii::app()->controller->site_id) {
                            $return = array(
                                'menu_basepath' => '/service/service/category',
                                'menu_pathparams' => json_encode(array(
                                    'id' => $oid,
                                    'alias' => $cate->alias,
                                )),
                            );
                        }
                    }
                }
                break;
            default:
                {
                    switch ($linkinfo['oi']) {
                        case self::MENU_LIST_NAIL:
                            {
                                $return = array(
                                    'menu_basepath' => '/site/site/listSitesNail',
                                    'menu_pathparams' => json_encode(array()),
                                );
                            }
                            break;
                        case self::MENU_LIST_SERVICE:
                            {
                                $return = array(
                                    'menu_basepath' => '/service/service/services',
                                    'menu_pathparams' => json_encode(array()),
                                );
                            }
                            break;
                        case self::MENU_BOOK_SERVICE:
                            {
                                $return = array(
                                    'menu_basepath' => '/service/service/book',
                                    'menu_pathparams' => json_encode(array()),
                                );
                            }
                            break;
                        case self::MENU_BOOK_SERVICE_NEW:
                            {
                                $return = array(
                                    'menu_basepath' => '/service/service/bookNew',
                                    'menu_pathparams' => json_encode(array()),
                                );
                            }
                            break;
                        case self::MENU_GIFT_CARD:
                            {
                                $return = array(
                                    'menu_basepath' => '/media/giftCard',
                                    'menu_pathparams' => json_encode(array()),
                                );
                            }
                            break;
                        case self::MENU_SERVICE_PROVIDER:
                            {
                                $return = array(
                                    'menu_basepath' => '/service/provider',
                                    'menu_pathparams' => json_encode(array()),
                                );
                            }
                            break;
                    }
                }
                break;
        }
        return $return;
    }

    /**
     * get link of news categoríe
     * @return type
     */
    static function getServiceCategoryLink()
    {
        //
        $results = array();
        //
        $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_SERVICE, 'showAll' => true, 'create' => true));
        //
        //
        $listcate = $category->createOptionArray();
        $listcate = ClaArray::removeFirstElement($listcate);
        //
        foreach ($listcate as $cat_id => $catname) {
            $results[json_encode(array('t' => self::MENUTYPE_SERVICE, 'ot' => self::MENUTYPE_OBJECT_SERVICECATEGORY, 'oi' => (int)$cat_id))] = $catname;
        }

        return $results;
    }

    //

    /**
     * get Info of normal link
     * @param type $linkinfo
     * @return string|boolean
     */
    static function getMenuLinkNormal($linkinfo = array())
    {
        if (!isset($linkinfo['oi']))
            return false;
        $return = array();
        switch ($linkinfo['oi']) {
            case self::MENU_NONE:
                {
                    $return = array(
                        'menu_basepath' => '',
                        'menu_pathparams' => '',
                    );
                }
                break;
            case self::MENU_HOME:
                {
                    $return = array(
                        'menu_basepath' => '',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_CONTACT:
                {
                    $return = array(
                        'menu_basepath' => '/site/site/contact',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_INTRODUCE:
                {
                    $return = array(
                        'menu_basepath' => '/site/site/introduce',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_LOGIN:
                {
                    $return = array(
                        'menu_basepath' => '/login/login/login',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_SIGNUP:
                {
                    $return = array(
                        'menu_basepath' => '/site/login/signup',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_FORGOTPASSS:
                {
                    $return = array(
                        'menu_basepath' => '/site/login/forgotpass',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_PROFILE:
                {
                    $return = array(
                        'menu_basepath' => '/profile/profile',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_NEWS:
                {
                    $return = array(
                        'menu_basepath' => '/news/news',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_MANUFACTURER:
                {
                    $return = array(
                        'menu_basepath' => '/economy/product/listManufacturer',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_INTRODUCEPAGE:
                {
                    $return = array(
                        'menu_basepath' => '/introduce/introduce',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_PRODUCT:
                {
                    $return = array(
                        'menu_basepath' => '/economy/product',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_NEW_PRODUCT:
                {
                    $return = array(
                        'menu_basepath' => '/economy/product/newproduct',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_HOT_PRODUCT:
                {
                    $return = array(
                        'menu_basepath' => '/economy/product/hotproduct',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_GROUP_PRODUCT_ALL:
                {
                    $return = array(
                        'menu_basepath' => '/economy/product/groupAll',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_SALE_PRODUCT:
                {
                    $return = array(
                        'menu_basepath' => '/economy/product/saleproduct',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_PRODUCT_ADVANCED_SEARCH:
                {
                    $return = array(
                        'menu_basepath' => '/economy/product/attributesearchform',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_SHOP_STORE:
                {
                    $return = array(
                        'menu_basepath' => '/economy/shop/store',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_TOUR:
                {
                    $return = array(
                        'menu_basepath' => '/tour/tour',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_HOTEL:
                {
                    $return = array(
                        'menu_basepath' => '/tour/tourHotel',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_ALBUM:
                {
                    $return = array(
                        'menu_basepath' => '/media/album/all',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_VIDEO:
                {
                    $return = array(
                        'menu_basepath' => '/media/video/all',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_FOLDER:
                {
                    $return = array(
                        'menu_basepath' => '/media/media/folder',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_WORK:
                {
                    $return = array(
                        'menu_basepath' => '/work/job/index',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_WORK_INTERVIEW:
                {
                    $return = array(
                        'menu_basepath' => '/work/job/interview',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_CHOICETHEME:
                {
                    $return = array(
                        'menu_basepath' => 'site/build/choicetheme',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_PRICING:
                {
                    $return = array(
                        'menu_basepath' => 'site/site/pricing',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_COURSE:
                {
                    $return = array(
                        'menu_basepath' => 'economy/course',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_EVENT:
                {
                    $return = array(
                        'menu_basepath' => 'economy/event',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_SITE_CONTACT_FORM:
                {
                    $return = array(
                        'menu_basepath' => 'media/media/siteContactForm',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_LECTURER:
                {
                    $return = array(
                        'menu_basepath' => 'economy/lecturer',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_CONSULTANT:
                {
                    $return = array(
                        'menu_basepath' => 'economy/consultant',
                        'menu_pathparams' => json_encode(array()),
                    );
                }
                break;
            case self::MENU_BOOK_TABLE:
                {
                    $return = array(
                        'menu_basepath' => 'economy/bookTable',
                        'menu_pathparams' => json_encode(array()),
                    );
                    break;
                }
            case self::MENU_QUESTION:
                {
                    $return = array(
                        'menu_basepath' => 'economy/question',
                        'menu_pathparams' => json_encode(array()),
                    );
                    break;
                }
            case self::MENU_QUESTION_CAMPAIGN:
                {
                    $return = array(
                        'menu_basepath' => 'service/questionCampaign',
                        'menu_pathparams' => json_encode(array()),
                    );
                    break;
                }
            case self::MENU_RMA:
                {
                    $return = array(
                        'menu_basepath' => 'economy/rma',
                        'menu_pathparams' => json_encode(array()),
                    );
                    break;
                }
            case self::MENU_DOMAIN:
                {
                    $return = array(
                        'menu_basepath' => 'domain/zcom',
                        'menu_pathparams' => json_encode(array()),
                    );
                    break;
                }
        }
        return $return;
    }

    /**
     * get all menu of site
     * @param type $site_id
     * @return type
     */
    static function getAllMenuInSite($site_id = 0, $order = "menu_order")
    {
        $site_id = (int)$site_id;
        if (!$site_id)
            $site_id = Yii::app()->controller->site_id;
        $results = array();
        if ($site_id) {
            $results = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('menus'))
                ->where('site_id=' . $site_id)
                ->order($order)
                ->queryAll();
        }

        return $results;
    }

    /**
     *
     * @param type $site_id
     * @param type $menu_group
     * @return type
     */
    static function getAllMenuInSiteOfGroup($site_id = 0, $menu_group = 0)
    {
        $site_id = (int)$site_id;
        $menu_group = (int)$menu_group;
        $results = array();
        if ($site_id && $menu_group) {
            $results = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('menus'))
                ->where('site_id=' . $site_id . ' AND menu_group=' . $menu_group)
                ->order('menu_order')
                ->queryAll();
        }
        //
        return $results;
    }

    static function getParentMenu($site_id = 0, $menu_group = 0)
    {
        $site_id = (int)$site_id;
        $menu_group = (int)$menu_group;
        $results = array();
        if ($site_id && $menu_group) {
            $results = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('menus'))
                ->where('site_id=' . $site_id . ' AND parent_id=' . $menu_group)
                ->order('menu_order')
                ->queryAll();
        }
        //
        return $results;
    }

    /**
     * check url is active or not
     * @param type $url
     */
    static function checkActive($url, $options = array())
    {
        $currenturl = '';
        if ($options['currenturl']) {
            $currenturl = $options['currenturl'];
        } else {
            $currenturl = Yii::app()->request->requestUri;
        }
        $item = isset($options['item']) ? $options['item'] : false;
        //
        $checkUrl = str_replace('/', '', $url);
        $currentUrl = str_replace('/', '', $currenturl);
        $return = ($checkUrl == $currentUrl || strpos($currentUrl, $checkUrl) !== false) ? true : false;
        //
        if (!$return && $item) {
            // for product category when filter with manufacture
            $menu_basepath = isset($item['menu_basepath']) ? $item['menu_basepath'] : '';
            if ($menu_basepath == '/economy/product/category') {
                $params = json_decode($item['menu_pathparams'], true);
                $id = isset($params['id']) ? $params['id'] : 0;
                $return = preg_match("/pc$id/", $currentUrl);
            }
        }
        //
        return $return;
    }

    /**
     * Kiểm tra target và trả về mã
     * @param type $menu
     */
    static function getTarget($menu = null)
    {
        $target = '';
        if ($menu && isset($menu['menu_target'])) {
            if ($menu['menu_target'] == self::TARGET_BLANK) {
                $target = 'target="_blank"';
            }
        }
        return $target;
    }

    /**
     *
     * @return type
     */
    static function getDirectFromArr()
    {
        return array(
            self::MENU_DIRECT_LEFT => Yii::t('common', 'left'),
            self::MENU_DIRECT_RIGHT => Yii::t('common', 'right'),
        );
    }

    /**
     *
     * @param type $menu
     */
    static function prepareDataForBuild($menu = array(), $store = array())
    {
        if (!isset($menu['menu_values'])) {
            $menu['menu_values'] = ClaGenerate::quoteValue($menu['menu_values']);
            $menu['menu_pathparams'] = ClaGenerate::quoteValue($menu['menu_pathparams']);
            return $menu;
        }
        //
        $linkinfo = json_decode($menu['menu_values'], true);
        //
        $mysql_variable = '';
        $mysql_table = '';
        switch ($linkinfo['t']) {
            case self::MENUTYPE_NEWS:
                {
                    switch ($linkinfo['ot']) {
                        case self::MENUTYPE_OBJECT_NEWSCATEGORY:
                            {
                                $mysql_table = ClaTable::getTable('newcategory');
                            }
                            break;
                        case self::MENUTYPE_OBJECT_NEWSDETAIL:
                            {
                                $mysql_table = ClaTable::getTable('news');
                            }
                            break;
                    }
                }
                break;
            case self::MENUTYPE_PRODUCT:
                {
                    switch ($linkinfo['ot']) {
                        case self::MENUTYPE_OBJECT_PRODUCTCATEGORY:
                            {
                                $mysql_table = ClaTable::getTable('productcategory');
                            }
                            break;
                        case self::MENUTYPE_OBJECT_PRODUCTDETAIL:
                            {
                                $mysql_table = ClaTable::getTable('product');
                            }
                            break;
                    }
                }
                break;
            case self::MENUTYPE_POST:
                {
                    switch ($linkinfo['ot']) {
                        case self::MENUTYPE_OBJECT_POSTCATEGORY:
                            {
                                $mysql_table = ClaTable::getTable('postcategory');
                            }
                            break;
                        case self::MENUTYPE_OBJECT_POSTDETAIL:
                            {
                                $mysql_table = ClaTable::getTable('post');
                            }
                            break;
                    }
                }
            case self::MENUTYPE_SERVICE:
                {
                    switch ($linkinfo['ot']) {
                        case self::MENUTYPE_OBJECT_SERVICECATEGORY:
                            {
                                $mysql_table = ClaTable::getTable('se_categories');
                            }
                            break;
                    }
                }
                break;
            case self::MENUTYPE_CATEGORYPAGE:
                {
                    $mysql_table = ClaTable::getTable('categorypage');
                }
                break;
            case self::MENUTYPE_BANNER:
                {
                    switch ($linkinfo['ot']) {
                        case self::MENUTYPE_OBJECT_BANNERGROUP:
                            {
                                $mysql_table = ClaTable::getTable('banner_group');
                            }
                            break;
                    }
                }
                break;
            case self::MENUTYPE_SHAREHOLDER_RELATIONS:
                {
                    switch ($linkinfo['ot']) {
                        case self::MENUTYPE_OBJECT_SHAREHOLDER:
                            {
                                $mysql_table = ClaTable::getTable('shareholder_relations');
                            }
                            break;
                    }
                }
                break;
        }
        if ($mysql_table) {
            $mysql_variable = $mysql_table . $linkinfo['oi'];
        }
        //
        if ($mysql_variable) {
            $oid = $linkinfo['oi'];
            $linkinfo['oi'] = 'msql_variable';
            $menu['menu_values'] = json_encode($linkinfo);
            $temp = explode('"msql_variable"', $menu['menu_values']);
            if (isset($store[$mysql_table][$oid])) {
                $menu['menu_values'] = "CONCAT('" . implode("',@" . $mysql_variable . ",'", $temp) . "')";
            } else {
                $menu['menu_values'] = ClaGenerate::quoteValue('');
            }
            //
            $menuparam = json_decode($menu['menu_pathparams'], true);
            $menuparam['id'] = 'msql_variable';
            $menu['menu_pathparams'] = json_encode($menuparam);
            $temp = explode('"msql_variable"', $menu['menu_pathparams']);
            $menu['menu_pathparams'] = "CONCAT('" . implode("',@" . $mysql_variable . ",'", $temp) . "')";
        } else {
            $menu['menu_values'] = ClaGenerate::quoteValue($menu['menu_values']);
            $menu['menu_pathparams'] = ClaGenerate::quoteValue($menu['menu_pathparams']);
        }
        //
        return $menu;
    }

    static function generateUrlPageContent($params)
    {
        $menu_pathparams = array();
        if ($params['menu_pathparams']) {
            $menu_pathparams = json_decode($params['menu_pathparams'], true);
        }
        if (!$menu_pathparams) {
            $menu_pathparams = array();
        }
        return str_replace(ClaSite::getAdminEntry() . '/', '', Yii::app()->createUrl($params['menu_basepath'], $menu_pathparams));
    }

    public static function cleanIsDefaultPage()
    {
        $site_id = Yii::app()->controller->site_id;
        $sql = "UPDATE menus SET is_default_page = 0 WHERE site_id=" . $site_id;
        Yii::app()->db->createCommand($sql)->execute();
        return;
    }

    /**
     *
     * @param type $linkinfo
     * @return boolean
     */
    static function getMenuTypes()
    {
        $return = array(
            self::MENUTYPE_NORMAL => Yii::t('menu', 'menu_type_normal'),
            self::MENUTYPE_QUESTION_CAMPAIGN => Yii::t('menu', 'menu_type_question_campaign'),
            self::MENUTYPE_NEWS => Yii::t('menu', 'menu_type_news'),
            self::MENUTYPE_PRODUCT => Yii::t('menu', 'menu_type_product'),
            self::MENUTYPE_SHAREHOLDER_RELATIONS => Yii::t('menu', 'shareholder_relations'),
            self::MENUTYPE_CATEGORYPAGE => Yii::t('menu', 'menu_type_categorypage'),
            self::MENUTYPE_GIFT_CARD => Yii::t('menu', 'menu_type_gift_card'),
            self::MENUTYPE_BRAND => Yii::t('menu', 'menu_type_brand'),
            self::MENUTYPE_POST => Yii::t('menu', 'menu_type_post'),
            self::MENUTYPE_SERVICE => Yii::t('menu', 'menu_type_service'),
            self::MENUTYPE_ALBUMS => Yii::t('menu', 'menu_type_album'),
            self::MENUTYPE_BANNER => Yii::t('menu', 'menu_type_banner'),
            self::MENUTYPE_VIDEO => Yii::t('menu', 'menu_type_video'),
            self::MENUTYPE_COURSE => Yii::t('menu', 'menu_type_course'),
            self::MENUTYPE_EVENT => Yii::t('menu', 'menu_type_event'),
            self::MENUTYPE_REALESTATE => Yii::t('realestate', 'realestate'),
            self::MENUTYPE_REALESTATENEWS => Yii::t('menu', 'menu_type_realestate_news'),
            self::MENUTYPE_CAR => Yii::t('menu', 'menu_type_car_detail'),
            self::MENUTYPE_TOUR => Yii::t('menu', 'menu_type_tour'),
            self::MENUTYPE_TOUR_HOTEL => Yii::t('menu', 'menu_type_tour_hotel'),
            self::MENUTYPE_CUSTOMFORM => Yii::t('menu', 'custom_form'),
            self::MENUTYPE_FOLDER => Yii::t('menu', 'menu_type_folder'),
        );
        return $return;
    }

    static function getMenuTypeOptions($type = '')
    {
        $return = array();
        switch ($type) {
            case self::MENUTYPE_NORMAL:
                {
                    $return[Yii::t('menu', 'menu_type_normal')] = self::getNormalLink();
                }
                break;
            case self::MENUTYPE_QUESTION_CAMPAIGN:
                {
                    //
                    $return[Yii::t('menu', 'menu_type_question_campaign')] = self::getQuestionCampaignLink();
                    //
                    $return[Yii::t('menu', 'menu_type_question_campaign_detail')] = self::getQuestionCampaignDetailLink();
                }
                break;
            case self::MENUTYPE_SERVICE:
                {
                    $return[Yii::t('menu', 'menu_type_service')] = self::getServiceLink();
                    // Product cate
                    $servicecategories = self::getServiceCategoryLink();
                    if (count($servicecategories)) {
                        $return[Yii::t('service', 'category')] = $servicecategories;
                    }
                }
                break;
            case self::MENUTYPE_NEWS:
                {
                    $newscategories = self::getNewsCategoryLink();
                    if (count($newscategories)) {
                        $return[Yii::t('news', 'news_category')] = $newscategories;
                    }
                    $news = self::getNewsDetailLink();
                    if (count($news)) {
                        $return[Yii::t('news', 'news_detail')] = $news;
                    }
                }
                break;
            case self::MENUTYPE_PRODUCT:
                {
                    $return[Yii::t('menu', 'menu_type_product')] = self::getProductLink();
                    // Product cate
                    $productcategories = self::getProductCategoryLink();
                    if (count($productcategories)) {
                        $return[Yii::t('product', 'product_category')] = $productcategories;
                    }
                    // Product product
                    $productpromotion = self::getProductPromotion();
                    if (count($productpromotion)) {
                        $return[Yii::t('product', 'product_promotion')] = $productpromotion;
                    }
                    $groups = self::getProductGroupLink();
                    if (count($groups)) {
                        $return[Yii::t('product', 'product_group')] = $groups;
                    }
                    $products = self::getProductDetailLink();
                    if ($products) {
                        $return[Yii::t('product', 'product_detail')] = $products;
                    }
                    $manufacturerDetail = self::getProductManufacturerLink();
                    if ($manufacturerDetail) {
                        $return[Yii::t('product', 'manufacturer_detail')] = $manufacturerDetail;
                    }
                    $shopDetail = self::getShopStoreDetail();
                    if ($shopDetail) {
                        $return[Yii::t('product', 'shop_store_detail')] = $shopDetail;
                    }
                    $groupCategory = self::getGroupProductCategoryLink();
                    if ($groupCategory) {
                        $return[Yii::t('product', 'group_product_category_link')] = $groupCategory;
                    }
                }
                break;
            case self::MENUTYPE_CATEGORYPAGE:
                {
                    $categoriespage = self::getCategoryPageLink();
                    $return[Yii::t('menu', 'menu_type_categorypage')] = $categoriespage;
                }
                break;
            case self::MENUTYPE_GIFT_CARD:
                {
                    $campaign = self::getGiftCardCampaignLink();
                    $return[Yii::t('menu', 'menu_type_gift_card')] = $campaign;
                }
                break;
            case self::MENUTYPE_BRAND:
                {
                    $brand = self::getBrandLink();
                    $return[Yii::t('menu', 'menu_type_brand')] = $brand;
                }
                break;
            case self::MENUTYPE_POST:
                {
                    $postcategories = self::getPostCategoryLink();
                    if (count($postcategories)) {
                        $return[Yii::t('post', 'post_category')] = $postcategories;
                    }
                    //
                    $posts = self::getPostsDetailLink();
                    if ($posts) {
                        $return[Yii::t('post', 'post_detail')] = $posts;
                    }
                }
                break;
            case self::MENUTYPE_ALBUMS:
                {
                    // get menu albums category
                    $albumscategories = self::getAlbumsCategoryLink();
                    if ($albumscategories && count($albumscategories)) {
                        $return[Yii::t('album', 'album_category')] = $albumscategories;
                    }
                    $albums = self::getAlbumsDetailLink();
                    if (count($albums)) {
                        $return[Yii::t('album', 'album_detail')] = $albums;
                    }
                }
                break;
            case self::MENUTYPE_BANNER:
                {
                    // get menu albums category
                    $bannergroup = self::getBannerGroupLink();
                    if ($bannergroup && count($bannergroup)) {
                        $return[Yii::t('banner', 'banner_group')] = $bannergroup;
                    }
                }
                break;
            case self::MENUTYPE_SHAREHOLDER_RELATIONS:
                {
                    // get menu albums category
                    $shareholder = self::getMenuLinkShareHolder();
                    if ($shareholder && count($shareholder)) {
                        $return[Yii::t('shareholder_relations', 'shareholder_relations')] = $shareholder;
                    }
                }
                break;
            case self::MENUTYPE_VIDEO:
                {
                    // get menu videos category
                    $videoscategories = self::getVideosCategoryLink();
                    if ($videoscategories && count($videoscategories)) {
                        $return[Yii::t('video', 'video_category')] = $videoscategories;
                    }
                }
                break;
            case self::MENUTYPE_COURSE:
                {
                    // get menu course category
                    $coursecategories = self::getCourseCategoryLink();
                    if ($coursecategories && count($coursecategories)) {
                        $return[Yii::t('course', 'course_category')] = $coursecategories;
                    }
                }
                break;
            case self::MENUTYPE_EVENT:
                {
                    // get menu event category
                    $eventcategories = self::getEventCategoryLink();
                    if ($eventcategories && count($eventcategories)) {
                        $return[Yii::t('event', 'event_category')] = $eventcategories;
                    }
                }
                break;
            case self::MENUTYPE_REALESTATE:
                {
                    $return[Yii::t('realestate', 'realestate')] = self::getRealestateLink();
                    $realestatecategories = self::getRealestateCategoryLink();
                    if ($realestatecategories && count($realestatecategories)) {
                        $return[Yii::t('realestate', 'realestate_category')] = $realestatecategories;
                    }
                }
                break;
            case self::MENUTYPE_REALESTATENEWS:
                {
                    $realestateprojectcategories = self::getRealestateProjectCategoryLink();
                    if ($realestateprojectcategories && count($realestateprojectcategories)) {
                        $return[Yii::t('realestate_news', 'realestate_category')] = $realestateprojectcategories;
                    }
                    $projectDetailLink = self::getProjectConfigDetailLink();
                    if ($projectDetailLink) {
                        $return[Yii::t('menu', 'realestate_project_detail')] = $projectDetailLink;
                    }
                }
                break;
            case self::MENUTYPE_CAR:
                {
                    //Get car category Link
                    $cars_category = self::getCarCategoryLink();
                    if (count($cars_category)) {
                        $return[Yii::t('car', 'car_category')] = $cars_category;
                    }
                    //Get car detail Link
                    $cars = self::getCarDetailLink();
                    if (count($cars)) {
                        $return[Yii::t('car', 'car_detail')] = $cars;
                    }
                }
                break;
            case self::MENUTYPE_TOUR:
                {
                    // get menu tour category
                    $tourcategories = self::getTourCategoryLink();
                    if ($tourcategories && count($tourcategories)) {
                        $return[Yii::t('tour', 'tour_hotel_category')] = $tourcategories;
                    }
                    $tourgroups = self::getTourGroupLink();
                    if (count($tourgroups)) {
                        $return[Yii::t('tour', 'tour_group')] = $tourgroups;
                    }
                    $tours = self::getTourDetailLink();
                    if ($tours) {
                        $return[Yii::t('tour', 'tour_detail')] = $tours;
                    }
                    $style = self::getTourStyleLink();
                    if ($style) {
                        $return[Yii::t('tour', 'tour_style')] = $style;
                    }
                }
                break;
            case self::MENUTYPE_TOUR_HOTEL:
                {
                    $tourhotelgroups = self::getTourHotelGroupLink();
                    if (count($tourhotelgroups)) {
                        $return[Yii::t('tour', 'tour_hotel_group')] = $tourhotelgroups;
                    }
                    $tours = self::getTourHotelDetailLink();
                    if ($tours) {
                        $return[Yii::t('tour', 'tour_hotel_detail')] = $tours;
                    }
                }
                break;
            case self::MENUTYPE_CUSTOMFORM:
                {
                    $customform = self::getCustomformLink();
                    if (count($customform)) {
                        $return[Yii::t('menu', 'custom_form')] = $customform;
                    }
                }
                break;
            case self::MENUTYPE_FOLDER:
                {
                    $folders = self::getFolderLink();
                    if (count($folders)) {
                        $return[Yii::t('menu', 'folder_file_download')] = $folders;
                    }
                }
                break;
        }

        return $return;
    }

    /**
     *
     * @param type $info
     */
    static function getSelectedLinkLabel($value = '')
    {
        $info = json_decode($value, true);
        // 
        $text = '';
        if ($info) {
            $menuTypeOptions = self::getMenuTypeOptions($info['t']);
            if ($menuTypeOptions) {
                foreach ($menuTypeOptions as $items) {
                    if (isset($items[$value])) {
                        $text = $items[$value];
                        break;
                    }
                }
            }
        }
        return $text;
    }

}
