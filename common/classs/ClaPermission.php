<?php

/**
 * Permission
 *
 * @author minhbn <minhcoltech@gmail.com>
 */
class ClaPermission {

    const HOME_KEY = 'home.home.index';
    const DIVISION_KEY = ';';

    static function getPermissionKeyArr() {
        $permis = array(
            self::HOME_KEY => Yii::t('common', 'homepage'),
            'banner.banner.*' => Yii::t('banner', 'banner_manager'),
            'banner.bannergroup.*' => Yii::t('banner', 'banner_group_manager'),
            'economy.product.*' => Yii::t('product', 'product_manager'),
            'economy.productcategory.*' => Yii::t('product', 'product_category'),
            'economy.productgroups.*' => Yii::t('product', 'product_group'),
            'economy.order.*' => Yii::t('shoppingcart', 'order_manager'),
            'economy.promotion.*' => Yii::t('product', 'promotion'),
            'content.news.*' => Yii::t('news', 'news_manager'),
            'content.newscategory.*' => Yii::t('news', 'news_category'),
            'content.newsletter.*' => Yii::t('news', 'newsletter'),
            'content.categorypage.*' => Yii::t('categorypage', 'categorypage'),
            'interface.menu.*' => Yii::t('menu', 'menu_manager'),
            'interface.menugroup.*' => Yii::t('menu', 'menu_group_manager2'),
            'setting.setting.*' => Yii::t('common', 'setting_site'),
            'setting.support.*' => Yii::t('site', 'site_support'),
            'widget.widget.*' => Yii::t('common', 'page_widget_list'),
            'media.album.*' => Yii::t('album', 'album_manager'),
            'media.video.*' => Yii::t('video', 'video_manager'),
            'media.videosCategories.*' => 'Danh mục video',
            'media.file.*' => Yii::t('file', 'file_manager'),
            'work.jobs.*' => Yii::t('work', 'work_manager'),
//            'bds.bdsProjectConfig.*' => Yii::t('service', 'manager_service'),
            'useradmin.useradmin.*' => 'Tài khoản quản trị',
            'setting.couponCampaign.*' => 'Quản lý mã khuyến mãi',
            'interface.customerReviews.*' => 'Ý kiến khách hàng',
            'custom.customform.*' => 'Liên hệ',
            'content.newsletter.*' => 'Đăng ký nhận bản tin',
            'economy.shopStore.*' => 'Quản lý đại lý',
            'economy.shareholderrelations.*' => 'Thông tin cổ đông',

        );
        //
        return $permis;
    }

}
