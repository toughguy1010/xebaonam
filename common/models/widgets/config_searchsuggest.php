<?php

/**
 * Description of config_searchbox
 *
 * @author minhbn
 */
class config_searchsuggest extends ConfigWidget {

    public $limit;
    public $placeHolder;

    public function rules() {
        return array_merge(array(
            array('limit', 'numerical', 'min' => 1),
            array('limit, placeHolder', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->limit = 10;
        $this->placeHolder = '';
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'limit' => $this->limit,
                'placeHolder' => $this->placeHolder,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
            ))
        ));
        return $data;
    }

}
