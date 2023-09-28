<?php

/**
 * Description of config_newnews
 *
 * @author minhbn
 */
class config_productgroup extends ConfigWidget {

    public $group_limit = 0;
    public $show_all_group = 0;
    public $group_id = 0;
    public $limit = 1;

    public function rules() {
        return array_merge(array(
            array('limit,group_id', 'required'),
            array('limit', 'numerical', 'min' => 1, 'max' => 40),
            array('group_id', 'numerical', 'min' => 1),
            array('limit,group_id', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->limit = 10;
        $this->group_id = 0;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'limit' => $this->limit,
                'group_id' => $this->group_id,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
            ))
        ));
        return $data;
    }

    public function getPrimaryKey() {
        return 'group_id';
    }

    public function getTableName() {
        return ClaTable::getTable('productgroups');
    }

}
