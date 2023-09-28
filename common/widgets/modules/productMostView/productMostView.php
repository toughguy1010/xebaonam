<?php

// Sản phẩm mới và trong nhóm
class productMostView extends WWidget {

    public $limit = 10;
    protected $name = 'productMostView'; // name of widget
    protected $view = 'view'; // view of widget
    protected $link = '';
    protected $viewed = 0;
    protected $products = array();

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config products most view
        $config_product_most_view = new config_productMostView('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_product_most_view->limit))
            $this->limit = (int) $config_product_most_view->limit;
        if ($config_product_most_view->widget_title)
            $this->widget_title = $config_product_most_view->widget_title;
        if (isset($config_product_most_view->show_wiget_title))
            $this->show_widget_title = $config_product_most_view->show_wiget_title;
        $this->products = Product::getProductMostView(array('limit' => $this->limit));
        // get products most view
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
            'products' => $this->products,
        ));
    }

}
