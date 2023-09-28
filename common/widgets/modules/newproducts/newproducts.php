<?php

class newproducts extends WWidget {

    public $products;
    public $limit = 5;
    protected $name = 'newproducts'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        $config_newproducts = new config_newproducts('', array('page_widget_id' => $this->page_widget_id));
        $this->widget_title = $config_newproducts->widget_title;
        $this->show_widget_title = $config_newproducts->show_wiget_title;
        $this->limit = $config_newproducts->limit;
        //
        // get new products
        $this->products = Product::getNewProducts(array('limit' => $this->limit));
        //
//        $themename = Yii::app()->theme->name;
//        $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
//        $viewname = 'webroot.themes.' . $sitetypename . '.' . $themename . '.views.modules.' . $this->name . '.view';
//        if ($this->controller->getViewFile($viewname)) {
//            $this->view = $viewname;
//        }
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
