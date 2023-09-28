<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of config_banner
 *
 * @author minhbn
 */
class config_onebanner extends ConfigWidget {

    public $banner_id = 0;

    public function rules() {
        return array_merge(array(
            array('banner_id', 'required'),
            array('banner_id', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->banner_id = 0;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'banner_id' => $this->banner_id,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
            ))
        ));
        return $data;
    }

    public function getPrimaryKey() {
        return 'banner_id';
    }

    public function getTableName() {
        return ClaTable::getTable('banner');
    }

}
