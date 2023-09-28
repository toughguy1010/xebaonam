<?php

/**
 * Description of config_pagesize
 *
 * @author minhbn
 */
class config_pagesize extends ConfigWidget {

    public $summaryText = '';
    public $afterText = '';
    public $pageSize = '';

    public function rules() {
        return array_merge(array(
            array('pageSize', 'required'),
            array('summaryText,afterText,pageSize', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->summaryText = '';
        $this->afterText = '';
        $this->pageSize = 10;
    }

    function getPageOptions() {
        return array(
            10 => 10,
            12 => 12,
            15 => 15,
            25 => 25,
            50 => 50,
            100 => 100,
        );
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'summaryText' => $this->summaryText,
                'afterText' => $this->afterText,
                'pageSize' => $this->pageSize,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
            ))
        ));
        return $data;
    }

}
