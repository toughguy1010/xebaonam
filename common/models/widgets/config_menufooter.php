<?php

/**
 * Description of config_menufooter
 *
 * @author minhbn
 */
class config_menufooter extends ConfigWidget {

    public $group_id = 0;
    public $rows = 1;
    public $cols = 1;

    public function rules() {
        return array_merge(array(
            array('group_id', 'required'),
            array('rows,cols', 'numerical', 'min' => 1, 'max' => 12),
            array('group_id,directfrom', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->group_id = 0;
        $this->rows = 1;
        $this->cols = 1;
    }

    public function buildConfigAttributes() {
        return array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'group_id' => $this->group_id,
                'rows' => $this->rows,
                'cols' => $this->cols,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
            ))
        ));
    }

    public function getPrimaryKey() {
        return 'group_id';
    }

    public function getTableName() {
        return ClaTable::getTable('menu_group');
    }

}
