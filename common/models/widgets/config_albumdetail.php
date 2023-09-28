<?php

/**
 * Description of config_albumdetail
 *
 * @author hungtm
 */
class config_albumdetail extends ConfigWidget {

    public $album_id = 0;
    public $limit = 1;

    public function rules() {
        return array_merge(array(
            array('album_id', 'required'),
            array('album_id', 'numerical', 'min' => 1),
            array('album_id', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->album_id = 0;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'album_id' => $this->album_id,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
            ))
        ));
        return $data;
    }

    public function getPrimaryKey() {
        return 'album_id';
    }

    public function getTableName() {
        return ClaTable::getTable('albums');
    }

}
