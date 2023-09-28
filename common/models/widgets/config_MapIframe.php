<?php

/**
 * Description of config_MapIframe
 *
 * @author hungtm
 */
class config_MapIframe extends ConfigWidget {

    public $limit = 1;
    public $width = 0;
    public $height = 0;

    public function rules() {
        return array_merge(array(
            array('limit', 'required'),
            array('limit', 'numerical', 'min' => 1),
            array('limit, width, height', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->limit = 1;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'width' => $this->width,
                'height' => $this->height,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
            ))
        ));
        return $data;
    }

}
