<?php

/**
 * Description of config_BusinessHour
 *
 * @author hungtm
 */
class config_Pushup extends ConfigWidget {

    public $type =  ClaPushup::type_onesignal;

    public function rules() {
        return array_merge(array(
            array('type', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->type = ClaPushup::type_onesignal;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
                'type' => $this->type,
            ))
        ));
        return $data;
    }

}
