<?php

/**
 * Description of config_ManufacturerCategorySearch
 *
 * @author hungtm
 */
class config_ManufacturerCategorySearch extends ConfigWidget {

    public $limit = 1;

    public function rules() {
        return array_merge(array(
            array('limit', 'required'),
            array('limit', 'numerical', 'min' => 1),
            array('limit, width, height', 'safe'),
        ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->limit = 1;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
            ))
        ));
        return $data;
    }


}
