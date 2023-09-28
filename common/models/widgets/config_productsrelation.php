<?php

/**
 * Description of config_newnews
 *
 * @author minhbn
 */
class config_productsrelation extends ConfigWidget {

    public $limit = 1;
    public $fromParent = 0;
    public $showProductDesc = 0;
    public $fromManufacture = 0;

    public function rules() {
        return array_merge(array(
            array('limit', 'required'),
            array('limit', 'numerical', 'min' => 1),
            array('limit, fromParent, showProductDesc', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->limit = 3;
        $this->fromParent = 0;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'limit' => $this->limit,
                'fromParent' => $this->fromParent,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
                'showProductDesc' => $this->showProductDesc,
            ))
        ));
        return $data;
    }

}
