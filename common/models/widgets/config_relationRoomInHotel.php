<?php

/**
 * Description of config_hotelall
 *
 * @author hatv
 */
class config_relationRoomInHotel extends ConfigWidget {

    public $limit = 1;
    public $hotel_id = 0;

    public function rules() {
        return array_merge(array(
            array('limit,hotel_id', 'required'),
            array('limit', 'numerical', 'min' => 1),
            array('hotel_id', 'numerical',),
            array('limit,hotel_id', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->limit = 10;
        $this->hotel_id = 0;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'hotel_id' => $this->hotel_id,
                'limit' => $this->limit,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
            ))
        ));
        return $data;
    }

}
