<?php

/**
 * Description of config_jobhighsalary
 *
 * @author hungtm
 */
class config_jobhighsalary extends ConfigWidget {

    public $limit = 1;
    public $salary_min = 3000000; // default 3 triệu

    public function rules() {
        return array_merge(array(
            array('limit, salary_min', 'required'),
            array('limit, salary_min', 'numerical', 'min' => 1),
            array('limit, salary_min', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->limit = 1;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'limit' => $this->limit,
                'salary_min' => $this->salary_min,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
            ))
        ));
        return $data;
    }

}
