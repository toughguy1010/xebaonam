<?php

/**
 * Description of config_courseall
 *
 * @author hungtm
 */
class config_eventall extends ConfigWidget {

    public $limit = 0;

    public function rules() {
        return array_merge(array(
            array('limit', 'required'),
            array('limit', 'numerical', 'min' => 1),
            array('limit', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->limit = Course::COURSE_DEFAUTL_LIMIT;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'limit' => $this->limit,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
            ))
        ));
        return $data;
    }

}
