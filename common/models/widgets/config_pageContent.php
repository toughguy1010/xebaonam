<?php

/**
 * Description of config_newnews
 *
 * @author hungtm
 */
class config_pageContent extends ConfigWidget {

    public $page_id = 0;
    public $limit = 1;

    public function rules() {
        return array_merge(array(
            array('page_id', 'required'),
            array('page_id', 'numerical', 'min' => 1),
            array('page_id', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->page_id = 0;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'page_id' => $this->page_id,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
            ))
        ));
        return $data;
    }

    public function getPrimaryKey() {
        return 'page_id';
    }

    public function getTableName() {
        return ClaTable::getTable('categorypage');
    }

}
