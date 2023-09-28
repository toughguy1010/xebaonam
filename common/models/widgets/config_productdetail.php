<?php

/**
 * Description of config_productdetail
 *
 * @author hungtm
 */
class config_productdetail extends ConfigWidget {

    public $product_id = 0;
    public $limit = 1;

    public function rules() {
        return array_merge(array(
            array('product_id', 'required'),
            array('product_id', 'numerical', 'min' => 1),
            array('product_id', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->product_id = 0;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'product_id' => $this->product_id,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
            ))
        ));
        return $data;
    }

    public function getPrimaryKey() {
        return 'product_id';
    }

    public function getTableName() {
        return ClaTable::getTable('product');
    }

}
