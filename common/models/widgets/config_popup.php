<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of config_popup
 *
 * @author minhbn
 */
class config_popup extends ConfigWidget {

    public $limit = 10;
    public $enable_start_end_time = 0;

    //
    public function rules() {
        return array_merge(array(
            array('', 'required'),
            array('limit,enable_start_end_time', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->limit = 10;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'limit' => $this->limit,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
                'enable_start_end_time' => $this->enable_start_end_time,
            ))
        ));
        return $data;
    }

}
