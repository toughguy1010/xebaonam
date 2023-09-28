<?php

/**
 * Description of config_productpricerange
 *
 * @author minhbn
 */
class config_productpricerange extends ConfigWidget {

    public $range;
    public $summaryText = '';

    //
    public function rules() {
        return array_merge(array(
            array('range,summaryText', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->summaryText = '';
        $this->range = '';
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'summaryText' => $this->summaryText,
                'range' => $this->range,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
            ))
        ));
        return $data;
    }

    function beforeSave() {
        //
        $priceFrom = $this->range[0];
        $priceTo = $this->range[1];
        $priceText = $this->range['priceText'];
        //
        $range = array();
        if ($priceFrom && count($priceFrom)) {
            foreach ($priceFrom as $key => $price) {
                $_temp[0] = $price;
                $_temp[1] = (isset($priceTo[$key])) ? $priceTo[$key] : 0;
                $_temp['priceText'] = (isset($priceText[$key])) ? $priceText[$key] : '';
                if ($_temp[0] || $_temp[1])
                    array_push($range, $_temp);
            }
        }
        //
        $this->range = $range;
        //
        return parent::beforeSave();
    }

}
