<?php
class SiteGlobal {
    
    public static $currentsiteid = 0;
    public static $cacheArr = array();
    public static $siteArray= array();
    //Thêm một phần tử vào mảng cache
    static function setCacheArr($key, $value) {
        self::$cacheArr[$key] = $value;
    }

    //Xóa một phần tử trong mảng cache
    static function deleteCacheArr($key) {
        unset(self::$cacheArr[$key]);
    }
    // add site to site array
    static function setSiteId($site_id){
        self::$currentsiteid = $site_id;
    }
    

}