<?php

class SearchHelper extends BaseHelper{

    public $filterRequest = null;

    function buildWhere(){
        $where = array();
        $params = $this->getFilterRequest();
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $itemW = $this->buildFilterItem($key, $value);
                if ($itemW)
                    $where[] = $itemW;
            }
        }
        $where = (!empty($where)) ? implode(' and ', $where) : '';
        return $where;
    }
    /**
     * get filter request array
     * @return type
     */
    public function getFilterRequest() {
        if (is_null($this->filterRequest)) {
            parse_str(Yii::app()->request->getQueryString(), $paramsRequest);
            $this->filterRequest = $paramsRequest;
        }
        return $this->filterRequest;
    }

    public function buildFilterItem($key, $value) {
        $where = '';
        if ($key && !empty($value)) {
            if ($key == 'pmin') {
                $where = ($key == 'pmin' && is_numeric($value)) ? 'price>' . $value : '';
            } elseif ($key == 'pmax') {
                $where = ($key == 'pmax' && is_numeric($value)) ? 'price<' . $value : '';
            }
        }
        return $where;
    }

}
