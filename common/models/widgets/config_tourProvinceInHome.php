<?php

/**
 * Description of config_tourProvinceInHome
 *
 * @author hungtm
 */
class config_tourProvinceInHome extends ConfigWidget {

    public $limit = 0;
    public $itemslimit = 0;

    public function rules() {
        return array_merge(array(
            array('limit', 'required'),
            array('limit', 'numerical', 'min' => 0, 'max' => 30),
            array('limit', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->limit = 0;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'limit' => $this->limit,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
            ))
        ));
        return $data;
    }

}
