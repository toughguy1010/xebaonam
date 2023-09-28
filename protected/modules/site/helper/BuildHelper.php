<?php

/**
 * 
 * Enter description here ...
 * @author minhbn
 *
 */
class BuildHelper extends BaseHelper {

    public static function helper($className = __CLASS__) {
        return parent::helper($className);
    }

    /**
     * return price range condition
     */
    function getAllAttributeSetInSite($options = array()) {
        if (!isset($options['limit']))
            $options['limit'] = 100;
        $results = array();
        $data = Yii::app()->db->createCommand()->select()
                ->from('product_attribute_set')
                ->where('site_id=' . Yii::app()->siteinfo['site_id'])
                ->limit($options['limit'])
                ->queryAll();
        if (count($data)) {
            foreach ($data as $item) {
                $results[$item['id']] = $item;
            }
        }
        return $results;
    }

}
