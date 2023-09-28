<?php

// Khách sạn chi tiết
class hoteldetail extends WWidget {

    public $hotel_id = null;
    protected $name = 'hoteldetail'; // name of widget
    protected $view = 'view'; // view of widget
    protected $link = '';
    public $hotel = array();

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_hoteldetail = new config_hoteldetail('', array('page_widget_id' => $this->page_widget_id));
        if ($config_hoteldetail->widget_title) {
            $this->widget_title = $config_hoteldetail->widget_title;
        }
        if (isset($config_hoteldetail->show_wiget_title)) {
            $this->show_widget_title = $config_hoteldetail->show_wiget_title;
        }
        if (isset($config_hoteldetail->hotel_id)) {
            $this->hotel_id = $config_hoteldetail->hotel_id;
        }
        //
        if ($this->hotel_id) {
            $hotel = TourHotel::model()->findByPk($this->hotel_id);
            $this->hotel = $hotel;
            $this->link = Yii::app()->createUrl('/tour/tourHotel/detail', array(
                'id' => $hotel->id,
                'alias' => $hotel->alias
            ));
        }

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
            'hotel' => $this->hotel,
            'link' => $this->link
        ));
    }

}
