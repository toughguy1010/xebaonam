<?php

/**
 * 
 * Enter description here ...
 * @author minhbn
 *
 */
class EventHelper extends BaseHelper {

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
                case 'new': $order = 'isnew DESC,created_time DESC';
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
        if (!$pagesize)
            $pagesize = (isset(Yii::app()->siteinfo['pagesize'])) ? Yii::app()->siteinfo['pagesize'] : Yii::app()->params['defaultPageSize'];
        return $pagesize;
    }

}
