<?php

// Sản phẩm mới và sản phẩm nổi bật
class productNewAndHot extends WWidget {

    public $group_id = null;
    public $limit = 10;
    protected $name = 'productNewAndHot'; // name of widget
    protected $view = 'view'; // view of widget
    protected $products_hot = array();
    protected $products_new = array();
    protected $link = '';

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config products group
        $config_hotproduct = new config_productNewAndHot('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_hotproduct->limit))
            $this->limit = (int) $config_hotproduct->limit;
        if ($config_hotproduct->widget_title)
            $this->widget_title = $config_hotproduct->widget_title;
        if (isset($config_hotproduct->show_wiget_title))
            $this->show_widget_title = $config_hotproduct->show_wiget_title;
        // get hot news
        $this->products_hot = Product::getHotProducts(array('limit' => $this->limit));
        
        // get new products
        $this->products_new = Product::getSetNewProducts(array('limit' => $this->limit));
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
            'products_hot' => $this->products_hot,
            'products_new' => $this->products_new,
            'limit' => $this->limit,
            'link' => $this->link,
        ));
    }

}
