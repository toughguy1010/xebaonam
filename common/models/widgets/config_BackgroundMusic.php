<?php

/**
 * Description of config_BusinessHour
 *
 * @author hungtm
 */
class config_BackgroundMusic extends ConfigWidget {

    public $autoPlay = self::STAtUS_FALSE;
    public $repeat = self::STAtUS_FALSE;
    public $showControl = self::STAtUS_FALSE;

    public function rules() {
        return array_merge(array(
            array('autoPlay, repeat, showControl', 'numerical', 'min' => 0),
            array('autoPlay, repeat, showControl', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->autoPlay = self::STAtUS_FALSE;
        $this->repeat = self::STAtUS_FALSE;
        $this->showControl = self::STAtUS_FALSE;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
            ))
        ));
        return $data;
    }

}
