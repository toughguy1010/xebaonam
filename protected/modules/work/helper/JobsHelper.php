<?php

/**
 *
 * Enter description here ...
 * @author hatv
 *
 */
class JobsHelper extends BaseHelper {

    public static function helper($className = __CLASS__) {
        return parent::helper($className);
    }

    /**
     *
     * @return int
     */
    function getCurrentPage() {
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page)
            $page = 1;
        return $page;
    }

    function getPageSize() {
        $pagesize = Yii::app()->request->getParam(ClaSite::PAGE_SIZE_VAR);
        $allowed_page_size =  explode(',',Yii::app()->siteinfo['allowed_page_size']);
        $pageSizeAry = (isset(Yii::app()->siteinfo['site_page_size'])) ? Yii::app()->siteinfo['site_page_size'] : array();
        if (!$pagesize && count($allowed_page_size) > 0 && count($pageSizeAry) > 0){
            // $pageSizeAry = ClaSite::getSitePageSizeInfo();
            $is_allowed = in_array(ClaSite::getLinkKey(),$allowed_page_size);
            if($is_allowed && isset($pageSizeAry[ClaSite::getLinkKey()]) && count($pageSizeAry[ClaSite::getLinkKey()]) > 0){
                return $pageSizeAry[ClaSite::getLinkKey()];
            };
        }
        if (!$pagesize){
            $pagesize = (isset(Yii::app()->siteinfo['pagesize'])) ? Yii::app()->siteinfo['pagesize'] : Yii::app()->params['defaultPageSize'];
        }
        return $pagesize;
    }

}
