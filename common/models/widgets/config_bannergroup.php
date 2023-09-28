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
class config_bannergroup extends ConfigWidget {

    public $banner_group_id = 0;
    public $style = 'default';
    public $timeDelay = 4000;
    public $limit = 10;
    public $enable_start_end_time = 0;
    public $disable_js_default = 0;

    public function rules() {
        return array_merge(array(
            array('banner_group_id,style', 'required'),
            array('style', 'isStyle'),
            array('timeDelay', 'numerical', 'min' => 10, 'max' => 20000),
            array('banner_group_id,style,limit,disable_js_default,enable_start_end_time', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->banner_group_id = 0;
        $this->timeDelay = 4000;
        $this->style = 'default';
        $this->limit = 10;
        $this->enable_start_end_time = 0;
    }

    /**
     * validate style
     * @param type $attribute
     * @param type $params
     * @return boolean
     */
    public function isStyle($attribute, $params) {
        $styles = $this->getListStyleArr();
        if (!isset($styles[$this->$attribute])) {
            $this->addError($attribute, Yii::t('errors', 'content_invalid'));
            return false;
        }
        return true;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'banner_group_id' => $this->banner_group_id,
                'timeDelay' => $this->timeDelay,
                'style' => $this->style,
                'limit' => $this->limit,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
                'disable_js_default' => $this->disable_js_default,
                'enable_start_end_time' => $this->enable_start_end_time
            ))
        ));
        return $data;
    }

    function getListStyleArr() {
        return array(
            'default' => 'Carousel Basic',
            'style1' => 'Carousel FullWidth',
            'style2' => 'IView Basic',
            'style3' => 'Style 3',
            'style4' => 'Style 4',
        );
    }

    public function getPrimaryKey() {
        return 'banner_group_id';
    }

    public function getTableName() {
        return ClaTable::getTable('banner_group');
    }

}
