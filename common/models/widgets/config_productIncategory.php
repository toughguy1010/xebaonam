<?php

/**
 * Description of config_newnews
 *
 * @author minhbn
 */
class config_productIncategory extends ConfigWidget {

    public $itemslimit = 5;
    public $limit = 1;
    public $cat_id = 0;
    public $child_cat = false;

    public function rules() {
        return array_merge(array(
            array('limit,cat_id', 'required'),
            array('limit,cat_id', 'numerical', 'min' => 1),
            array('limit,cat_id,itemslimit,child_cat', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->limit = 10;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'limit' => $this->limit,
                'itemslimit' => $this->itemslimit,
                'cat_id' => $this->cat_id,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
                'child_cat' => $this->child_cat,
            ))
        ));
        return $data;
    }
    
    public function getPrimaryKey() {
        return 'cat_id';
    }

    public function getTableName() {
        return ClaTable::getTable('productcategory');
    }


}
