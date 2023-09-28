<?php

/**
 * Description of config_postCategoryAndSub
 *
 * @author minhbn
 */
class config_postCategoryAndSub extends ConfigWidget {
    public $itemslimit = 0;

    public function rules() {
        return array_merge(array(
            array('itemslimit', 'required'),
            array('itemslimit', 'numerical', 'min' => 0, 'max' => 30),
            array('itemslimit', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->itemslimit = 0;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'itemslimit' => $this->itemslimit,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
            ))
        ));
        return $data;
    }

}
