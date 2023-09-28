<?php

/**
 * Lấy các products được set là isnew trong bảng products
 */
class productsetnew extends WWidget {

    public $limit = 0;
    public $getCategory = 0;
    protected $products = array();
    protected $view = 'view'; // view of widget
    protected $name = 'productsetnew'; // name of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        // Load config
        $config_productsetnew = new config_productsetnew('', array('page_widget_id' => $this->page_widget_id));
        if ($config_productsetnew->widget_title)
            $this->widget_title = $config_productsetnew->widget_title;
        if (isset($config_productsetnew->show_wiget_title))
            $this->show_widget_title = $config_productsetnew->show_wiget_title;
        if ($config_productsetnew->limit)
            $this->limit = $config_productsetnew->limit;
        if ($config_productsetnew->getCategory)
            $this->getCategory = $config_productsetnew->getCategory;
        // get new products
        $this->products = Product::getSetNewProducts(array('limit' => $this->limit,'getCategory'=>$this->getCategory));
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

    //
    public function run() {
        $this->render($this->view, array(
            'products' => $this->products,
        ));
    }

}
