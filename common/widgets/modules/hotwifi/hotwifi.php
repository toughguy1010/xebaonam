<?php

class hotwifi extends WWidget {

    public $products;
    public $limit = 5;
    public $select_all = false;
    protected $name = 'hotwifi'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        $config_hotwifi = new config_hotwifi('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_hotwifi->limit))
            $this->limit = (int) $config_hotwifi->limit;
        if ($config_hotwifi->widget_title)
            $this->widget_title = $config_hotwifi->widget_title;
        if (isset($config_hotwifi->show_wiget_title))
            $this->show_widget_title = $config_hotwifi->show_wiget_title;
        if (isset($config_hotwifi->select_all))
            $this->select_all = $config_hotwifi->select_all;
        // get hot news
        $this->products = RentProduct::getHotRentProduct(array('limit' => $this->limit, 'select_all' => $this->select_all ));
//        $themename = Yii::app()->theme->name;
//        $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
//        $viewname = 'webroot.themes.' . $sitetypename . '.' . $themename . '.views.modules.' . $this->name . '.view';
//        if ($this->controller->getViewFile($viewname)) {
//            $this->view = $viewname;
//        }
//        echo "<pre>";
//        print_r( $this->products);
//        echo "</pre>";
//        die();
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
            'products' => $this->products,
        ));
    }

}
