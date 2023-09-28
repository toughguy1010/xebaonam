<?php

/**
 * Description of config_newnews
 *
 * @author minhbn
 */
class config_yahoobox extends ConfigWidget {

    public $yahoos = '';

    public function rules() {
        return array_merge(array(
            array('yahoos', 'required'),
            array('yahoos', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->yahoos = '';
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'yahoos' => $this->yahoos,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
            ))
        ));
        return $data;
    }

}
