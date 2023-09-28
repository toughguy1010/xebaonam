<?php

/**
 * Manage theme and config of it
 *
 * @author minhbn
 */
class ClaTheme {

    /**
     * Get loại module
     * @param type $theme_name
     * @return array
     */
    static function getWidgetTypes($theme_name = null) {
        if (!$theme_name)
            $theme_name = Yii::app()->theme->name;
        $moduletypes = array(
            'w3n0010' => array(
                'html' => Yii::t('widget', 'html'),
                'menu' => Yii::t('widget', 'menu'),
                'menu_vertical' => Yii::t('widget', 'menu_vertical'),
                'menufooter' => Yii::t('widget', 'menufooter'),
                'banner' => Yii::t('widget', 'banner'),
                'popup' => Yii::t('widget', 'popup'),
                'bannergroup' => Yii::t('widget', 'bannergroup'),
                'categorybox' => Yii::t('widget', 'category'),
                'categoryinhome' => Yii::t('widget', 'categoryinhome'),
                'destinationinhome' => Yii::t('widget', 'destinationinhome'),
                'homenewscategorydetail' => Yii::t('widget', 'homenewscategorydetail'),
                'homenewscategory_child_detail' => Yii::t('widget', 'homenewscategory_child_detail'),
                'hotnews' => Yii::t('widget', 'hotnews'),
                'mostreadnews' => Yii::t('widget', 'mostreadnews'),
                'newnews' => Yii::t('widget', 'newnews'),
                'newsall' => Yii::t('widget', 'newsall'),
                'newsrelation' => Yii::t('widget', 'newsrelation'),
                'tourrelation' => Yii::t('widget', 'tourrelation'),
                'newsrelationNextAndPrevious' => Yii::t('widget', 'newsrelationNextAndPrevious'),
                'hotproduct' => Yii::t('widget', 'hotproduct'),
                'hotwifi' => Yii::t('widget', 'hotwifi'),
                'hotproductWithShortDesc' => Yii::t('widget', 'hotproductWithShortDesc'),
                'productall' => Yii::t('widget', 'productall'),
                'manufacturerall' => Yii::t('widget', 'manufacturerall'),
                'productMembersOnly' => Yii::t('widget', 'productMembersOnly'),
                'choiceTheme' => Yii::t('widget', 'choiceTheme'),
                'productIncategory' => Yii::t('widget', 'productIncategory'),
                'productsrelation' => Yii::t('widget', 'productsrelation'),
                'newproducts' => Yii::t('widget', 'newproduct'),
                'popupregisterproduct' => Yii::t('widget', 'popupregisterproduct'),
                'productgroup' => Yii::t('widget', 'productgroup'),
                'productviewed' => Yii::t('widget', 'productviewed'),
                'productCompare' => Yii::t('widget', 'productCompare'),
                'productgroupinhome' => Yii::t('widget', 'productgroupinhome'),
                'productpromotioninhome' => Yii::t('widget', 'productpromotioninhome'),
                'promotionall' => Yii::t('widget', 'promotionall'),
                'promotionHotAndNormal' => Yii::t('widget', 'promotionHotAndNormal'),
                'productsetnew' => Yii::t('widget', 'productsetnew'),
                'productMostView' => Yii::t('widget', 'productMostView'),
                'productNewAndGroup' => Yii::t('widget', 'productNewAndGroup'),
                'productCategoryWithBackground' => Yii::t('widget', 'productCategoryWithBackground'),
                'categoryProductSelectFull' => Yii::t('widget', 'categoryProductSelectFull'),
                'categoryPageSub' => Yii::t('widget', 'categoryPageSub'),
                'categoryPageSubFull' => Yii::t('widget', 'categoryPageSubFull'),
                'productcategoryinhome' => Yii::t('widget', 'productcategoryinhome'),
                'videoscategoryinhome' => Yii::t('widget', 'videoscategoryinhome'),
                'productFilterInCat' => Yii::t('widget', 'productFilterInCat'),
                'useraccess' => Yii::t('widget', 'useraccess'),
                'yahoobox' => Yii::t('widget', 'yahoobox'),
                'customform' => Yii::t('widget', 'customform'),
                'onebanner' => Yii::t('widget', 'onebanner'),
                'social' => Yii::t('widget', 'social'),
                'map' => Yii::t('widget', 'map'),
                'searchbox' => Yii::t('widget', 'searchbox'),
                'searchboxcat' => Yii::t('widget', 'searchboxcat'),
                'introducebox' => Yii::t('widget', 'introducebox'),
                'newsletter' => Yii::t('widget', 'newsletter'),
                'logobox' => Yii::t('widget', 'logobox'),
                'shoppingcart' => Yii::t('widget', 'shoppingcart'),
                'ExpertransContactForm' => Yii::t('widget', 'ExpertransContactForm'),
                'videohot' => Yii::t('widget', 'videohot'),
                'pagesize' => Yii::t('widget', 'pagesize'),
                'scrollup' => Yii::t('widget', 'scrollup'),
                'support' => Yii::t('widget', 'support'),
                'productNewAndHot' => Yii::t('widget', 'productNewAndHot'),
                'albumsrelation' => Yii::t('widget', 'albumsrelation'),
                'videosrelation' => Yii::t('widget', 'videosrelation'),
                'albumsIncategory' => Yii::t('widget', 'albumsIncategory'),
                'courseNew' => Yii::t('widget', 'courseNew'),
                'lecturers' => Yii::t('widget', 'lecturers'),
                'consultants' => Yii::t('widget', 'consultants'),
                'courseNearOpen' => Yii::t('widget', 'courseNearOpen'),
                'courseRelation' => Yii::t('widget', 'courseRelation'),
                'registerForm' => Yii::t('widget', 'registerForm'),
                'eventRelation' => Yii::t('widget', 'eventRelation'),
                'eventNearOpenDatePicker' => Yii::t('widget', 'eventNearOpenDatePicker'),
                'eventOld' => Yii::t('widget', 'eventOld'),
                'supportUser' => Yii::t('widget', 'supportUser'),
                'courseall' => Yii::t('widget', 'courseall'),
                'eventall' => Yii::t('widget', 'eventall'),
                'lecturerall' => Yii::t('widget', 'lecturerall'),
                'consultantall' => Yii::t('widget', 'consultantall'),
                'albumshot' => Yii::t('widget', 'albumshot'),
                'realestateall' => Yii::t('widget', 'realestateall'),
                'realestateProjectAll' => Yii::t('widget', 'realestateProjectAll'),
                'hotRealestateProject' => Yii::t('widget', 'hotRealestateProject'),
                'courseCategoryInHome' => Yii::t('widget', 'courseCategoryInHome'),
                'pageContent' => Yii::t('widget', 'pageContent'),
                'shopall' => Yii::t('widget', 'shopall'),
                'hotcar' => Yii::t('widget', 'hotcar'),
                'instagramFeed' => Yii::t('widget', 'instagramFeed'),
                'carall' => Yii::t('widget', 'carall'),
                'tourHotelGroupInHome' => Yii::t('widget', 'tourHotelGroupInHome'),
                'tourProvinceInHome' => Yii::t('widget', 'tourProvinceInHome'),
                'hothotel' => Yii::t('widget', 'hothotel'),
                'hottour' => Yii::t('widget', 'hottour'),
                'tourall' => Yii::t('widget', 'tourall'),
                'hotelall' => Yii::t('widget', 'hotelall'),
                'roomInHotel' => Yii::t('widget', 'roomInHotel'),
                'searchhotels' => Yii::t('widget', 'searchhotels'),
                'wishlist' => Yii::t('widget', 'wishlist'),
                'shopstorelocation' => Yii::t('widget', 'shopstorelocation'),
                'commentsRatingForm' => Yii::t('widget', 'commentsRatingForm'),
                'commentsRating' => Yii::t('widget', 'commentsRating'),
                'commentboxfull' => Yii::t('widget', 'commentboxfull'),
                'commentbox' => Yii::t('widget', 'commentbox'),
                'categoryPageSubProduct' => Yii::t('widget', 'categoryPageSubProduct'),
                'relationRoomInHotel' => Yii::t('widget', 'relationRoomInHotel'),
                'hotquestion' => Yii::t('widget', 'hotquestion'),
                'newquestion' => Yii::t('widget', 'newquestion'),
                'relquestion' => Yii::t('widget', 'relquestion'),
                'questionsubmit' => Yii::t('widget', 'questionsubmit'),
                'mapNew' => Yii::t('widget', 'mapNew'),
                'bdsProjectConfigall' => Yii::t('widget', 'bdsProjectConfigall'),
                'bdsProjectConfighot' => Yii::t('widget', 'bdsProjectConfighot'),
                'hoteldetail' => Yii::t('widget', 'hoteldetail'),
                'reviews' => Yii::t('widget', 'reviews'),
                'joball' => Yii::t('widget', 'joball'),
                'jobfilter' => Yii::t('widget', 'jobfilter'),
                'jobrelation' => Yii::t('widget', 'jobrelation'),
                'jobhighsalary' => Yii::t('widget', 'jobhighsalary'),
                'jobsearch' => Yii::t('widget', 'jobsearch'),
                'sitetype' => Yii::t('widget', 'sitetype'),
                'SeServiceWidget' => Yii::t('widget', 'SeServiceWidget'),
                'SeStaffWidget' => Yii::t('widget', 'SeStaffWidget'),
                'MapIframe' => Yii::t('widget', 'MapIframe'),
                'BusinessHour' => Yii::t('widget', 'BusinessHour'),
                'BackgroundMusic' => Yii::t('widget', 'BackgroundMusic'),
                'SeServiceAllWidget' => Yii::t('widget', 'SeServiceAllWidget'),
                'albumsImagesHot' => Yii::t('widget', 'albumsImagesHot'),
                'BrandWidget' => Yii::t('widget', 'BrandWidget'),
                'SiteInfoWidget' => Yii::t('widget', 'SiteInfoWidget'),
                'HpDoctorAll' => Yii::t('widget', 'HpDoctorAll'),
                'HpDoctorSearch' => Yii::t('widget', 'HpDoctorSearch'),
                'SeStaffSearch' => Yii::t('widget', 'SeStaffSearch'),
                'AirlineTicketNewWidget' => Yii::t('widget', 'AirlineTicketNewWidget'),
                'albumdetail' => Yii::t('widget', 'albumdetail'),
                'productdetail' => Yii::t('widget', 'productdetail'),
                'productDetailAttribute' => Yii::t('widget', 'productDetailAttribute'),
                'QuestionCampaignHot' => Yii::t('widget', 'QuestionCampaignHot'),
                'QuestionCampaignNormal' => Yii::t('widget', 'QuestionCampaignNormal'),
                'tourcategoryinhome' => Yii::t('widget', 'tourcategoryinhome'),
                'Pushup' => Yii::t('widget', 'Pushup'),
                'ratingcommentsproduct' => Yii::t('widget', 'ratingcommentsproduct'),
                'ratingcommentsproductform' => Yii::t('widget', 'ratingcommentsproductform'),
                'ManufacturerCategorySearch' => Yii::t('widget', 'ManufacturerCategorySearch'),
                'ManufacturerCategorySelect' => Yii::t('widget', 'ManufacturerCategorySelect'),
                'productFilterManufacturerCat' => Yii::t('widget', 'productFilterManufacturerCat'),
            ),
            'default' => array(
                'html' => Yii::t('widget', 'html'),
                'menu' => Yii::t('widget', 'menu'),
                'menu_vertical' => Yii::t('widget', 'menu_vertical'),
                'menufooter' => Yii::t('widget', 'menufooter'),
                'banner' => Yii::t('widget', 'banner'),
                'popup' => Yii::t('widget', 'popup'),
                'bannergroup' => Yii::t('widget', 'bannergroup'),
                'categorybox' => Yii::t('widget', 'category'),
                'categoryinhome' => Yii::t('widget', 'categoryinhome'),
                'destinationinhome' => Yii::t('widget', 'destinationinhome'),
                'homenewscategorydetail' => Yii::t('widget', 'homenewscategorydetail'),
                'homenewscategory_child_detail' => Yii::t('widget', 'homenewscategory_child_detail'),
                'hotnews' => Yii::t('widget', 'hotnews'),
                'mostreadnews' => Yii::t('widget', 'mostreadnews'),
                'newnews' => Yii::t('widget', 'newnews'),
                'newsall' => Yii::t('widget', 'newsall'),
                'newsrelation' => Yii::t('widget', 'newsrelation'),
                'tourrelation' => Yii::t('widget', 'tourrelation'),
                'newsrelationNextAndPrevious' => Yii::t('widget', 'newsrelationNextAndPrevious'),
                'newsIncategory' => Yii::t('widget', 'newsIncategory'),
                'tourIncategory' => Yii::t('widget', 'tourIncategory'),
                'courseIncategory' => Yii::t('widget', 'courseIncategory'),
                'homepostcategorydetail' => Yii::t('widget', 'homepostcategorydetail'),
                'postCategoryAndSub' => Yii::t('widget', 'postCategoryAndSub'),
                'hotproduct' => Yii::t('widget', 'hotproduct'),
                'hotwifi' => Yii::t('widget', 'hotwifi'),
                'hotproductWithShortDesc' => Yii::t('widget', 'hotproductWithShortDesc'),
                'productall' => Yii::t('widget', 'productall'),
                'manufacturerall' => Yii::t('widget', 'manufacturerall'),
                'productMembersOnly' => Yii::t('widget', 'productMembersOnly'),
                'choiceTheme' => Yii::t('widget', 'choiceTheme'),
                'productIncategory' => Yii::t('widget', 'productIncategory'),
                'productsrelation' => Yii::t('widget', 'productsrelation'),
                'newproducts' => Yii::t('widget', 'newproduct'),
                'productgroup' => Yii::t('widget', 'productgroup'),
                'popupregisterproduct' => Yii::t('widget', 'popupregisterproduct'),
                'productviewed' => Yii::t('widget', 'productviewed'),
                'productCompare' => Yii::t('widget', 'productCompare'),
                'productgroupinhome' => Yii::t('widget', 'productgroupinhome'),
                'productpromotioninhome' => Yii::t('widget', 'productpromotioninhome'),
                'promotionall' => Yii::t('widget', 'promotionall'),
                'promotionHotAndNormal' => Yii::t('widget', 'promotionHotAndNormal'),
                'productsetnew' => Yii::t('widget', 'productsetnew'),
                'productMostView' => Yii::t('widget', 'productMostView'),
                'productNewAndGroup' => Yii::t('widget', 'productNewAndGroup'),
                'productCategoryWithBackground' => Yii::t('widget', 'productCategoryWithBackground'),
                'categoryProductSelectFull' => Yii::t('widget', 'categoryProductSelectFull'),
                'categoryPageSub' => Yii::t('widget', 'categoryPageSub'),
                'categoryPageSubFull' => Yii::t('widget', 'categoryPageSubFull'),
                'productcategoryinhome' => Yii::t('widget', 'productcategoryinhome'),
                'newscategoryinhome' => Yii::t('widget', 'newscategoryinhome'),
                'productsort' => Yii::t('widget', 'productsort'),
                'productpricerange' => Yii::t('widget', 'productpricerange'),
                'productFilterInCat' => Yii::t('widget', 'productFilterInCat'),
                'useraccess' => Yii::t('widget', 'useraccess'),
                'yahoobox' => Yii::t('widget', 'yahoobox'),
                'customform' => Yii::t('widget', 'customform'),
                'onebanner' => Yii::t('widget', 'onebanner'),
                'social' => Yii::t('widget', 'social'),
                'map' => Yii::t('widget', 'map'),
                'searchbox' => Yii::t('widget', 'searchbox'),
                'searchboxcat' => Yii::t('widget', 'searchboxcat'),
                'facebookcomment' => Yii::t('widget', 'facebookcomment'),
                'introducebox' => Yii::t('widget', 'introducebox'),
                'newsletter' => Yii::t('widget', 'newsletter'),
                'logobox' => Yii::t('widget', 'logobox'),
                'shoppingcart' => Yii::t('widget', 'shoppingcart'),
                'videohot' => Yii::t('widget', 'videohot'),
                'videonew' => Yii::t('widget', 'videonew'),
                'pagesize' => Yii::t('widget', 'pagesize'),
                'jobnew' => Yii::t('widget', 'jobnew'),
                'albumnew' => Yii::t('widget', 'albumnew'),
                'imagenew' => Yii::t('widget', 'imagenew'),
                'languages' => Yii::t('widget', 'languages'),
                'scrollup' => Yii::t('widget', 'scrollup'),
                'support' => Yii::t('widget', 'support'),
                'productNewAndHot' => Yii::t('widget', 'productNewAndHot'),
                'albumsrelation' => Yii::t('widget', 'albumsrelation'),
                'videosrelation' => Yii::t('widget', 'videosrelation'),
                'albumsIncategory' => Yii::t('widget', 'albumsIncategory'),
                'courseNew' => Yii::t('widget', 'courseNew'),
                'lecturers' => Yii::t('widget', 'lecturers'),
                'consultants' => Yii::t('widget', 'consultants'),
                'courseNearOpen' => Yii::t('widget', 'courseNearOpen'),
                'registerForm' => Yii::t('widget', 'registerForm'),
                'eventNearOpenDatePicker' => Yii::t('widget', 'eventNearOpenDatePicker'),
                'eventOld' => Yii::t('widget', 'eventOld'),
                'courseRelation' => Yii::t('widget', 'courseRelation'),
                'eventRelation' => Yii::t('widget', 'eventRelation'),
                'supportUser' => Yii::t('widget', 'supportUser'),
                'courseall' => Yii::t('widget', 'courseall'),
                'eventall' => Yii::t('widget', 'eventall'),
                'lecturerall' => Yii::t('widget', 'lecturerall'),
                'consultantall' => Yii::t('widget', 'consultantall'),
                'albumshot' => Yii::t('widget', 'albumshot'),
                'realestateall' => Yii::t('widget', 'realestateall'),
                'realestateProjectAll' => Yii::t('widget', 'realestateProjectAll'),
                'hotRealestateProject' => Yii::t('widget', 'hotRealestateProject'),
                'courseCategoryInHome' => Yii::t('widget', 'courseCategoryInHome'),
                'pageContent' => Yii::t('widget', 'pageContent'),
                'shopall' => Yii::t('widget', 'shopall'),
                'hotcar' => Yii::t('widget', 'hotcar'),
                'instagramFeed' => Yii::t('widget', 'instagramFeed'),
                'carall' => Yii::t('widget', 'carall'),
                'tourHotelGroupInHome' => Yii::t('widget', 'tourHotelGroupInHome'),
                'tourProvinceInHome' => Yii::t('widget', 'tourProvinceInHome'),
                'hothotel' => Yii::t('widget', 'hothotel'),
                'hottour' => Yii::t('widget', 'hottour'),
                'tourall' => Yii::t('widget', 'tourall'),
                'hotelall' => Yii::t('widget', 'hotelall'),
                'roomInHotel' => Yii::t('widget', 'roomInHotel'),
                'searchhotels' => Yii::t('widget', 'searchhotels'),
                'wishlist' => Yii::t('widget', 'wishlist'),
                'shopstorelocation' => Yii::t('widget', 'shopstorelocation'),
                'commentsRatingForm' => Yii::t('widget', 'commentsRatingForm'),
                'commentsRating' => Yii::t('widget', 'commentsRating'),
                'commentbox' => Yii::t('widget', 'commentbox'),
                'commentboxfull' => Yii::t('widget', 'commentboxfull'),
                'categoryPageSubProduct' => Yii::t('widget', 'categoryPageSubProduct'),
                'relationRoomInHotel' => Yii::t('widget', 'relationRoomInHotel'),
                'hotquestion' => Yii::t('widget', 'hotquestion'),
                'mostquestionproduct' => Yii::t('widget', 'mostquestionproduct'),
                'newquestion' => Yii::t('widget', 'newquestion'),
                'relquestion' => Yii::t('widget', 'relquestion'),
                'questionsubmit' => Yii::t('widget', 'questionsubmit'),
                'mapNew' => Yii::t('widget', 'mapNew'),
                'MessageGroupBySender' => Yii::t('widget', 'MessageGroupBySender'),
                'MessageUnread' => Yii::t('widget', 'MessageUnread'),
                'bdsProjectConfigall' => Yii::t('widget', 'bdsProjectConfigall'),
                'bdsProjectConfighot' => Yii::t('widget', 'bdsProjectConfighot'),
                'hoteldetail' => Yii::t('widget', 'hoteldetail'),
                'reviews' => Yii::t('widget', 'reviews'),
                'videoscategoryinhome' => Yii::t('widget', 'videoscategoryinhome'),
                'searchsuggest' => Yii::t('widget', 'searchsuggest'),
                'joball' => Yii::t('widget', 'joball'),
                'jobfilter' => Yii::t('widget', 'jobfilter'),
                'jobrelation' => Yii::t('widget', 'jobrelation'),
                'jobhighsalary' => Yii::t('widget', 'jobhighsalary'),
                'jobsearch' => Yii::t('widget', 'jobsearch'),
                'sitetype' => Yii::t('widget', 'sitetype'),
                'SeServiceWidget' => Yii::t('widget', 'SeServiceWidget'),
                'SeStaffWidget' => Yii::t('widget', 'SeStaffWidget'),
                'MapIframe' => Yii::t('widget', 'MapIframe'),
                'BusinessHour' => Yii::t('widget', 'BusinessHour'),
                'BackgroundMusic' => Yii::t('widget', 'BackgroundMusic'),
                'SeServiceAllWidget' => Yii::t('widget', 'SeServiceAllWidget'),
                'albumsImagesHot' => Yii::t('widget', 'albumsImagesHot'),
                'BrandWidget' => Yii::t('widget', 'BrandWidget'),
                'SiteInfoWidget' => Yii::t('widget', 'SiteInfoWidget'),
                'HpDoctorAll' => Yii::t('widget', 'HpDoctorAll'),
                'HpDoctorSearch' => Yii::t('widget', 'HpDoctorSearch'),
                'SeStaffSearch' => Yii::t('widget', 'SeStaffSearch'),
                'AirlineTicketNewWidget' => Yii::t('widget', 'AirlineTicketNewWidget'),
                'albumdetail' => Yii::t('widget', 'albumdetail'),
                'productdetail' => Yii::t('widget', 'productdetail'),
                'productDetailAttribute' => Yii::t('widget', 'productDetailAttribute'),
                'QuestionCampaignHot' => Yii::t('widget', 'QuestionCampaignHot'),
                'QuestionCampaignNormal' => Yii::t('widget', 'QuestionCampaignNormal'),
                'tourcategoryinhome' => Yii::t('widget', 'tourcategoryinhome'),
                'Pushup' => Yii::t('widget', 'Pushup'),
                'ExpertransContactForm' => Yii::t('widget', 'ExpertransContactForm'),
                'ratingcommentsproduct' => Yii::t('widget', 'ratingcommentsproduct'),
                'ratingcommentsproductform' => Yii::t('widget', 'ratingcommentsproductform'),
                'ManufacturerCategorySearch' => Yii::t('widget', 'ManufacturerCategorySearch'),
                'ManufacturerCategorySelect' => Yii::t('widget', 'ManufacturerCategorySelect'),
                'carFilter' => Yii::t('widget', 'carFilter'),
                'productFilterManufacturerCat' => Yii::t('widget', 'productFilterManufacturerCat'),
            ),
        );

        if (isset($moduletypes[$theme_name]))
            return $moduletypes[$theme_name];
        elseif ($moduletypes['default'])
            return $moduletypes['default'];
        return array();
    }

//    /**
//     * get all theme config
//     */
//    static function getAllConfig() {
//        //theme_type.theme_name
//        $postleft = Widgets::POS_LEFT;
//        $postright = Widgets::POS_RIGHT;
//        $postheader = Widgets::POS_HEADER;
//        $postfooter = Widgets::POS_FOOTER;
//        $postcenter = Widgets::POS_CENTER;
//        $configs = array(
//            'news.news' => array(
//                $postheader => array(
//                    'news/news/' => array(),
//                    'news/news/category' => array(),
//                    'news/news/detail' => array(),
//                    '/site/site/contact' => array(),
//                    '/site/site/introduce' => array(),
//                    '/site/site/qa' => array(), // Hỏi đáp
//                ),
//                $postright => array(
//                    'news/news/' => array(),
//                    'news/news/category' => array(),
//                    'news/news/detail' => array(),
//                    '/site/site/contact' => array(),
//                    '/site/site/introduce' => array(),
//                    'site/site/qa' => array(), // Hỏi đáp
//                ),
//                $postcenter => array(
//                    'news/news/' => array(
//                        array('widget_type' => Widgets::WIDGET_TYPE_SYSTEM, 'widget_id' => 'hotnews'),
//                        array('widget_type' => Widgets::WIDGET_TYPE_SYSTEM, 'widget_id' => 'homenewscategorydetail'),
//                    )
//                ),
//            ),
//            'news.w3n0010' => array(
//                $postheader => array(
//                    'news/news/' => array(),
//                    'news/news/category' => array(),
//                    'news/news/detail' => array(),
//                    '/site/site/contact' => array(),
//                    '/site/site/introduce' => array(),
//                    '/site/site/qa' => array(), // Hỏi đáp
//                ),
//                $postright => array(
//                    'news/news/' => array(),
//                    'news/news/category' => array(),
//                    'news/news/detail' => array(),
//                    '/site/site/contact' => array(),
//                    '/site/site/introduce' => array(),
//                    'site/site/qa' => array(), // Hỏi đáp
//                ),
//                $postcenter => array(
//                    'news/news/' => array(
//                        array('widget_type' => Widgets::WIDGET_TYPE_SYSTEM, 'widget_id' => 'homenewscategorydetail'),
//                    )
//                ),
//            ),
//            'introduce.w3nhat' => array(
//                $postheader => array(
//                    '/introduce/introduce' => array(),
//                    '/site/site/contact' => array(),
//                    'site/site/introduce' => array(),
//                ),
//                $postleft => array(
//                    '/introduce/introduce' => array(),
//                    '/site/site/contact' => array(),
//                    'site/site/introduce' => array(),
//                ),
//                $postfooter => array(
//                    '/introduce/introduce' => array(),
//                    '/site/site/contact' => array(),
//                    'site/site/introduce' => array(),
//                ),
//            )
//        );
//
//        return $configs;
//    }
//
//    /**
//     * get them config
//     * @param type $key
//     */
//    static function getThemConfig($key = '') {
//        $themes = self::getAllConfig();
//        if (isset($themes[$key]))
//            return $themes[$key];
//        return array();
//    }
//
//    /**
//     * 
//     * @param type $key
//     * @param type $pos
//     */
//    static function getThemeConfigFollowPos($key = '', $pos = '') {
//        $config = self::getThemConfig($key);
//        if (isset($config[$pos]))
//            return $config[$pos];
//        return array();
//    }
}
