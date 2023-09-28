<?php
/**
 * Description of config_useraccess
 *
 * @author minhbn
 */
class config_useraccess extends ConfigWidget {

    public $showonline = 1;

    public function rules() {
        return array_merge(array(
            array('showonline', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->showonline = 1;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'showonline' => $this->showonline,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
            ))
        ));
        return $data;
    }

}
