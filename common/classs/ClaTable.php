<?php

/**
 * @author minhbn <minhcoltech@gmail.com>
 * @date 09-03-2015
 * 
 * Class for manager table of site
 *
 */
class ClaTable {

    /**
     * get table with name, if name in /config/params/tables retunn tables[name];
     * return string
     */
    static function getTable($name = '', $options = array()) {
        if (!$name)
            return '';
        $tables = Yii::app()->params['tables'];
        $table = $name;
        // Nếu tên đã được định nghĩa trong /params/tables thì lấy trong đó
        if (isset($tables[$name]))
            $table = $tables[$name];
        $TranslateTables = self::getTranslateTables();
        $language = (isset($options['language']) && isset($TranslateTables[$table])) ? $options['language'] : '';
        if ((!isset($options['translate']) || $options['translate']) && !$language) {
            if (isset($TranslateTables[$table])) {
                //$NoTranslateTables = self::getNoTranslateTables();
                // Nếu có language session thì lấy language session
                $appId = Yii::app()->getId();
                if ($appId == 'public')
                    $language = ClaSite::getPublicLanguage();
                else {
                    $language = ClaSite::getBackLanguage();
                }
            }
        }
        //
        $pre = self::getPrefixFromLang($language);
        //
        return $pre . $table;
    }

    /**
     * 
     * @param type $language
     * lấy tiền tó đứng trước table
     */
    static function getPrefixFromLang($language = '') {
        $pre = '';
        if ($language === '') {
            return $pre;
        }
        if ($language && $language != ClaSite::getDefaultLanguage()) {
            $pre = $language . '_';
        }
        $languagesMap = ClaSite::getLanguagesMap();
        if ($languagesMap && is_array($languagesMap)) {
            foreach ($languagesMap as $position => $lang) {
                if($language===$lang){
                    $pre = self::getLangPrefixFromPos($position);
                    break;
                }
            }
        }
        return $pre;
    }

    static function getLangPrefixFromPos($position = 0) {
        $pre = '';
        $position = (int)$position + 1;
        if ($position > 0) {
            switch ($position) {
                case 1: $pre = '';
                    break;
                case 2: $pre = 'en_';
                    break;
                default : $pre = 'lang' . $position . '_';
                    break;
            }
        }
        return $pre;
    }

    /**
     * những table không dịch
     * @return array
     */
    static function getNoTranslateTables() {
        return array(
            'user' => 'user',
            'users_admin' => 'users_admin',
            'domains' => 'domains',
            'sites' => 'sites',
            'site_types' => 'site_types',
            'themes' => 'themes',
            'theme_images' => 'theme_images',
            'theme_categories' => 'theme_categories',
            'cache' => 'cache',
            'district' => 'district',
            'ward' => 'ward',
            'province' => 'province',
            'menus_admin' => 'menus_admin',
            'product_relation' => 'product_relation',
            'product_news_relation' => 'product_news_relation',
            'site_page_size' => 'site_page_size'
        );
    }

    /**
     * Những table dc translate
     */
    static function getTranslateTables() {
        return array(
            'news' => 'news',
            'news_categories' => 'news_categories',
            'posts' => 'posts',
            'post_categories' => 'post_categories',
            'categorypage' => 'categorypage',
            'menus' => 'menus',
            //'menu_groups' => 'menu_groups',
            'product_attribute_set' => 'product_attribute_set',
            'product_attribute' => 'product_attribute',
            'product_attribute_option' => 'product_attribute_option',
            'product_attribute_option_children' => 'product_attribute_option_children',
            'product_attribute_option_index' => 'product_attribute_option_index',
            'product' => 'product',
            'product_info' => 'product_info',
            'product_categories' => 'product_categories',
            'sites' => 'sites',
            'site_introduces' => 'site_introduces',
            //'banner_groups' => 'banner_groups',
            'banners' => 'banners',
            'forms' => 'forms', //không dịch phần form (by dungbt)
            'form_sessions' => 'form_sessions',
            'form_fields' => 'form_fields',
            'form_field_values' => 'form_field_values',
            'maps' => 'maps',
            'jobs' => 'jobs',
            'page_widgets' => 'page_widgets',
            'page_widget_config' => 'page_widget_config',
            'site_support' => 'site_support',
            'albums' => 'albums',
            'albums_categories' => 'albums_categories',
            'images' => 'images',
            'videos' => 'videos',
            'videos_categories' => 'videos_categories',
            'edu_course' => 'edu_course',
            'customer_reviews' => 'customer_reviews',
//            'edu_course_register' => 'edu_course_register',
            'edu_course_categories' => 'edu_course_categories',
            'edu_lecturer' => 'edu_lecturer',
            'banner_partial' => 'banner_partial',
            'site_users' => 'site_users',
            'contact_form' => 'contact_form',
            'product_configurable_images' => 'product_configurable_images',
            'real_estate' => 'real_estate',
            'real_estate_project' => 'real_estate_project',
            'real_estate_categories' => 'real_estate_categories',
            'real_estate_news' => 'real_estate_news',
            'sms_customer' => 'sms_customer',
            'sms_customer_group' => 'sms_customer_group',
            'sms' => 'sms',
            'order_tranports' => 'order_tranports',
            'sms_detail' => 'sms_detail',
            'sms_provider' => 'sms_provider',
            'shop' => 'shop',
            'shop_product_category' => 'shop_product_category',
            'product_rating' => 'product_rating',
//            'shop_images' => 'shop_images',
            'shop_store' => 'shop_store',
            'car_categories' => 'car_categories',
            'car' => 'car',
            'car_info' => 'car_info',
//            'car_images' => 'car_images',
            'car_attribute' => 'car_attribute',
            'likes' => 'likes',
            'car_panorama_options' => 'car_panorama_options',
            'car_receipt_fee' => 'car_receipt_fee',
            'car_versions' => 'car_versions',
            'tour_hotel' => 'tour_hotel',
            'tour_hotel_info' => 'tour_hotel_info',
            'tour_hotel_room' => 'tour_hotel_room',
            'tour_province_info' => 'tour_province_info',
            'tour_info' => 'tour_info',
            'tour_partners' => 'tour_partners',
            'tour_categories' => 'tour_categories',
            'tour' => 'tour',
//            'tour_booking' => 'tour_booking',
//            'tour_booking_room' => 'tour_booking_room',
//            'tour_booking_tour' => 'tour_booking_tour',
            'tour_comforts' => 'tour_comforts',
            'comment_answer' => 'comment_answer',
            'comment' => 'comment',
            'shop_store_images' => 'shop_store_images',
            'question_answer' => 'question_answer',
//            'coupon_campaign' => 'coupon_campaign',
//            'coupon_code' => 'coupon_code',
            'real_estate_consultant' => 'real_estate_consultant',
            'eve_events' => 'eve_events',
            'eve_event_info' => 'eve_event_info',
            'brand' => 'brand',
            'files' => 'files',
            'airline_ticket_categories' => 'airline_ticket_categories',
            'airline_ticket' => 'airline_ticket',
            'airline_location' => 'airline_location',
            'airline_provider' => 'airline_provider',
            'bds_project_config' => 'bds_project_config',
            'bds_project_config_consultant_relation' => 'bds_project_config_consultant_relation',
            'se_providers' => 'se_providers',
            'se_provider_schedules' => 'se_provider_schedules',
            'expertrans_service' => 'expertrans_service',
            'folders' => 'folders'
        );
    }

}
