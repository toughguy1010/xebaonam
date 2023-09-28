<?php

/**
 * Description of config_newnews
 *
 * @author hungtm
 */
class config_categoryProductSelectFull extends ConfigWidget {

    public $type = 0;
    public $parent = 0;

    public function rules() {
        return array_merge(array(
            array('type', 'required'),
            array('parent', 'numerical', 'min' => 0),
            array('limit,parent', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->type = 0;
        $this->parent = 0;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'type' => $this->type,
                'parent' => $this->parent,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
            ))
        ));
        return $data;
    }
}
