<?php

/**
 * Description of config_hoteldetail
 *
 * @author hungtm
 */
class config_hoteldetail extends ConfigWidget {

    public $hotel_id = 0;
    public $limit = 1;

    public function rules() {
        return array_merge(array(
            array('hotel_id', 'required'),
            array('hotel_id', 'numerical', 'min' => 1),
            array('hotel_id', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->hotel_id = 0;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'hotel_id' => $this->hotel_id,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
            ))
        ));
        return $data;
    }

    public function getPrimaryKey() {
        return 'hotel_id';
    }

    public function getTableName() {
        return ClaTable::getTable('tour_hotel');
    }

}
