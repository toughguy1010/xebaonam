<?php

/**
 * Description of FTSMySQL
 *
 * @author minhbn <minhcoltech@gmail.com>
 */
class FTSNormal {

    public $table = 'search_index';
    public $limit = 15;
    public $keyword = '';

    /**
     * search and return result
     * 
     * @param type $keyword
     * @param type $type
     * @return type
     */
    function search($keyword, $type) {
        $keyword = $this->processKeyWord($keyword);
        switch ($type) {
            case ClaSite::SEARCH_INDEX_TYPE_PRODUCT_CATEGORY: {
                    $this->table = ClaTable::getTable('product_categories');
                    $data = Yii::app()->db->createCommand()->select('*')
                            ->from($this->table)
                            ->where("cat_name like {$keyword} AND site_id=:site_id", array(':site_id'=>Yii::app()->controller->site_id))
                            ->limit($this->limit)
                            ->queryAll();
                }break;
            case ClaSite::SEARCH_INDEX_TYPE_TOUR_CATEGORY: {
                    $this->table = ClaTable::getTable('tour_categories');
                    $data = Yii::app()->db->createCommand()->select('*')
                            ->from($this->table)
                            ->where("cat_name like {$keyword} AND site_id=:site_id AND status = 1", array(':site_id'=>Yii::app()->controller->site_id))
                            ->limit($this->limit)
                            ->queryAll();
                }break;
            case ClaSite::SEARCH_INDEX_TYPE_TOUR: {
                $this->table = ClaTable::getTable('tour');
                $data = Yii::app()->db->createCommand()->select('p.*')
                    ->from($this->table . ' p')
                    ->where("p.name like {$keyword}  AND status = 1 AND site_id=" . Yii::app()->controller->site_id, array(':type' => $type))
                    ->limit($this->limit)
                    ->queryAll();
                }break;
            default: {
                    $this->table = ClaTable::getTable('product');
                    $data = Yii::app()->db->createCommand()->select('p.*')
                            ->from($this->table . ' p')
                            ->where("p.name like {$keyword} AND site_id=" . Yii::app()->controller->site_id, array(':type' => $type))
                            ->limit($this->limit)
                            ->queryAll();
                }
        }
        $results = $this->processData($data, $type);
        return $results;
    }

    /**
     * process keyword
     * 
     * @param type $keyword
     * @return type
     */
    function processKeyWord($keyword = '') {
        $return = '';
        $keyword = trim($keyword);
        if ($keyword) {
            $this->keyword = $keyword;
            $keywords = explode(' ', $keyword);
            if ($keywords) {
                $return = implode('%', $keywords);
                $return = '%' . $return . '%';
                $return = ClaGenerate::quoteValue($return);
            }
        }
        return $return;
    }

    function processData($data = null, $type = '') {
        $results = array();
        if ($data) {
            foreach ($data as $dt) {
                $key = isset($dt['cat_id']) ? $dt['cat_id'] : $dt['id'];
                $dt['type'] = $type;
                $results[$key] = $dt;
                $results[$key]['content'] = $this->getContent($dt, $type);
                $results[$key]['url'] = $this->getItemUrl($dt);
            }
        }
        return $results;
    }

    function getContent($data = array(), $type = '') {
        $content = '';
        switch ($type) {
            case ClaSite::SEARCH_INDEX_TYPE_PRODUCT: {
                    $content = isset($data['name']) ? $data['name'] : '';
                }break;
            case ClaSite::SEARCH_INDEX_TYPE_PRODUCT_CATEGORY: {
                    $content = isset($data['cat_name']) ? $data['cat_name'] : '';
                }break;
            case ClaSite::SEARCH_INDEX_TYPE_TOUR: {
                    $content = isset($data['name']) ? $data['name'] : '';
                }break;
            case ClaSite::SEARCH_INDEX_TYPE_TOUR_CATEGORY: {
                    $content = isset($data['cat_name']) ? $data['cat_name'] : '';
                }break;
        }
        return $content;
    }

    /**
     * 
     * @param type $item
     */
    function getItemUrl($item = null) {
        $url = '';
        if ($item && isset($item['type'])) {
            switch ($item['type']) {
                case ClaSite::SEARCH_INDEX_TYPE_PRODUCT: {
                        $url = Yii::app()->createUrl('/economy/product/detail', array('id' => $item['id'], 'alias' => $item['alias']));
                    }break;
                case ClaSite::SEARCH_INDEX_TYPE_PRODUCT_CATEGORY: {
                        $url = Yii::app()->createUrl('/economy/product/category', array('id' => $item['cat_id'], 'alias' => $item['alias']));
                    }break;
                case ClaSite::SEARCH_INDEX_TYPE_TOUR: {
                        $url = Yii::app()->createUrl('/tour/tour/detail', array('id' => $item['id'], 'alias' => $item['alias']));
                    }break;
                case ClaSite::SEARCH_INDEX_TYPE_TOUR_CATEGORY: {
                        $url = Yii::app()->createUrl('/tour/tour/category', array('id' => $item['cat_id'], 'alias' => $item['alias']));
                    }break;
            }
        }
        return $url;
    }

    function markKeyword($string = '') {
        if ($this->keyword) {
            $keywords = explode(' ', $this->keyword);
            if ($keywords) {
                foreach ($keywords as $kw) {
                    $string = preg_replace('/' . $kw . '/i', '<b>' . $kw . '</b>', $string);
                }
            }
        }
        return $string;
    }

    /**
     * set limit
     * @param type $limit
     */
    function setLimit($limit) {
        if ($limit)
            $this->limit = $limit;
    }

}
