<?php

/**
 * Description of FTSMySQL
 *
 * @author minhbn <minhcoltech@gmail.com>
 */
class FTSMySQL {

    public $table = 'search_index';
    public $limit = 30;
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
        $data = Yii::app()->db->createCommand()->select('*')
                ->from($this->table)
                ->where("type=:type AND MATCH (content) AGAINST ($keyword IN BOOLEAN MODE)", array(':type' => $type))
                ->limit($this->limit)
                ->queryAll();
        $results = $this->processData($data);
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
                $return = implode('* +', $keywords);
                $return = '+' . $return . '*';
                $return = ClaGenerate::quoteValue($return);
            }
        }
        return $return;
    }

    function processData($data = null) {
        $results = array();
        if ($data) {
            foreach ($data as $dt) {
                $dt['data'] = json_decode($dt['data'], true);
                $results[$dt['id']] = $dt;
                $results[$dt['id']]['url'] = $this->getItemUrl($dt);
            }
        }
        return $results;
    }

    /**
     * 
     * @param type $item
     */
    function getItemUrl($item = null) {
        $url = '';
        if ($item && isset($item['type'])) {
            switch ($item['type']) {
                case ClaSite::SEARCH_INDEX_TYPE_PROJECT: {
                        $url = Yii::app()->createUrl('/bds/bdsProject/detail', array('id' => $item['data']['id'], 'alias' => $item['data']['alias']));
                    }break;
                case ClaSite::SEARCH_INDEX_TYPE_POST: {
                        $url = Yii::app()->createUrl('/bds/bdsRealEstate/detail', array('id' => $item['data']['id'], 'alias' => $item['data']['alias']));
                    }break;
                case ClaSite::SEARCH_INDEX_TYPE_COMPANY: {
                        $url = Yii::app()->createUrl('/profile/profile/detail', array('id' => $item['data']['id'], 'alias' => HtmlFormat::parseToAlias($item['data']['name'])));
                    }break;
                case ClaSite::SEARCH_INDEX_TYPE_BROKER: {
                        $url = Yii::app()->createUrl('/profile/profile/detail', array('id' => $item['data']['id'], 'alias' => HtmlFormat::parseToAlias($item['data']['name'])));
                    }break;
                case ClaSite::SEARCH_INDEX_TYPE_LOCATION: {
                        switch ($item['data']['type']) {
                            case ClaSite::SEARCH_INDEX_TYPE_LOCATION_PROVINCE: {
                                    $url = Yii::app()->createUrl('/bds/BdsProject', array('province_id' => $item['data']['id']));
                                }break;
                            case ClaSite::SEARCH_INDEX_TYPE_LOCATION_DISTRICT: {
                                    $url = Yii::app()->createUrl('/bds/BdsProject', array('district_id' => $item['data']['id']));
                                }break;
                            case ClaSite::SEARCH_INDEX_TYPE_LOCATION_WARD: {
                                    $url = Yii::app()->createUrl('/bds/BdsProject', array('ward_id' => $item['data']['id']));
                                }break;
                            case ClaSite::SEARCH_INDEX_TYPE_LOCATION_STREET: {
                                    $url = Yii::app()->createUrl('/bds/BdsProject', array('street_id' => $item['data']['id']));
                                }break;
                        }
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
