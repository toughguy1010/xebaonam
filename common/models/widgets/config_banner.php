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
class config_banner extends ConfigWidget {

    public $banner_group_id = 0;
    public $get_group_info = 0;
    public $limit = 10;
    public $enable_start_end_time = 0;

    //
    public function rules() {
        return array_merge(array(
            array('banner_group_id', 'required'),
            array('banner_group_id,limit,enable_start_end_time, get_group_info', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->banner_group_id = 0;
        $this->limit = 10;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'banner_group_id' => $this->banner_group_id,
                'limit' => $this->limit,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
                'enable_start_end_time' => $this->enable_start_end_time,
                'get_group_info' => $this->get_group_info,
            ))
        ));
        return $data;
    }

    public function getPrimaryKey() {
        return 'banner_group_id';
    }

    public function getTableName() {
        return ClaTable::getTable('banner_group');
    }

}
