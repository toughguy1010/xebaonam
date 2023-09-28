<?php

class hotelall extends WWidget {

    public $hotels;
    public $limit = 10;
    public $totalitem = 0;
    protected $name = 'hotelall'; // name of widget
    protected $view = 'view'; // view of widget
    public $comforts;

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_hotelall = new config_hotelall('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_hotelall->limit)) {
            $this->limit = (int) $config_hotelall->limit;
        }
        if ($config_hotelall->widget_title) {
            $this->widget_title = $config_hotelall->widget_title;
        }
        if (isset($config_hotelall->show_wiget_title)) {
            $this->show_widget_title = $config_hotelall->show_wiget_title;
        }
        //
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page) {
            $page = 1;
        }
        $order = 'id DESC';
        //
        $this->hotels = TourHotel::getAllhotels(array(
                    'limit' => $this->limit,
                    ClaSite::PAGE_VAR => $page,
                    'order' => $order,
        ));
        $this->totalitem = TourHotel::countAll();
        
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
            'hotels' => $this->hotels,
            'limit' => $this->limit,
            'totalitem' => $this->totalitem,
            'comforts' => $this->comforts
        ));
    }

}
