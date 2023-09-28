<?php

/**
 * @author minhbn <minhcoltech@gmail.com>
 * @date 18-02-2014
 *
 * Class for get info of site
 *
 */
class ClaSite {

    const CACHE_SITEINFO_PRE = 'siteinfo_';
    const CACHE_SITEADMIN_PRE = 'siteadmin_';
    const CACHE_DOMAIN_PRE = 'domain_';
    const CACHE_PAGE_SIZE_PRE = 'domain_';
    const SITE_TYPE_NEWS = 1; // Site for news
    const SITE_TYPE_ECONOMY = 2; // Site for sale
    const SITE_TYPE_INTRODUCE = 3; // Site for introduce
    const SITE_TYPE_EDU = 4; // Site for edu
    const SITE_TYPE_B2B = 5; // Site for b2b
    const SITE_TYPE_WORK = 6; // Site for work
    const SITE_TYPE_FILE = 8;  // Search file
    const SITE_TYPE_NAIL = 9;  // Site for nail
    const SITE_TYPE_TOUR = 10;  // Site for Tour
    const SITE_TYPE_CAR = 11;  // Site for Car
    //
    const SITE_TYPE_NEWS_NAME = 'news';
    const SITE_TYPE_ECONOMY_NAME = 'economy';
    const SITE_TYPE_WORK_NAME = 'work';
    const SITE_ADMIN_SESSION_NAME = 'admin_session';
    //
    const PAGE_VAR = 'page';
    const PAGE_SIZE_VAR = 'pageSize';
    const PAGE_SORT = 'sort';
    const PAGE_PRICE_FROM = 'fi_pmin';
    const PAGE_PRICE_TO = 'fi_pmax';
    //
    const SEARCH_KEYWORD = 'q';
    const SEARCH_TYPE = 't';
    const SEARCH_MIN_LENGHT = 2;
    const ROOT_SITE_ID = 1;
    const ADMIN_SESSION = 'website-user-session';
    const MOBILE_ALIAS = 'mobile';
    const MOBILE_DEFAULT_FOLDER = 'mobile_default';
    const LANGUAGE_KEY = 'lang';
    const LANGUAGE_ENCRYPTION = 'lang_enc';
    const PUBLIC_LANGUAGE_SESSION = 'p_lang_s';
    const BACK_LANGUAGE_SESSION = 'b_lang_s';
    const LANGUAGE_ACTION_KEY = 'actionKey';
    const SITE_STATUS_DISABLE = 20;
    const SITE_STATUS_UPGRADE = 21;
    const LIMIT_KEY = 'limit';
    const LANGUAGE_DEFAULT = language_default;
    const SEARCH_INDEX_TYPE_BOOK = 'news';
    const SEARCH_INDEX_TYPE_BOOK_CATEGORY = 'newscategory';
    const SEARCH_INDEX_TYPE_PRODUCT = 'product';
    const SEARCH_INDEX_TYPE_TOUR = 'tour';
    const SEARCH_INDEX_TYPE_PRODUCT_CATEGORY = 'productcategory';
    const SEARCH_INDEX_TYPE_TOUR_CATEGORY = 'tourcategory';
    const ENABLE_EDIT_MODULE_SESSION = 'enable_edit_module_session';
    const CAPTCHA_MAX_LENGTH = 3;

    /**
     *
     * @return string demo domain
     */
    public static function getDemoDomain() {
        return DOMAIN_DEMO;
    }

    /**
     * validate domain is demo or not
     * @param type $name
     * @return boolean
     */
    public static function isDemoDomain($name = '') {
        if (!$name)
            $name = self::getServerName();
        $demondomain = self::getDemoDomain();
        if (strpos($name, $demondomain) !== false)
            return true;
        return false;
    }

    /**
     * Kiểm tra xem trang được vào bằng mobile hay không
     */
    static function isMobile() {
        if (isset(Yii::app()->isMobile))
            return Yii::app()->isMobile;
        //
        $mobile = new ClaMobileDetect();
        return $mobile->isMobile();
    }

    /**
     * Kiểm tra xem có show module hay không
     * @return boolean
     */
    public static function ShowModule() {
        $admin = self::getAdminSession();
        $show = (isset(Yii::app()->session[ClaSite::ENABLE_EDIT_MODULE_SESSION]) && Yii::app()->session[ClaSite::ENABLE_EDIT_MODULE_SESSION] && isset($admin['user_id'])) ? true : false;
        return $show;
    }

    /**
     * Kiểm tra xem có phải là session của supper admin hay không
     */
    public static function isSupperAdminSession() {
        $admin = self::getAdminSession();
        return (self::checkAdminSessionExist() && isset($admin['user_id']) && $admin['user_id'] . '' == ClaUser::getSupperAdmin());
    }

    /**
     * return urlManager rules for public application
     */
    static function getPublicSiteRules() {
        $new_rewrite = array(
            Yii::t('url', 'product_priceday') => array('economy/product/priceday', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'sales_product') => array('economy/product/salesproduct', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'product_waitting') => array('economy/product/productwaitting', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'signup_rq') => array('login/login/signupRq', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'order-online') => array('/economy/shoppingcartTranslate/index', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'submit-rma') => array('/economy/rma', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'upload-file') => array('economy/shoppingcartTranslate/order', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'check-file') => array('economy/shoppingcartTranslate/checkfile', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'select-lang') => array('economy/shoppingcartTranslate/selectLang', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'select-option') => array('economy/shoppingcartTranslate/selectOption', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'check-out-translate') => array('economy/shoppingcartTranslate/selectLang', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'gioi-thieu-tiep-thi-lien-ket') => array('affiliate/affiliate/introduce', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'tiep-thi-lien-ket') => array('affiliate/affiliate/index', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'dang-ky-nhan-bao-gia') => array('economy/shoppingcartTranslate/fromRequest', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'phien-dich') => array('economy/interpretation/order', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'chon-cap-ngon-ngu-phien-dich') => array('economy/interpretation/selectLang', 'urlSuffix' => '.html', 'caseSensitive' => false),
//            'iframecraw' => array('economy/product/iframecraw', 'urlSuffix' => '.html', 'caseSensitive' => false),
//            'cua-hang<id:\d+>' => array('economy/shop/storedetail', 'urlSuffix' => '.html', 'caseSensitive' => false), // quản lý file
            'cua-hang-<alias>-<id:\d+>' => array('economy/shop/storedetail', 'urlSuffix' => '.html', 'caseSensitive' => false), // quản lý file
            //'<alias>-dfh2,<id:[0-9a-z]>' => array('media/media/detailfile', 'urlSuffix' => '.html', 'caseSensitive' => false), // chi tiet file
            '<alias>-mde<id>' => array('media/media/detailfile', 'urlSuffix' => '.html', 'caseSensitive' => false), // chi tiet file
            '<alias>-dfi<fid>' => array('media/media/file', 'urlSuffix' => '.html', 'caseSensitive' => false), // quản lý file
            '<alias>-qta<id:\d+>' => array('economy/question/detail', 'urlSuffix' => '.html', 'caseSensitive' => false), // quản lý file
            '<alias>-al<id:\d+>' => array('media/album/detail', 'urlSuffix' => '.html', 'caseSensitive' => false), // album ảnh
            '<alias>-ct<id:\d+>' => array('page/customform/detail', 'urlSuffix' => '.html', 'caseSensitive' => false), // album ảnh
            '<alias>-ac<id:\d+>' => array('media/album/category', 'urlSuffix' => '.html', 'caseSensitive' => false), // album ảnh
            '<alias>-vd<id:\d+>' => array('media/video/detail', 'urlSuffix' => '.html', 'caseSensitive' => false), // Chi tiết video
            '<alias>-vdc<id:\d+>' => array('media/video/category', 'urlSuffix' => '.html', 'caseSensitive' => false), // Chi tiết video
            '<alias>-pc<id:\d+>' => array('economy/product/category', 'urlSuffix' => '.html', 'caseSensitive' => false), // danh mục sản phẩm
            '<alias>-dac-san<id:\d+>' => array('economy/product/province', 'urlSuffix' => '.html', 'caseSensitive' => false), // danh mục sản phẩm
            'ds-vung-mien-<id:\d+>' => array('economy/product/groupProvince', 'urlSuffix' => '.html', 'caseSensitive' => false), // danh mục sản phẩm
            '<alias>-pcn<id:\d+>' => array('economy/product/categoryLevelOne', 'urlSuffix' => '.html', 'caseSensitive' => false), // danh mục sản phẩm
            '<alias>-bst<id:\d+>' => array('economy/product/groupCategory', 'urlSuffix' => '.html', 'caseSensitive' => false), // danh mục sản phẩm
            '<alias>-tc<id:\d+>' => array('tour/tour/category', 'urlSuffix' => '.html', 'caseSensitive' => false), // danh mục sản phẩm
            '<alias>-tg<id:\d+>' => array('tour/tour/group', 'urlSuffix' => '.html', 'caseSensitive' => false), // danh mục sản phẩm
            '<alias>-sc<id:\d+>' => array('economy/shop/category', 'urlSuffix' => '.html', 'caseSensitive' => false), // danh mục sản phẩm
            '<alias>-pcs<id:\d+>' => array('economy/product/categorySearch', 'urlSuffix' => '.html', 'caseSensitive' => false), // danh mục sản phẩm search
            '<alias>-pd<id:\d+>' => array('economy/product/detail', 'urlSuffix' => '.html', 'caseSensitive' => false), // chi tiết sản phẩm
            '<alias>-dt<id:\d+>' => array('economy/product/manufacturerDetail', 'urlSuffix' => '.html', 'caseSensitive' => false), // chi tiet doi tac
            '<alias>-thd<id:\d+>' => array('tour/tourHotel/detail', 'urlSuffix' => '.html', 'caseSensitive' => false), // chi tiết sản phẩm
            '<alias>-thdr<id:\d+>' => array('tour/tourHotel/detailRoom', 'urlSuffix' => '.html', 'caseSensitive' => false), // chi tiết sản phẩm
            '<alias>-td<id:\d+>' => array('tour/tour/detail', 'urlSuffix' => '.html', 'caseSensitive' => false), // chi tiết sản phẩm
            '<alias>-car<id:\d+>' => array('car/car/detail', 'urlSuffix' => '.html', 'caseSensitive' => false), // chi tiết sản phẩm
            Yii::t('url', 'car_compare') => array('car/car/addCompare', 'urlSuffix' => '.html', 'caseSensitive' => false), // so sanh xe
            '<alias>-sd<id:\d+>' => array('economy/shop/detail', 'urlSuffix' => '.html', 'caseSensitive' => false), // chi tiết sản phẩm
            '<alias>-cd<id:\d+>' => array('economy/course/detail', 'urlSuffix' => '.html', 'caseSensitive' => false), // chi tiết sản phẩm
            '<alias>-cc<id:\d+>' => array('economy/course/category', 'urlSuffix' => '.html', 'caseSensitive' => false), // chi tiết sản phẩm
            '<alias>-evd<id:\d+>' => array('economy/event/detail', 'urlSuffix' => '.html', 'caseSensitive' => false), // chi tiết sản phẩm
            '<alias>-evc<id:\d+>' => array('economy/event/category', 'urlSuffix' => '.html', 'caseSensitive' => false), // chi tiết sản phẩm
            '<alias>-ccul<id:\d+>' => array('economy/course/categoryunlimit', 'urlSuffix' => '.html', 'caseSensitive' => false), // chi tiết sản phẩm
            '<alias>-prm<id:\d+>' => array('/economy/product/promotion', 'urlSuffix' => '.html', 'caseSensitive' => false), // Chi tiết khuyến mãi
            '<alias>-pg<id:\d+>' => array('/economy/product/group', 'urlSuffix' => '.html', 'caseSensitive' => false), // Chi tiết khuyến mãi
            '<alias>-pde<id:\d+>' => array('page/category/detail', 'urlSuffix' => '.html', 'caseSensitive' => false), // Chi tiết trang chuyên mục
            'giveaway' => array('page/category/giveaway', 'urlSuffix' => '.html', 'caseSensitive' => false), // Chi tiết trang chuyên mục
            '<alias>-nc<id:\d+>' => array('news/news/category', 'urlSuffix' => '.html', 'caseSensitive' => false), // danh mục tin tức
            '<alias>-nd<id:\d+>' => array('news/news/detail', 'urlSuffix' => '.html', 'caseSensitive' => false), // Chi tiết tin tức
            '<alias>-wj<id:\d+>' => array('work/job/detail', 'urlSuffix' => '.html', 'caseSensitive' => false), // Chi tiết tin tuyển dụng
            '<alias>-poc<id:\d+>' => array('content/post/category', 'urlSuffix' => '.html', 'caseSensitive' => false), // Danh mục bài viết
            '<alias>-pod<id:\d+>' => array('content/post/detail', 'urlSuffix' => '.html', 'caseSensitive' => false), // Chi tiết bài viết
            '<alias>-eld<id:\d+>' => array('economy/lecturer/detail', 'urlSuffix' => '.html', 'caseSensitive' => false), // Chi tiết giảng viên
            '<alias>-csl<id:\d+>' => array('economy/consultant/detail', 'urlSuffix' => '.html', 'caseSensitive' => false),
            '<alias>-pred<id:\d+>' => array('news/realestate/project', 'urlSuffix' => '.html', 'caseSensitive' => false),
            '<alias>-nrd<id:\d+>' => array('news/realestate/detail', 'urlSuffix' => '.html', 'caseSensitive' => false),
            '<alias>-renc<id:\d+>' => array('news/realestateNews/category', 'urlSuffix' => '.html', 'caseSensitive' => false),
            '<alias>-nrnd<id:\d+>' => array('news/realestateNews/detail', 'urlSuffix' => '.html', 'caseSensitive' => false),
            '<alias>-nrpd<id:\d+>' => array('news/realestateProject/detail', 'urlSuffix' => '.html', 'caseSensitive' => false),
            '<alias>-rspc<id:\d+>' => array('news/realestateProject/category', 'urlSuffix' => '.html', 'caseSensitive' => false),
            '<alias>-pcd<id:\d+>' => array('bds/bdsProjectConfig/detail', 'urlSuffix' => '.html', 'caseSensitive' => false),
            '<alias>-fd<id:\d+>' => array('media/media/folderDetail/', 'urlSuffix' => '.html', 'caseSensitive' => false),
            'doi-ngu-chuyen-gia' => array('service/provider', 'urlSuffix' => '.html', 'caseSensitive' => false),
            '<alias>-pvd<id:\d+>' => array('service/provider/detail', 'urlSuffix' => '.html', 'caseSensitive' => false),
            'hoi-dap-truc-tuyen' => array('service/questionCampaign', 'urlSuffix' => '.html', 'caseSensitive' => false),
            '<alias>-tkp<id:\d+>' => array('site/timekeeping/show', 'urlSuffix' => '.html', 'caseSensitive' => false),
            'tour-hot' => array('tour/tour/tourHot', 'urlSuffix' => '.html', 'caseSensitive' => false),
            '<alias>-qcd<id:\d+>' => array('service/questionCampaign/detail', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'register_service') => array('car/service/registerService', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'register_service_success') => array('car/service/registerServiceSuccess', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'calculate_toyota_step_one') => array('car/buycar/calculateCostToyota', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'calculate_toyota_step_three') => array('car/buycar/calculateCostToyotaStep3', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'calculate_toyota_step_four') => array('car/buycar/calculateCostToyotaStep4', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'register_success') => array('site/form/success', 'urlSuffix' => '.html', 'caseSensitive' => false),
            'du-toan-chi-phi-toyota-step2-<id:\d+>' => array('car/buycar/calculateCostToyotaStep2', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'support_buycar_toyota') => array('car/buycar/supportBuyToyota', 'urlSuffix' => '.html', 'caseSensitive' => false),
            //--------- Backup Url below untill 6 month ------------------------------------------------------------------
        );
        //
        if (Yii::app()->siteinfo['site_id'] == 1498) {
            $new_rewrite[Yii::t('url', 'group-discount-all')] = array('economy/product/groupAll', 'urlSuffix' => '.html', 'caseSensitive' => false);
        } else {
            $new_rewrite[Yii::t('url', 'group-all')] = array('economy/product/groupAll', 'urlSuffix' => '.html', 'caseSensitive' => false);
        }
        // higgsup - Sửa cho Huy-Nx
        if (Yii::app()->siteinfo['site_id'] == 1881) {
            $new_rewrite[Yii::t('url', 'service')] = array('bds/bdsProjectConfig', 'urlSuffix' => '.html', 'caseSensitive' => false);
        } else {
            $new_rewrite[Yii::t('url', 'bds_project_config')] = array('bds/bdsProjectConfig', 'urlSuffix' => '.html', 'caseSensitive' => false);
        }

        // hungtuy - Sửa cho Huy-Nx
        if (Yii::app()->siteinfo['site_id'] == 1498) {
            $new_rewrite[Yii::t('url', 'sitemap')] = array('site/site/sitemapPageNew', 'urlSuffix' => '.html', 'caseSensitive' => false);
        } else {
            $new_rewrite[Yii::t('url', 'sitemap')] = array('site/site/sitemapPageNew', 'urlSuffix' => '.html', 'caseSensitive' => false);
        }
        //
        $old_rewrite = array(
            Yii::t('url', 'service_booking') => array('service/service/booking', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'service_booking_new') => array('service/service/bookNew', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'book_room_form') => array('tour/bookRoom/create', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'book_table') => array('economy/bookTable', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'checkout') => array('economy/shoppingcart/checkout', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'shoppingcart') => array('economy/shoppingcart', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'shoppingcarti') => array('economy/shoppingcart/index', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'site_request') => array('site/request/create', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'site_theme_order') . '-<theme>' => array('site/build/order', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'site_install') . '-<theme>' => array('site/build/install', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'choice_theme') => array('site/build/choicetheme', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'pricing') => array('site/site/pricing', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'jobs') => array('work/job/index', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'jobs_interview') => array('work/job/interview', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'download') => array('media/media/folder', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'download_file') => array('media/media/downloadfile', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'statistic') => array('home/useraccess', 'urlSuffix' => '.jpg', 'caseSensitive' => false),
            //'<' . ClaSite::LANGUAGE_KEY . ':\w{2}>/' . Yii::t('url', 'search') => array('search/search/search', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'search') => array('search/search/search', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'site_introduce') => array('site/site/introduce', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'contact') => array('site/site/contact', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'news-hot') => array('news/news/groupnewshot', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'news') => array('news/news', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'question') => array('economy/question', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'question_i') => array('economy/question/index', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'newsi') => array('news/news/index', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'product') => array('economy/product/', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'list_manufacturer') => array('economy/product/listManufacturer', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'newproduct') => array('economy/product/newproduct', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'hotproduct') => array('economy/product/hotproduct', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'saleproduct') => array('economy/product/saleproduct', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'promotion') => array('economy/product/promotionIndex', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'store') => array('economy/shop/store', 'urlSuffix' => '.html', 'caseSensitive' => false),
//            Yii::t('url', 'storedetail') => array('economy/shop/store', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'hotel') => array('tour/tourHotel/', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'tour') => array('tour/tour/', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'lecturer') => array('economy/lecturer/', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'consultant') => array('economy/consultant/', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'course') => array('economy/course/', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'event') => array('economy/event/', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'site_contact_form') => array('media/media/siteContactForm', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'producti') => array('economy/product/index', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'album') => array('media/album/all', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'video') => array('media/video/all', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'login') => array('login/login/login', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'signup') => array('login/login/signup', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'signup_verify') => array('login/login/signupVerify', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'site_error') => array('site/site/error', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'site_notfound') => array('site/site/notfound', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'lists_realestate_project') => array('news/realestateProject/list', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'list_realestate_project_index') => array('news/realestateProject/index', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'user_introduce') => array('login/login/userintroduce', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'classifiedadvertising') => array('news/realestate/classifiedAdvertising', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'realestate_news_create') => array('news/realestateNews/create', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'estimate_cost') => array('car/buycar/calculateCost', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'support_buycar') => array('car/buycar/supportBuycar', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'price_board_car') => array('car/car', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'car_register_try_drive') => array('car/service/registerTryDrive', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'car_register_try_drive_v2') => array('car/service/registerTryDriveV2', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'car_customer_idea') => array('car/service/customerIdea', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'car_register_receive_news') => array('car/service/registerReceiveNews', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'car_accessories_genuine') => array('car/service/accessoriesGenuine', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'car_schedule_repair') => array('car/service/scheduleRepair', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'user_liked_shop') => array('profile/profile/likedShop', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'user_liked_product') => array('profile/profile/likedProduct', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'product_search_by_attribute') => array('economy/product/attributeSearch', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'product_advanced_search') => array('economy/product/attributesearchform', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'check_warranty') => array('site/site/checkWarranty', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'warranty') => array('site/site/warranty', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'warranty_history') => array('site/site/warrantyHistory', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'product_orgin_map') => array('economy/product/mapProduct', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'set_language') => array('/site/site/setlanguage', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'feed') => array('/site/site/rss', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'index_job') => array('/profile/profile/indexJob', 'urlSuffix' => '.html', 'caseSensitive' => false),
            Yii::t('url', 'brand-explorer') => array('/economy/product/brandExplorer', 'urlSuffix' => '.html', 'caseSensitive' => false),
            'cua-hang,<id>' => array('economy/shop/storedetail', 'urlSuffix' => '', 'caseSensitive' => false), // quản lý file
            '<alias>-df,<fid>' => array('media/media/file', 'urlSuffix' => '', 'caseSensitive' => false), // quản lý file
            '<alias>-qta,<id>' => array('economy/question/detail', 'urlSuffix' => '', 'caseSensitive' => false), // quản lý file
            '<alias>-dfh,<id>' => array('media/media/detailfile', 'urlSuffix' => '', 'caseSensitive' => false), // quản lý file
            '<alias>-al,<id>' => array('media/album/detail', 'urlSuffix' => '', 'caseSensitive' => false), // album ảnh
            '<alias>-ct,<id>' => array('page/customform/detail', 'urlSuffix' => '', 'caseSensitive' => false), // album ảnh
            '<alias>-ac,<id>' => array('media/album/category', 'urlSuffix' => '', 'caseSensitive' => false), // album ảnh
            '<alias>-vd,<id>' => array('media/video/detail', 'urlSuffix' => '', 'caseSensitive' => false), // Chi tiết video
            '<alias>-vdc,<id>' => array('media/video/category', 'urlSuffix' => '', 'caseSensitive' => false), // Chi tiết video
            '<alias>-pc,<id>' => array('economy/product/category', 'urlSuffix' => '', 'caseSensitive' => false), // danh mục sản phẩm
            'dac-san-<alias>,<id>' => array('economy/product/province', 'urlSuffix' => '', 'caseSensitive' => false), // danh mục sản phẩm
            'ds-vung-mien,<id>' => array('economy/product/groupProvince', 'urlSuffix' => '', 'caseSensitive' => false), // danh mục sản phẩm
            'mua-tra-gop,<id>' => array('installment/installment/index', 'urlSuffix' => '', 'caseSensitive' => false), // danh mục sản phẩm
            'mua-tra-gop-tin-dung,<id>' => array('installment/installment/checkoutPay', 'urlSuffix' => '', 'caseSensitive' => false), // danh mục sản phẩm
            '<alias>-pcn,<id>' => array('economy/product/categoryLevelOne', 'urlSuffix' => '', 'caseSensitive' => false), // danh mục sản phẩm
            '<alias>-tc,<id>' => array('tour/tour/category', 'urlSuffix' => '', 'caseSensitive' => false), // danh mục sản phẩm
            '<alias>-sc,<id>' => array('economy/shop/category', 'urlSuffix' => '', 'caseSensitive' => false), // danh mục sản phẩm
            '<alias>-pcs,<id>' => array('economy/product/categorySearch', 'urlSuffix' => '', 'caseSensitive' => false), // danh mục sản phẩm search
            '<alias>-pd,<id>' => array('economy/product/detail', 'urlSuffix' => '', 'caseSensitive' => false), // chi tiết sản phẩm
            '<alias>-dt,<id>' => array('economy/product/manufacturerDetail', 'urlSuffix' => '.html', 'caseSensitive' => false), // chi tiết sản phẩm
            '<alias>-thd,<id>' => array('tour/tourHotel/detail', 'urlSuffix' => '', 'caseSensitive' => false), // chi tiết sản phẩm
            '<alias>-thdr,<id>' => array('tour/tourHotel/detailRoom', 'urlSuffix' => '', 'caseSensitive' => false), // chi tiết sản phẩm
            '<alias>-td,<id>' => array('tour/tour/detail', 'urlSuffix' => '', 'caseSensitive' => false), // chi tiết sản phẩm
            '<alias>-car,<id>' => array('car/car/detail', 'urlSuffix' => '', 'caseSensitive' => false), // chi tiết sản phẩm
            '<alias>-sd,<id>' => array('economy/shop/detail', 'urlSuffix' => '', 'caseSensitive' => false), // chi tiết sản phẩm
            '<alias>-cd,<id>' => array('economy/course/detail', 'urlSuffix' => '', 'caseSensitive' => false), // chi tiết sản phẩm
            '<alias>-cc,<id>' => array('economy/course/category', 'urlSuffix' => '', 'caseSensitive' => false), // chi tiết sản phẩm
            '<alias>-evd,<id>' => array('economy/event/detail', 'urlSuffix' => '', 'caseSensitive' => false), // chi tiết sản phẩm
            '<alias>-evc,<id>' => array('economy/event/category', 'urlSuffix' => '', 'caseSensitive' => false), // chi tiết sản phẩm
            '<alias>-ccul,<id>' => array('economy/course/categoryunlimit', 'urlSuffix' => '', 'caseSensitive' => false), // chi tiết sản phẩm
            '<alias>-prm,<id>' => array('/economy/product/promotion', 'urlSuffix' => '', 'caseSensitive' => false), // Chi tiết khuyến mãi
            '<alias>-pg,<id>' => array('/economy/product/group', 'urlSuffix' => '', 'caseSensitive' => false), // Chi tiết khuyến mãi
            '<alias>-pde,<id>' => array('page/category/detail', 'urlSuffix' => '', 'caseSensitive' => false), // Chi tiết trang chuyên mục
            '<alias>-nc,<id>' => array('news/news/category', 'urlSuffix' => '', 'caseSensitive' => false), // danh mục tin tức
            '<alias>-nd,<id>' => array('news/news/detail', 'urlSuffix' => '', 'caseSensitive' => false), // Chi tiết tin tức
            'tag/<q>' => array('search/search/searchTag', 'urlSuffix' => '', 'caseSensitive' => false),
            'huong-dan-su-dung-ng,<id>' => array('news/news/groupnewsinproduct', 'urlSuffix' => '', 'caseSensitive' => false), // nhóm hướng dẫn sử dụng
            'tin-lien-quan-ng,<id>' => array('news/news/groupnewsrelation', 'urlSuffix' => '', 'caseSensitive' => false), //Nhóm tin liên quan
            '<alias>-wj,<id>' => array('work/job/detail', 'urlSuffix' => '', 'caseSensitive' => false), // Chi tiết tin tuyển dụng
            '<alias>-poc,<id>' => array('content/post/category', 'urlSuffix' => '', 'caseSensitive' => false), // Danh mục bài viết
            '<alias>-pod,<id>' => array('content/post/detail', 'urlSuffix' => '', 'caseSensitive' => false), // Chi tiết bài viết
            '<alias>-led,<id>' => array('economy/lecturer/detail', 'urlSuffix' => '', 'caseSensitive' => false), // Chi tiết giảng viên
            '<alias>-csl,<id>' => array('economy/consultant/detail', 'urlSuffix' => '', 'caseSensitive' => false),
            '<alias>-pred,<id>' => array('news/realestate/project', 'urlSuffix' => '', 'caseSensitive' => false),
            '<alias>-red,<id>' => array('news/realestate/detail', 'urlSuffix' => '', 'caseSensitive' => false),
            '<alias>-renc,<id>' => array('news/realestateNews/category', 'urlSuffix' => '', 'caseSensitive' => false),
            '<alias>-rend,<id>' => array('news/realestateNews/detail', 'urlSuffix' => '', 'caseSensitive' => false),
            '<alias>-estate,<id>' => array('news/realestateProject/detail', 'urlSuffix' => '', 'caseSensitive' => false),
            '<alias>-rspc,<id>' => array('news/realestateProject/category', 'urlSuffix' => '', 'caseSensitive' => false),
            'nop-don-ung-tuyen,<id>' => array('work/job/jobApply', 'urlSuffix' => '', 'caseSensitive' => false),
            '<alias>-pcd,<id>' => array('bds/bdsProjectConfig/detail', 'urlSuffix' => '', 'caseSensitive' => false),
            '<alias>-i<i>v<v>' => array('work/job/search', 'urlSuffix' => '.html', 'caseSensitive' => false),
            '<alias>-i<i>' => array('work/job/search', 'urlSuffix' => '.html', 'caseSensitive' => false),
            '<alias>-v<v>' => array('work/job/search', 'urlSuffix' => '.html', 'caseSensitive' => false),
            '<k>-kv' => array('work/job/search', 'urlSuffix' => '.html', 'caseSensitive' => false),
            '<alias>-vs-<alias1>,<id>,<id1>' => array('economy/product/compare', 'urlSuffix' => '', 'caseSensitive' => false),
            '<store>' => array('introduce/introduce/index', 'urlSuffix' => '', 'caseSensitive' => false),
            /// -------------------- end backup url -------------------------------------------------------
//            '<alias>-vs-<aslias1>-vs-<alias2>,<id>,<id1>,<id2>' => array('economy/product/compare', 'urlSuffix' => '', 'caseSensitive' => false),
//            '<alias>,<id>' => array('economy/product/compare', 'urlSuffix' => '', 'caseSensitive' => false),
            '<controller:\w+>/<id:\d+>' => '<controller>/view',
            '<controller:\w+>/<i:\d+>' => '<controller>/view',
            '<controller:\w+>/<v:\d+>' => '<controller>/view',
            '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
            '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
        );
        $result = array();
        if (isset(Yii::app()->siteinfo['load_new_url']) && (int) Yii::app()->siteinfo['load_new_url']) {
            $result = array_merge($new_rewrite, $old_rewrite);
        } else {
            $result = $old_rewrite;
        }
        //
        return $result;
    }

    /**
     * return urlManager rules for admin application
     */
    static function getAdminSiteRules() {
        //Tắt rewrite url admin @hungtm
        return array();
        return array(
            Yii::t('url', 'admin_news') => array('content/news', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_news_create') => array('content/news/create', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_news_update') => array('content/news/update', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_news_delete') => array('content/news/delete', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_news_category') => array('content/newscategory', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_news_category_i') => array('content/newscategory/index', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_categorypage') => array('content/categorypage', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_categorypage_create') => array('content/categorypage/create', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_categorypage_update') => array('content/categorypage/update', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_categorypage_delete') => array('content/categorypage/delete', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_product') => array('/economy/product', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_product_category') => array('/economy/productcategory', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_product_create') => array('/economy/product/create', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_product_update') => array('/economy/product/update', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_product_delete') => array('/economy/product/delete', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_productattribute') => array('economy/productAttribute', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_productattribute_create') => array('economy/productAttribute/create', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_productattribute_update') => array('economy/productAttribute/update', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_productattribute_delete') => array('economy/productAttribute/delete', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_productAttributeSet') => array('economy/productAttributeSet', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_productAttributeSet_create') => array('economy/productAttributeSet/create', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_productAttributeSet_update') => array('economy/productAttributeSet/update', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_productAttributeSet_delete') => array('economy/productAttributeSet/delete', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_banner') => array('banner/banner', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_banner_create') => array('banner/banner/create', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_banner_update') => array('banner/banner/update', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_banner_delete') => array('banner/banner/delete', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_bannergroup') => array('banner/bannergroup', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_bannergroup_create') => array('banner/bannergroup/create', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_bannergroup_update') => array('banner/bannergroup/update', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_bannergroup_delete') => array('banner/bannergroup/delete', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_album') => array('media/album', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_album_create') => array('media/album/create', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_album_update') => array('media/album/update', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_album_delete') => array('media/album/delete', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_file') => array('media/file/all', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_file_create') => array('media/file/create', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_file_update') => array('media/file/update', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_file_delete') => array('media/file/delete', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_folder') => array('media/folder', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_folder_create') => array('media/folder/create', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_folder_update') => array('media/folder/update', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_folder_delete') => array('media/folder/delete', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_video') => array('media/video', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_video_create') => array('media/video/create', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_video_update') => array('media/video/update', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_video_delete') => array('media/video/delete', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_video_cate') => array('media/videosCategories', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_video_cate_create') => array('media/videosCategories/create', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_video_cate_update') => array('media/videosCategories/update', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_video_cate_delete') => array('media/videosCategories/delete', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_setting') => array('setting/setting', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_setting_payment') => array('setting/setting/payment', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_setting_introduce') => array('setting/setting/introduce', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_setting_domainsetting') => array('setting/setting/domainsetting', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_setting_deletedomain') => array('setting/setting/deletedomain', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_setting_changedomaindefault') => array('setting/setting/changedomaindefault', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_footersettings') => array('setting/footersettings', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_map') => array('setting/map', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_map_create') => array('setting/map/create', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_map_update') => array('setting/map/update', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_map_delete') => array('setting/map/delete', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_jobs') => array('work/jobs', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_jobs_create') => array('work/jobs/create', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_jobs_update') => array('work/jobs/update', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_jobs_delete') => array('work/jobs/delete', 'urlSuffix' => '', 'caseSensitive' => false),
            Yii::t('url', 'admin_createsitemap') => array('/site/createsitemap', 'urlSuffix' => '', 'caseSensitive' => false),
//            '<controller:\w+>/<id:\d+>' => '<controller>/view',
//            '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
//            '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
        );
    }

    /**
     *
     */
    public static function getDemoDataBaseConfig() {
        return array(
            'connectionString' => 'mysql:host=localhost;dbname=web3nhatdemo',
            'username' => 'root',
            'password' => '',
        );
    }

    /**
     * return current server name
     */
    public static function getServerName() {
        $servername = Yii::app()->request->serverName;
        $servername = str_replace('www.', '', $servername);
        return $servername;
    }

    /**
     * Get domain info
     * @param type $domain
     * @return array
     */
    public static function getDomainInfo($domain = null) {
        if (!$domain)
            $domain = self::getServerName();
//        $domaininfo = Yii::app()->cache->get(self::CACHE_DOMAIN_PRE . $domain);
//        if (!$domaininfo) {
            $domaininfo = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('domain'))
                ->where('domain_id=:domain_id', array(':domain_id' => $domain))
                ->queryRow();
//            if ($domaininfo)
//                Yii::app()->cache->set('domain_' . $domain, $domaininfo);
//        }
        return $domaininfo;
    }

    /**
     * Get site id from domain
     * @param type $domain
     */
    public static function getSiteIdFromDomain($domain = null) {
        $domaininfo = self::getDomainInfo($domain);
        if (!$domaininfo)
            return 0;
        return $domaininfo['site_id'];
    }

    /**
     * get current site id follow current domain
     */
    public static function getCurrentSiteId() {
        return self::getSiteIdFromDomain();
    }

    /**
     * get site info
     * @param type $site_id
     */
    public static function getSiteInfo($site_id = 0) {
        $site_id = (int) $site_id;
        if (!$site_id)
            $site_id = self::getSiteIdFromDomain();
        if ($site_id) {
            //
            $translate_language = self::getLanguageTranslate('', false);
            //
            //Yii::app()->cache->delete(self::CACHE_SITEINFO_PRE . $site_id . $translate_language);
//            $siteinfo = Yii::app()->cache->get(self::CACHE_SITEINFO_PRE . $site_id . $translate_language);
            //
//            if (!$siteinfo) {
                $siteinfoNotranslate = Yii::app()->db->createCommand()->select("*")->from(ClaTable::getTable('site', array('translate' => false)))
                    ->where('site_id=:site_id', array(':site_id' => $site_id))
                    ->queryRow();
                if ($translate_language) {
                    $siteinfo_translate = Yii::app()->db->createCommand()->select("*")->from(ClaTable::getTable('site', array(ClaSite::LANGUAGE_KEY => $translate_language)))
                        ->where('site_id=:site_id', array(':site_id' => $site_id))
                        ->queryRow();
                    if (!$siteinfo_translate)
                        $siteinfo_translate = $siteinfoNotranslate;
                    $siteinfo = $siteinfo_translate;
                } else
                    $siteinfo = $siteinfoNotranslate;
                //
                if ($siteinfo) {
                    $site_page_size = SitePageSize::getPageSizeSite($site_id);
                    $siteinfo['site_page_size'] = $site_page_size;
//                    Yii::app()->cache->set(self::CACHE_SITEINFO_PRE . $site_id . $translate_language, $siteinfo);
                }
//            }
            if ($siteinfo)
                return $siteinfo;
        }
        return array();
    }

    /**
     * ******* Đã cache vào siteinfo *******
     * get page_size
     * @param type $site_id
     */
//    public static function getSitePageSizeInfo($site_id = 0) {
//        $site_id = (int) $site_id;
//        if (!$site_id)
//            $site_id = self::getSiteIdFromDomain();
//        if ($site_id) {
//            $translate_language = '';
//            //
////            Yii::app()->cache->delete(self::CACHE_PAGE_SIZE_PRE . $site_id . $translate_language);
//            $site_page_size = Yii::app()->cache->get(self::CACHE_PAGE_SIZE_PRE . $site_id . $translate_language);
//            //
//            if (!$site_page_size) {
//                $site_page_size = SitePageSize::getPageSizeSite($site_id);
//                if ($site_page_size)
//                    Yii::app()->cache->set(self::CACHE_SITEINFO_PRE . $site_id . $translate_language, $site_page_size);
//            }
//            if ($site_page_size)
//                return $site_page_size;
//        }
//        return array();
//    }

    /**
     * get site info when its don't translate
     * @param type $site_id
     */
    public static function getSiteInfoOrigin($site_id = 0) {
        $site_id = (int) $site_id;
        if (!$site_id)
            $site_id = self::getSiteIdFromDomain();
        if ($site_id) {
            $siteinfo = Yii::app()->cache->get(self::CACHE_SITEINFO_PRE . $site_id);
            if (!$siteinfo) {
                $siteinfo = Yii::app()->db->createCommand()->select("*")->from(ClaTable::getTable('site', array('translate' => false)))
                    ->where('site_id=:site_id', array(':site_id' => $site_id))
                    ->queryRow();
                //
                if ($siteinfo) {
                    Yii::app()->cache->set(self::CACHE_SITEINFO_PRE . $site_id, $siteinfo);
                }
            }
            if ($siteinfo) {
                return $siteinfo;
            }
        }
        return array();
    }

    /**
     *
     * @param type $site_id
     * @return type
     */
    public static function getSiteAdminInfo($site_id = 0) {
        $site_id = (int) $site_id;
        if (!$site_id)
            $site_id = self::getSiteIdFromDomain();
        if ($site_id) {
//            $siteinfo = Yii::app()->cache->get(self::CACHE_SITEADMIN_PRE . $site_id);
//            if (!$siteinfo) {
                $siteinfo = Yii::app()->db->createCommand()->select("*")->from('sites_admin')
                    ->where('site_id=:site_id', array(':site_id' => $site_id))
                    ->queryRow();
                //
//                if ($siteinfo) {
//                    Yii::app()->cache->set(self::CACHE_SITEADMIN_PRE . $site_id, $siteinfo);
//                }
//            }
            if ($siteinfo) {
                return $siteinfo;
            }
        }
        return array();
    }

    /**
     * get All type of site
     * @return array
     */
    static function getSiteTypes() {
        return array(
            self::SITE_TYPE_NEWS => Yii::t('site', 'site_type_news'),
            self::SITE_TYPE_ECONOMY => Yii::t('site', 'site_type_sale'),
            self::SITE_TYPE_INTRODUCE => Yii::t('site', 'site_type_introduce'),
            self::SITE_TYPE_EDU => Yii::t('site', 'site_type_edu'),
            self::SITE_TYPE_B2B => Yii::t('site', 'site_type_b2b'),
            self::SITE_TYPE_FILE => Yii::t('site', 'site_type_file'),
            self::SITE_TYPE_WORK => Yii::t('site', 'site_type_work'),
            self::SITE_TYPE_NAIL => Yii::t('site', 'site_type_nail'),
            self::SITE_TYPE_CAR => Yii::t('site', 'site_type_car'),
        );
    }

    /**
     * get All alias of site type
     * @return array
     */
    static function getSiteTypeAlias() {
        return array(
            self::SITE_TYPE_NEWS => 'news',
            self::SITE_TYPE_ECONOMY => 'economy',
            self::SITE_TYPE_INTRODUCE => 'introduce',
            self::SITE_TYPE_NAIL => 'introduce',
        );
    }

    /**
     * get site type name
     */
    static function getSiteTypeName($siteinfo = null) {
        if (!$siteinfo) {
            $siteinfo = self::getSiteInfo();
        }
        $sitetypealias = self::getSiteTypeAlias();
        return $sitetypealias[$siteinfo['site_type']];
    }

    /**
     * Get home key
     */
    static function getHomeKey($siteinfo = null) {
        if (!$siteinfo) {
            $siteinfo = self::getSiteInfo();
        }
        $key = '';
        switch ($siteinfo['site_type']) {
            case ClaSite::SITE_TYPE_NEWS: {
                $key = 'news/news/home';
            }break;
            case ClaSite::SITE_TYPE_ECONOMY: {
                $key = 'economy/product/home';
            }break;
            case ClaSite::SITE_TYPE_INTRODUCE: {
                $key = 'introduce/introduce/';
            }break;
            case ClaSite::SITE_TYPE_NAIL: {
                $key = 'service/service/';
            }break;
        }
        return $key;
    }

    /**
     * get default controller
     * @param type $siteinfo
     * @return type
     */
    static function getDefaultController($siteinfo = null) {
        return self::getHomeKey($siteinfo);
    }

    /**
     * get link key
     */
    static function getLinkKey($options = array()) {
        $module = isset(Yii::app()->controller->module->id) ? Yii::app()->controller->module->id . '/' : '';
        $controller = isset(Yii::app()->controller->id) ? Yii::app()->controller->id . '/' : '';
        $action = (isset(Yii::app()->controller->action->id) && Yii::app()->controller->action->id != 'index') ? Yii::app()->controller->action->id : '';
        $key = $module . $controller . $action;
        // Nếu là trang chuyên mục thì phân biệt thành các trang khác nhau
        if ($module == 'page/' && $controller == 'category/') {
            array_push($options, Yii::app()->request->getParam('id'));
        }
        if ($module == 'economy/' && $controller == 'product/' && $action == 'group') {
            array_push($options, Yii::app()->request->getParam('id'));
        }
        //
        foreach ($options as $val) {
            $key.='_' . $val;
        }
        return $key;
    }

    /**
     * Get full curent url
     * @return type
     */
    static function getFullCurrentUrl() {
        return Yii::app()->request->hostInfo . Yii::app()->request->url;
    }

    /**
     * Get curent url
     * @return type
     */
    static function getCurrentUrl() {
        return Yii::app()->request->url;
    }

    /**
     * return id of web3nhat
     * @return type
     */
    static function getRootSiteId() {
        return self::ROOT_SITE_ID;
    }

    /**
     *
     * @param type $isFull
     * @return type
     */
    static function getHttpMethod($isFull = true) {
        if (Yii::app()->request->getIsSecureConnection())
            $http = 'https';
        else
            $http = 'http';
        $httpString = '';
        if ($isFull)
            $httpString = $http . '://';
        else
            $httpString = $http;
        return $httpString;
    }

    static function getAdminEntry() {
        return 'quantri';
    }

//
    static function checkAdminSessionExist() {
        $cookie = Yii::app()->request->cookies[self::ADMIN_SESSION];
        return (isset($cookie) && $cookie) ? true : false;
    }

// create admin session
    static function generateAdminSession($options = array()) {
        if (!Yii::app()->user->isGuest) {
            $cookie = new CHttpCookie(self::ADMIN_SESSION, json_encode(array(
                'user_id' => Yii::app()->user->id,
                'name' => Yii::app()->user->name,
                'website' => Yii::app()->homeUrl,
            )));
            $cookie->expire = (isset($options['rememberMe']) && $options['rememberMe']) ? (time() + (30 * 24 * 60 * 60)) : (time() + (24 * 60 * 60));
            self::setAdminSession($cookie);
        }
    }

// return admin session
    static function getAdminSession() {
        $cookie = Yii::app()->request->cookies[self::ADMIN_SESSION];
        if ($cookie)
            return json_decode($cookie, true);
        return false;
    }

// set admin session
    static function setAdminSession($cookie = null) {
        if ($cookie) {
            Yii::app()->request->cookies[self::ADMIN_SESSION] = $cookie;
        }
    }

// delete admin session
    static function deleteAdminSession() {
        unset(Yii::app()->request->cookies[self::ADMIN_SESSION]);
        setcookie(self::ADMIN_SESSION, null, -1);
    }

    /**
     * get site map data from menu
     * @return string
     */
    static function getSiteMapDataFromMenu($siteinfo = array()) {
        $menus = Menus::getAllMenuInSite();
        $defaultDomain = isset($siteinfo['domain_default']) ? $siteinfo['domain_default'] : '';
        $hostInfo = ($defaultDomain) ? self::getHttpMethod() . $defaultDomain : Yii::app()->request->hostInfo;
        $temp = array();
        $str = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $str .= '<?xml-stylesheet type="text/xsl" href="/sitemap/style.xsl"?>' . "\n";
        $str.='<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:mobile="http://www.google.com/schemas/sitemap-mobile/1.0">' . "\n";
        // trang chủ
        $lastmod = date('Y-m-d');
        $str.='<url>'
            . '<loc>'
            . $hostInfo
            . '</loc>'
            . '<lastmod>' . $lastmod . '</lastmod>'
            . '<changefreq>daily</changefreq>'
            . '<priority>1.0</priority>'
            . '</url>' . "\n";
        $temp[$hostInfo] = true;
        //
        foreach ($menus as $menu) {
            $url = '';
            if (($menu['menu_basepath'] || $menu['menu_pathparams']) && $menu['menu_linkto'] == Menus::LINKTO_INNER) {
                //$url = Yii::app()->createAbsoluteUrl($menu['menu_basepath'], json_decode($menu['menu_pathparams'], true));
                $claApi = new ClaAPI(array(
                    'domain' => $defaultDomain
                ));
                $respon = $claApi->createUrl(array('basepath' => $menu['menu_basepath'], 'params' => $menu['menu_pathparams'], 'absolute' => true));
                $claApi->closeRequest();
                if ($respon && isset($respon['url'])) {
                    $url = $respon['url'];
                }
            } else {
                if ($menu['menu_link'] && strpos($menu['menu_link'], $defaultDomain) !== false)
                    $url = $menu['menu_link'];
            }
            //
            if (!$url)
                continue;
            if (isset($temp[$url]))
                continue;
            //
            $str.='<url>'
                . '<loc>' . $url . '</loc>'
                . '<lastmod>' . $lastmod . '</lastmod>'
                . '<changefreq>weekly</changefreq>'
                . '<priority>1.0</priority>'
                . '</url>' . "\n";

            $temp[$url] = true;
        }
        $str.='</urlset>' . "\n";
        unset($temp);
        //
        return $str;
    }

// create site map from MENU
    static function createSiteMapFromMenu() {
        // Lấy lại site info ko dùng Yii::app()->siteinfo['domain_default']
        $siteInfo = self::getSiteInfo();
        //
        $data = self::getSiteMapDataFromMenu($siteInfo);
        //
        $file = Yii::getPathOfAlias('common') . '/../' . 'sitemap' . '/' . $siteInfo['domain_default'] . '_sitemap.xml';
        if (file_put_contents($file, $data)) {
            @chmod($file, 0777);
            return true;
        }
        return false;
    }

// create robot.txt file
    static function createSiteRobot($siteInfo = null) {
        // Lấy lại site info ko dùng Yii::app()->siteinfo['domain_default']
        if (!$siteInfo)
            $siteInfo = self::getSiteInfo();
        //
        $data = '# Robots.txt' . "\n";
        $data.='User-agent: *' . "\n";
        $data.='Disallow: /images/' . "\n";
        //$data.='Disallow: /css/' . "\n";
        //$data.='Disallow: /js/' . "\n";
        $data.='Disallow: /dang-nhap' . "\n";
        $data.='Disallow: /dang-ky' . "\n";
        $data.='Disallow: /gio-hang' . "\n";
        $data.='Disallow: /sso/' . "\n";
//        $data.='Disallow: /gioi-thieu' . "\n";
//        $data.='Disallow: /tuyen-dung' . "\n";
//        $data.='Disallow: /album' . "\n";
//        $data.='Disallow: /video' . "\n";
        $data.='Sitemap: ' . self::getHttpMethod() . $siteInfo['domain_default'] . '/sitemap.xml' . "\n";
        //
        $file = Yii::getPathOfAlias('common') . '/../' . 'robots' . '/' . $siteInfo['domain_default'] . '_robots.txt';
        if (file_put_contents($file, $data)) {
            @chmod($file, 0777);
            return true;
        }
        return false;
    }

    /**
     * Return language which need
     */
    static function getLanguageTranslate($language = '', $setSess = true) {
        // Nếu có language session thì lấy language session
        $appId = Yii::app()->getId();
        if ($appId == 'public') {
            $language = ClaSite::getPublicLanguage($setSess);
        } else {
            $language = ClaSite::getBackLanguage();
        }
        //
        $languageSupport = self::getLanguageSupport();
        if (isset($languageSupport[$language]))
            return $language;
        return '';
    }

    /**
     * return language was support
     */
    static function getLanguageSupport() {
        return Yii::app()->params['languages'];
    }

    /**
     * Check site is multi language
     * @return boolean
     */
    static function isMultiLanguage() {
        if (isset(Yii::app()->siteinfo['languages_for_site']) && Yii::app()->siteinfo['languages_for_site'] != '') {
            return true;
        }
        return false;
    }

    /**
     * check show translate button
     * @return boolean
     */
    static function showTranslateButton() {
        if (self::isMultiLanguage()) {
            $appId = Yii::app()->getId();

            if ($appId == 'public') {
                $language = ClaSite::getPublicLanguage();
            } else {
                $language = ClaSite::getBackLanguage();
            }
            if ($language && $language != ClaSite::getDefaultLanguage()) {
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * return languages for site
     */
    static function getLanguagesForSite() {
        if (!Yii::app()->siteinfo) {
            $siteinfo = self::getSiteInfoOrigin();
        } else {
            $siteinfo = Yii::app()->siteinfo;
        }
        $languages = array();
        $_languages = (isset($siteinfo['languages_for_site']) && $siteinfo['languages_for_site'] != '') ? $siteinfo['languages_for_site'] : '';
        $languages_for_sites = explode(' ', $_languages);
        if ($languages_for_sites && is_array($languages_for_sites)) {
            foreach ($languages_for_sites as $lfs) {
                $languages[$lfs] = $lfs;
            }
        }
        return $languages;
    }

    /**
     * return language được map tương ứng với các vị trí của table
     */
    static function getLanguagesMap() {
        $siteinfo = self::getSiteAdminInfo();
        $languages = array();
        $_languages = (isset($siteinfo['languages_map']) && $siteinfo['languages_map'] != '') ? $siteinfo['languages_map'] : '';
        $languages_for_sites = explode(' ', $_languages);
        if ($languages_for_sites && is_array($languages_for_sites)) {
            foreach ($languages_for_sites as $key => $lfs) {
                $languages[$key] = $lfs;
            }
        }
        return $languages;
    }

    /**
     *
     * @param type $language
     */
    static function setPublicLanguageSession($language = '') {
        $languages = self::getLanguageSupport();
        if ($language && isset($languages[$language])) {
            Yii::app()->session[self::PUBLIC_LANGUAGE_SESSION] = $language;
            return true;
        }
        return false;
    }

    /**
     *
     * @param type $language
     */
    static function getPublicLanguageSession() {
        $language = false;
        if (isset(Yii::app()->session[self::PUBLIC_LANGUAGE_SESSION])) {
            $language = Yii::app()->session[self::PUBLIC_LANGUAGE_SESSION];
        }
        return $language;
    }

    /**
     * return language of font-end
     *
     * @return string
     */
    static function getPublicLanguage($setSess = true) {
        $language = Yii::app()->request->getParam(ClaSite::LANGUAGE_KEY);
        if (!$language) {
            $isMultiLanguage = ClaSite::isMultiLanguage();
            $requestUri = Yii::app()->request->getRequestUri();
            // Language follow domain
            $domain = ClaSite::getDomainInfo();
            if ($domain && isset($domain['language']) && $domain['language']) {
                $language = $domain['language'];
            }
            if (!$language) {
                $language = self::getPublicLanguageSession();
            }
            if (!$requestUri || $requestUri == '/') {
                // Detect language from IP
//                if ($language === false && $isMultiLanguage) {
//                    $languages = self::getLanguagesForSite();
//                    $_language = ClaLocation::getCountryCodeFromCIP();
//                    if (isset($languages[$_language])) {
//                        $language = $_language;
//                    } elseif ($_language != Yii::app()->siteinfo['language']) {
//                        $language = 'en';
//                    }
//                }
                if ($language === false && !$isMultiLanguage) {
                    $language = self::LANGUAGE_DEFAULT;
                } else if ($language === false && $isMultiLanguage) {
                    $language = Yii::app()->siteinfo['language'];
                }
            } elseif (!$language) {
                if (!Yii::app()->errorHandler->error) {
                    $language = self::LANGUAGE_DEFAULT;
                    $setSess = true;
                } else {
                    $setSess = false;
                }
            }
            if (Yii::app()->request->isAjaxRequest) {
                $setSess = false;
            }
            if ($setSess && $language && $isMultiLanguage) {
                self::setPublicLanguageSession($language);
            }
        } else {
            $languageForSite = self::getLanguagesForSite();
            if (!in_array($language, $languageForSite)) {
                $language = self::LANGUAGE_DEFAULT;
            } elseif (ClaSite::isMultiLanguage()) {
                if ($setSess) {
                    self::setPublicLanguageSession($language);
                }
            }
        }
        if ($language == '' || !$language) {
            $language = self::LANGUAGE_DEFAULT;
        }
        return $language;
    }

    /**
     *
     * @param type $language
     */
    static function setBackLanguageSession($language = '') {
        $languages = self::getLanguageSupport();
        if ($language && isset($languages[$language])) {
            Yii::app()->session[self::BACK_LANGUAGE_SESSION] = $language;
            return true;
        }
        return false;
    }

    /**
     *
     * @param type $language
     */
    static function getBackLanguageSession() {
        $language = false;
        if (isset(Yii::app()->session[self::BACK_LANGUAGE_SESSION])) {
            $language = Yii::app()->session[self::BACK_LANGUAGE_SESSION];
        }
        return $language;
    }

    /**
     * return language of font-endF
     */
    static function getBackLanguage() {
        $language = Yii::app()->request->getParam(ClaSite::LANGUAGE_KEY);
        if (!$language) {
            $language = self::getBackLanguageSession();
            if ($language === false && !ClaSite::isMultiLanguage()) {
                $language = self::LANGUAGE_DEFAULT;
            } else if ($language === false && ClaSite::isMultiLanguage()) {
                $language = Yii::app()->siteinfo['admin_language'];
                self::setBackLanguageSession($language);
            }
        } else {
            $language_encryption = Yii::app()->request->getParam(ClaSite::LANGUAGE_ENCRYPTION);
            if ($language_encryption != self::getLanguagePublicKey($language)) {
                $language = self::LANGUAGE_DEFAULT;
            }
            self::setBackLanguageSession($language);
        }
        if ($language == '') {
            $language = self::LANGUAGE_DEFAULT;
        }
        return $language;
    }

    /**
     * trả về một public key cho dùng
     * @param type $language
     */
    static function getLanguagePublicKey($language = '') {
        $key = self::getServerName();
        if ($language) {
            $key = md5($key . sha1($language . $key));
        }
        return $key;
    }

    public static function checkAccess() {
        $serverip = $_SERVER['SERVER_ADDR'];
        if (!in_array($serverip, Yii::app()->params['server_ip'])) {
            if (Yii::app()->siteinfo['site_id'] == self::ROOT_SITE_ID) {
                $subject = 'Access From Other IP Nano';
                $content = 'Current IP: ' . $serverip . ' , name: ' . ClaSite::getServerName();
                if ($content && $subject) {
                    Yii::app()->mailer->send('', 'minhcoltech@gmail.com', $subject, $content);
                    Yii::app()->mailer->send('', 'buithanhdung@gmail.com', $subject, $content);
                }
            }
        }
    }

    /**
     * Kiểm tra xem đã hết hạn hay chưa
     */
    static function isExpiryDate() {
        if (ClaUser::isSupperAdmin())
            return false;
        $siteAdmin = self::getSiteAdminInfo();
        if ($siteAdmin['expiration_date'] && ((int) $siteAdmin['expiration_date'] < time())) {
            return true;
        }
        return false;
    }

    /**
     * check current url is homeUrl
     * @return type
     */
    static function isHomeUrl() {
        return (ClaSite::getLinkKey() == ClaSite::getHomeKey(Yii::app()->siteinfo));
    }

    static function redirect301ToUrl($url = '') {
        if ($url) {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: " . $url);
            Yii::app()->end();
        }
    }

    /**
     *
     */
    static function getAdminDefaultOptions() {
        return array(
            self::SITE_TYPE_NEWS_NAME => self::SITE_TYPE_NEWS_NAME,
            self::SITE_TYPE_ECONOMY_NAME => self::SITE_TYPE_ECONOMY_NAME,
            self::SITE_TYPE_WORK_NAME => self::SITE_TYPE_WORK_NAME,
        );
    }

    /**
     * get all domain for site
     * @param type $site_id
     * @return type
     */
    static function getDomainsFromSiteid($site_id = 0) {
        $result = array();
        $site_id = (int) $site_id;
        if ($site_id) {
            $condition = 'site_id=' . $site_id;
            $params = array();
            $domains = Yii::app()->db->createCommand()
                ->select()
                ->from(ClaTable::getTable('domains'))
                ->where($condition, $params)
                ->queryAll();
            if ($domains) {
                foreach ($domains as $domain) {
                    $result[$domain['domain_id']] = $domain;
                }
            }
        }
        return $result;
    }

    /**
     * cache website page
     * @return boolean
     */
    static function isCachePage() {
        if (isset(Yii::app()->params['cachePage']) && Yii::app()->params['cachePage']) {
            return true;
        }
        return false;
    }

    /**
     * get admin mails
     *
     */
    static function getAdminMails() {
        $adminString = isset(Yii::app()->siteinfo['admin_email']) ? Yii::app()->siteinfo['admin_email'] : '';
        $admins = array();
        if ($adminString) {
            $admins_temp = explode(',', $adminString);
            if ($admins_temp) {
                foreach ($admins_temp as $admin) {
                    $admins[] = trim($admin);
                }
            }
        }
        return $admins;
    }

    static function isBot($USER_AGENT = '') {
        if (!$USER_AGENT) {
            $USER_AGENT = $_SERVER["HTTP_USER_AGENT"];
        }
        $crawlers = array(
            array('bingbot', 'Bing'),
            array('msnbot', 'MSN'),
            array('Rambler', 'Rambler'),
            array('Yahoo', 'Yahoo'),
            array('AbachoBOT', 'AbachoBOT'),
            array('accoona', 'Accoona'),
            array('AcoiRobot', 'AcoiRobot'),
            array('ASPSeek', 'ASPSeek'),
            array('CrocCrawler', 'CrocCrawler'),
            array('Dumbot', 'Dumbot'),
            array('FAST-WebCrawler', 'FAST-WebCrawler'),
            array('GeonaBot', 'GeonaBot'),
            array('Gigabot', 'Gigabot'),
            array('Lycos', 'Lycos spider'),
            array('MSRBOT', 'MSRBOT'),
            array('Scooter', 'Altavista robot'),
            array('AltaVista', 'Altavista robot'),
            array('IDBot', 'ID-Search Bot'),
            array('eStyle', 'eStyle Bot'),
            array('Scrubby', 'Scrubby robot')
        );

        foreach ($crawlers as $c) {
            if (stristr($USER_AGENT, $c[0])) {
                return($c[1]);
            }
        }

        return false;
    }

    static function isGoogleBot($USER_AGENT = '') {
        if (!$USER_AGENT) {
            $USER_AGENT = $_SERVER["HTTP_USER_AGENT"];
        }
        $crawlers = array(
            array('googlebot', 'Google'),
        );

        foreach ($crawlers as $c) {
            if (stristr($USER_AGENT, $c[0])) {
                return($c[1]);
            }
        }

        return false;
    }

    /**
     * Kiểm tra xem site có enable SSO không
     */
    static function isSSO() {
        if (!Yii::app()->isDemo) {
            return ENABLE_SSO;
        } else {
            return false;
        }
    }

    static function checkShowHeader() {
        if (Yii::app()->siteinfo['header_showall']) {
            return true;
        } else {
            $_rules = Yii::app()->siteinfo['header_rules'];
            $rules = explode(',', $_rules);
            $pagekey = ClaSite::getLinkKey();
            $homepagekey = ClaSite::getHomeKey();
            if ($pagekey == $homepagekey) {
                $pagekey = 'home';
            }
            //
            $check = false;
            switch ($pagekey) {
                case 'economy/product/category': {
                    $cat_id = Yii::app()->request->getParam('id', 0);
                    $subPageKey = 'ppage_' . $cat_id;
                    if (in_array($pagekey, $rules) || in_array($subPageKey, $rules)) {
                        $check = true;
                    }
                } break;
                case 'news/news/category': {
                    $cat_id = Yii::app()->request->getParam('id', 0);
                    $subPageKey = 'newscat_' . $cat_id;
                    if (in_array($pagekey, $rules) || in_array($subPageKey, $rules)) {
                        $check = true;
                    }
                } break;
                default : {
                    if (in_array($pagekey, $rules)) {
                        $check = true;
                    }
                } break;
            }
            return $check;
        }
    }

    static function checkShowFooter() {
        if (Yii::app()->siteinfo['footer_showall']) {
            return true;
        } else {
            $_rules = Yii::app()->siteinfo['footer_rules'];
            $rules = explode(',', $_rules);
            $pagekey = ClaSite::getLinkKey();
            $homepagekey = ClaSite::getHomeKey();
            if ($pagekey == $homepagekey) {
                $pagekey = 'home';
            }
            //
            $check = false;
            switch ($pagekey) {
                case 'economy/product/category': {
                    $cat_id = Yii::app()->request->getParam('id', 0);
                    $subPageKey = 'ppage_' . $cat_id;
                    if (in_array($pagekey, $rules) || in_array($subPageKey, $rules)) {
                        $check = true;
                    }
                } break;
                case 'news/news/category': {
                    $cat_id = Yii::app()->request->getParam('id', 0);
                    $subPageKey = 'newscat_' . $cat_id;
                    if (in_array($pagekey, $rules) || in_array($subPageKey, $rules)) {
                        $check = true;
                    }
                } break;
                default : {
                    if (in_array($pagekey, $rules)) {
                        $check = true;
                    }
                } break;
            }
            return $check;
        }
    }

    /**
     *
     */
    static function checkDisable() {
        if (Yii::app()->siteinfo['status'] == ClaSite::SITE_STATUS_DISABLE || self::isExpiryDate()) {
            echo '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="vi">
    <head>
        <meta charset="utf-8" />
        <title>NanoWeb</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <!-- javaScript -->
        <base href="' . Yii::app()->getBaseUrl(true) . '/' . '"/>
    </head>
    <body>
        <div id="main" class="all-page">
        <p style="font-size: 20px; font-weight: bold; color: #333; padding: 20px; text-align: center;">
            ' . Yii::t('site', 'lock_site', array('{web3nhat}' => '<a target="_blank" rel="nofollow" href="https://nanoweb.vn">NanoWeb</a>')) . '
        </p>
        </div>
    </body>
</html>';
            die;
        }
    }

    /**
     * tra về ngôn ngữ mặc định cho website
     */
    static function getDefaultLanguage() {
        $languageMaps = self::getLanguagesMap();
        if ($languageMaps && is_array($languageMaps)) {
            $lang = ClaArray::getFirst($languageMaps);
            if ($lang) {
                return $lang;
            }
        }
        return self::LANGUAGE_DEFAULT;
    }

}
