<?php

/**
 * Description of config_newnews
 *
 * @author minhbn
 */
class config_productFilterInCat extends ConfigWidget {

    public $priceFilter = 1;
    public $showQuantity = 0;

    public function rules() {
        return array_merge(array(
            array('priceFilter, showQuantity', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->priceFilter = 1;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'showQuantity' => $this->showQuantity,
                'priceFilter' => $this->priceFilter,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
            ))
        ));
        return $data;
    }

}
