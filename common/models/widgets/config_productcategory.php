<?php

/**
 * Description of config_productcategoryinhome
 *
 * @author minhbn
 */
class config_productcategory extends ConfigWidget {

    public $limit = 0;
    public $itemslimit = 0;
    public $onlyisHot = 0;

    public function rules() {
        return array_merge(array(
            array('itemslimit,limit', 'required'),
            array('limit,itemslimit,onlyisHot', 'numerical', 'min' => 0, 'max' => 30),
            array('limit,itemslimit,onlyisHot', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->itemslimit = 0;
        $this->limit = 0;
        $this->onlyisHot = 0;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'itemslimit' => $this->itemslimit,
                'limit' => $this->limit,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
                'onlyisHot' => $this->onlyisHot,
            ))
        ));
        return $data;
    }

}
