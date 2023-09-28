<?php

// Các sản phẩm mà người dùng đã xem
class productviewed extends WWidget
{

    public $products;
    public $just_buy = false;
    public $most_view = false;
    public $limit = 4;
    protected $name = 'productviewed'; // name of widget
    protected $view = 'view'; // view of widget

    public function init()
    {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_productviewed = new config_productviewed('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_productviewed->limit))
            $this->limit = (int)$config_productviewed->limit;
        if ($config_productviewed->widget_title)
            $this->widget_title = $config_productviewed->widget_title;
        if (isset($config_productviewed->show_wiget_title))
            $this->show_widget_title = $config_productviewed->show_wiget_title;
        if (isset($config_productviewed->just_buy)) {
            $this->just_buy = $config_productviewed->just_buy;
        }
        if ($this->most_view) {
            $this->products = Product::getMostViewProducts(array(
                'limit' => $this->limit,
            ));
        }else if ($this->just_buy) {
            $this->products = Product::getOrderedProducts(array(
                'limit' => $this->limit,
            ));

        } else {
            $this->products = Product::getViewedProducts(array(
                'limit' => $this->limit,
            ));
        }
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

    public function run()
    {
        $this->render($this->view, array(
            'products' => $this->products,
            'limit' => $this->limit,
        ));
    }

}
