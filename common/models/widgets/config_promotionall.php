<?php

/**
 * Description of config_newnews
 *
 * @author hatv
 */
class config_promotionall extends ConfigWidget {

    public $limit = 0;
    public $show_on_time = 0;

    public function rules() {
        return array_merge(array(
            array('limit', 'required'),
            array('limit', 'numerical', 'min' => 0, 'max' => 30),
            array('limit,show_on_time', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->show_on_time = 0;
        $this->limit = 0;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'show_on_time' => $this->show_on_time,
                'limit' => $this->limit,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
            ))
        ));
        return $data;
    }

}
