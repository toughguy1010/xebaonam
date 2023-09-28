<?php

/**
 * Description of config_newnews
 *
 * @author minhbn
 */
class config_newsletter extends ConfigWidget {

    public $helptext = '';

    public function rules() {
        return array_merge(array(array('helptext', 'safe'),), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->helptext = '';
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'helptext' => $this->helptext,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
            ))
        ));
        return $data;
    }

}
