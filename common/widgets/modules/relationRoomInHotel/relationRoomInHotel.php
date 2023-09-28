<?php

class relationRoomInHotel extends WWidget {

    public $hotel_rooms;
    public $limit = 10;
    public $ishot = 10;
    public $totalitem = 0;
    public $room_id = 0;
    protected $name = 'relationRoomInHotel'; // name of widget
    protected $view = 'view'; // view of widget
    public $comforts;
    protected $linkkey = 'tour/tourHotel/detailRoom';

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_hotelall = new config_relationRoomInHotel('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_hotelall->limit)) {
            $this->limit = (int) $config_hotelall->limit;
        }
        if (isset($config_hotelall->ishot)) {
            $this->ishot = (int) $config_hotelall->ishot;
        }
        if ($config_hotelall->widget_title) {
            $this->widget_title = $config_hotelall->widget_title;
        }
        if (isset($config_hotelall->show_wiget_title)) {
            $this->show_widget_title = $config_hotelall->show_wiget_title;
        }

        if ($this->linkkey == ClaSite::getLinkKey())
            $this->room_id = Yii::app()->request->getParam('id');
        //
        if ($this->room_id) {
            $hotel = TourHotelRoom::model()->findByPk($this->room_id);
            if ($hotel) {
                $this->hotel_rooms = TourHotelRoom::getRelRoomByHotel($hotel->hotel_id, $this->room_id, array(
                            'limit' => $this->limit,
                            'order' => $order,
                ));
            }
        }
//        $this->totalitem = TourHotelRoom::countRoomInHotel($hotel->hotel_id);

        $this->comforts = TourHotel::getAllComfortsHotel();
        //
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'hotel_rooms' => $this->hotel_rooms,
            'limit' => $this->limit,
            'totalitem' => $this->totalitem,
            'comforts' => $this->comforts
        ));
    }

}
