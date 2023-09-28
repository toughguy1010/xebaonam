<?php

/**
 * Description of config_newnews
 *
 * @author minhbn
 */
class config_hotwifi extends ConfigWidget {

    public $limit = 1;
    public $select_all =  false;

    public function rules() {
        return array_merge(array(
            array('limit', 'required'),
            array('limit', 'numerical', 'min' => 1),
            array('limit, select_all', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->limit = 3;
        $this->select_all = false;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'limit' => $this->limit,
                'showallpage' => $this->showallpage,
                'select_all' => $this->select_all,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
            ))
        ));
        return $data;
    }

}
