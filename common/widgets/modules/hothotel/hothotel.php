<?php

class hothotel extends WWidget {

    public $hotels;
    public $limit = 5;
    protected $name = 'hothotel'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        $config_hothotel = new config_hothotel('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_hothotel->limit)) {
            $this->limit = (int) $config_hothotel->limit;
        }
        if ($config_hothotel->widget_title) {
            $this->widget_title = $config_hothotel->widget_title;
        }
        if (isset($config_hothotel->show_wiget_title)) {
            $this->show_widget_title = $config_hothotel->show_wiget_title;
        }
        // get hot hotel
        $this->hotels = TourHotel::getHotHotels(array('limit' => $this->limit));
        
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
        ));
    }

}
