<?php

/**
 * Description of config_wcustom
 *
 * @author minhbn
 */
class config_wcustom extends ConfigWidget {

    public $widget_template = '';

    public function rules() {
        return array_merge(array(
            // name, email, subject and body are required
            array('widget_template', 'required'),
            array('widget_template', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->widget_template = '';
    }

    public function buildConfigAttributes() {
        return array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'showallpage' => $this->showallpage,
                'show_wiget_title' => $this->show_wiget_title,
            ))
        ));
    }

}
