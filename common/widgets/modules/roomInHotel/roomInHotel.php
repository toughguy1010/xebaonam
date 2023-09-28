<?php

class roomInHotel extends WWidget {

    public $hotels;
    public $limit = 10;
    public $totalitem = 0;
    public $hotel_id = 0;
    public $ishot = 0;
    public $paginate = 0;
    protected $name = 'roomInHotel'; // name of widget
    protected $view = 'view'; // view of widget
    public $comforts;

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_hotelall = new config_roomInHotel('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_hotelall->limit)) {
            $this->limit = (int) $config_hotelall->limit;
        }
        if (isset($config_hotelall->ishot)) {
            $this->ishot = (int) $config_hotelall->ishot;
        }
        if (isset($config_hotelall->paginate)) {
            $this->paginate = (int) $config_hotelall->paginate;
        }
        if ($config_hotelall->widget_title) {
            $this->widget_title = $config_hotelall->widget_title;
        }
        if (isset($config_hotelall->show_wiget_title)) {
            $this->show_widget_title = $config_hotelall->show_wiget_title;
        }
        if (isset($config_hotelall->hotel_id)) {
            $this->hotel_id = $config_hotelall->hotel_id;
        }
        //
        if ($this->paginate == 1) {
            $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
            if (!$page) {
                $page = 1;
            }
            $order = 'id DESC';
            //
            $this->hotels = TourHotelRoom::getRoomByHotelidPager($this->hotel_id, array(
                        'limit' => $this->limit,
                        ClaSite::PAGE_VAR => $page,
                        'order' => $order,
            ));
            $this->totalitem = TourHotelRoom::countRoomInHotel($this->hotel_id);
        } else {
            $order = 'id DESC';
            $this->hotels = TourHotelRoom::getRoomByHotelid($this->hotel_id, array(
                        'limit' => $this->limit,
                        'order' => $order,
                        'ishot' => $this->ishot,
            ));
            $this->totalitem = 0;
        }


        $this->comforts = TourHotel::getAllComfortsRoom();
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
            'hotels' => $this->hotels,
            'limit' => $this->limit,
            'totalitem' => $this->totalitem,
            'comforts' => $this->comforts
        ));
    }

}
