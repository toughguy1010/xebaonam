<?php

/**
 * Description of config_introduce
 *
 * @author minhbn
 */
class config_scrollup extends ConfigWidget {

    public $fromTop = 0;

    /**
     * 
     * @return type
     */
    public function rules() {
        return array_merge(array(
            array('fromTop', 'required'),
            array('fromTop', 'numerical', 'min' => 1, 'max' => 1000),
            array('fromTop', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->fromTop = 1;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
                'fromTop' => $this->fromTop,
            ))
        ));
        return $data;
    }

}
