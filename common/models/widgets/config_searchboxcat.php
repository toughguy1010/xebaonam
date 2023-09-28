<?php

/**
 * Description of config_searchbox
 *
 * @author minhbn
 */
class config_searchboxcat extends ConfigWidget {

    public $showcat;

    public function rules() {
        return array_merge(array(
            array('showcat', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->showcat = 0;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'showcat' => $this->showcat,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
            ))
        ));
        return $data;
    }

}
