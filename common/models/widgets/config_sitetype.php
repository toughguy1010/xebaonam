<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of config_sitetype
 *
 * @author hungtm
 */
class config_sitetype extends ConfigWidget {

    public $type = 0;
    public $order_rank = 0;
    public $limit = 10;

    public function rules() {
        return array_merge(array(
            array('type', 'required'),
            array('type, order_rank, limit', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->type = 0;
        $this->order_rank = 0;
        $this->limit = 10;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'type' => $this->type,
                'order_rank' => $this->order_rank,
                'limit' => $this->limit,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
            ))
        ));
        return $data;
    }

}
