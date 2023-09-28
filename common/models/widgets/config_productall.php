<?php

/**
 * Description of config_newnews
 *
 * @author minhbn
 */
class config_productall extends ConfigWidget {

    public $limit = 1;
    public $only_slogan_exits = false;

    public function rules() {
        return array_merge(array(
            array('limit', 'required'),
            array('limit', 'numerical', 'min' => 1),
            array('limit, only_slogan_exits', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->limit = 10;
        $this->only_slogan_exits = false;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'limit' => $this->limit,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
                'only_slogan_exits' => $this->only_slogan_exits,
            ))
        ));
        return $data;
    }

}
