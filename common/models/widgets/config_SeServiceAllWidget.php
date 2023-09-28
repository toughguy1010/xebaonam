<?php

/**
 * Description of config_SeServiceAllWidget
 *
 * @author hungtm
 */
class config_SeServiceAllWidget extends ConfigWidget {

    public $limit = 1;
    public $style = 1; // 1col
    public $view = 'view';

    public function rules() {
        return array_merge(array(
            array('limit', 'required'),
            array('limit', 'numerical', 'min' => 1),
            array('limit, style, view', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->limit = 3;
        $this->view = 'view';
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'limit' => $this->limit,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
                'style' => $this->style,
                'view' => $this->view,
            ))
        ));
        return $data;
    }

}
