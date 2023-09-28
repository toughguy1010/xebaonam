<?php

/**
 * Description of config_courseNearOpen
 *
 * @author hungtm
 */
class config_eventNearOpenDatePicker extends ConfigWidget {

    public $limit = 1;
    public $show_via_hot_order = null;

    public function rules() {
        return array_merge(array(
            array('limit', 'required'),
            array('show_via_hot_order', 'numerical'),
            array('limit', 'numerical', 'min' => 1),
            array('limit', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->limit = 1;
        $this->show_via_hot_order = 0;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'limit' => $this->limit,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
                'show_via_hot_order' => $this->show_via_hot_order,
            ))
        ));
        return $data;
    }

}
