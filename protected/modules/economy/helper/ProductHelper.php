<?php

/**
 *
 * Enter description here ...
 * @author minhbn
 *
 */
class ProductHelper extends BaseHelper {

    public static function helper($className = __CLASS__) {
        return parent::helper($className);
    }

    /**
     * return price range condition
     */
    function getPriceRangeQuery() {
        //
        $priceFrom = floatval(Yii::app()->request->getParam(ClaSite::PAGE_PRICE_FROM));
        if (!$priceFrom)
            $priceFrom = 0;
        $priceTo = floatval(Yii::app()->request->getParam(ClaSite::PAGE_PRICE_TO));
        if (!$priceTo)
            $priceTo = 0;
        //
        $condition = '';
        if ($priceFrom > 0 && $priceTo > 0)
            $condition = $priceFrom . '<=price' . ' AND price<' . $priceTo;
        elseif ($priceFrom > 0 && $priceTo <= 0)
            $condition = $priceFrom . '<=price';
        elseif ($priceFrom <= 0 && $priceTo > 0)
            $condition = 'price<=' . $priceTo;
        return $condition;
    }

    /**
     * return condition query
     */
    function getConditionQuery() {
        $condition = '';
        $priceRangeCondition = $this->getPriceRangeQuery();
        if ($priceRangeCondition)
            $condition.=$priceRangeCondition;
        return $condition;
    }

    /**
     * return order query
     * @param type $order
     */
    function getOrderQuery() {
        $sort = Yii::app()->request->getParam(ClaSite::PAGE_SORT);
        $order = '';
        if ($sort) {
            switch ($sort) {
                case 'new': $order = 'position ASC, isnew DESC,created_time DESC';
                    break;
                case 'new_desc': $order = 'isnew,created_time';
                    break;
                case 'price': $order = 'price';
                    break;
                case 'price_desc': $order = 'price DESC';
                    break;
                case 'name': $order = 'name';
                    break;
                case 'name_desc': $order = 'name DESC';
                    break;
            }
        }
        return $order;
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
//            $pageSizeAry = ClaSite::getSitePageSizeInfo();
            $is_allowed = in_array(ClaSite::getLinkKey(),$allowed_page_size);
            if($is_allowed && isset($pageSizeAry[ClaSite::getLinkKey()]) && count($pageSizeAry[ClaSite::getLinkKey()]) > 0){
                return $pageSizeAry[ClaSite::getLinkKey()];
            };
        }
        if (!$pagesize){
            $pagesize = (isset(Yii::app()->siteinfo['pagesize'])) ? Yii::app()->siteinfo['pagesize'] : Yii::app()->params['defaultPageSize'];
        }
        if (ClaSite::isMobile()) {
            $pagesize =16;
        }
        return $pagesize;
    }

}
