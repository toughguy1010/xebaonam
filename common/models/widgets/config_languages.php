<?php
/**
 * Description of config_languages
 *
 * @author minhbn
 */
class config_languages extends ConfigWidget {
    public $autoTrans = 0;
    
    public function rules() {
        return array_merge(array(
            array('autoTrans', 'safe'),
                ), parent::rules());
    }
    
    public function loadDefaultConfig() {
        $this->autoTrans = 0;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
                'autoTrans' => $this->autoTrans,
            ))
        ));
        return $data;
    }
}
