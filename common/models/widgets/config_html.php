<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of config_html
 *
 * @author minhbn
 */
class config_html extends ConfigWidget {

    public $html = '';

    public function rules() {
        return array_merge(array(
            array('html', 'required'),
            array('html','length', 'max' => 10000),
            array('html', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->html = '';
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'html' => $this->html,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
            ))
        ));
        return $data;
    }

}
