<?php

/**
 * Description of config_albumdetail
 *
 * @author hungtm
 */
class config_popupregisterproduct extends ConfigWidget {

    public $popup_id = 0;
    public $limit = 1;

    public function rules() {
        return array_merge(array(
            array('popup_id', 'required'),
            array('popup_id', 'numerical', 'min' => 0),
            array('popup_id', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->popup_id = 0;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'popup_id' => $this->popup_id,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
            ))
        ));
        return $data;
    }

    public function getPrimaryKey() {
        return 'popup_id';
    }

    public function getTableName() {
        return ClaTable::getTable('popup_register_product');
    }

}
