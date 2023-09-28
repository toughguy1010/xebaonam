<?php

/**
 * Hiển thị chỉ các category được chọn hiển thị ở trang chủ
 */
class destinationinhome extends WWidget {

    public $limit = 10;
    protected $data = array();
    protected $name = 'destinationinhome'; // name of widget
    protected $view = 'view'; // view of widget
    public $show_container_product = 0; // view of widget
    protected $dataCategory = [];
    protected $dataPrice = [];

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_destinationinhome = new config_destinationinhome('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_destinationinhome->limit))
            $this->limit = (int) $config_destinationinhome->limit;
        if ($config_destinationinhome->widget_title)
            $this->widget_title = $config_destinationinhome->widget_title;
        if (isset($config_destinationinhome->show_wiget_title))
            $this->show_widget_title = $config_destinationinhome->show_wiget_title;

        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }

        $this->data = Destinations::getAllDestinationInHome(array('limit' => $this->limit));
        if ($this->data && isset($config_destinationinhome->show_container_product)) {
            foreach ($this->data as $key => $value) {
                $this->data[$key]['products'] = RentProduct::getAllRentProductInDestination($key);
            }
        }
        
        $this->dataPrice = RentProductPrice::getAllDataPrice();
        $this->dataCategory = RentCategories::getAllCategory();

        parent::init();
    }

    public function run() {
        if ($this->limit) {
            $this->render($this->view, array(
                'data' => $this->data,
                'dataPrice' => $this->dataPrice,
                'dataCategory' => $this->dataCategory,
                'limit' => $this->limit,
            ));
        }
    }

}
