<?php

// Các sản phẩm mà người dùng đã xem
class productCompare extends WWidget
{

    public $products;
    public $just_buy = 0;
    public $most_view = 0;
    public $limit = 4;
    protected $name = 'productCompare'; // name of widget
    protected $view = 'view'; // view of widget

    public function init()
    {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_productCompare = new config_productCompare('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_productCompare->limit))
            $this->limit = (int)$config_productCompare->limit;
        if ($config_productCompare->widget_title)
            $this->widget_title = $config_productCompare->widget_title;
        if (isset($config_productCompare->show_wiget_title))
            $this->show_widget_title = $config_productCompare->show_wiget_title;
        if (isset($config_productCompare->just_buy)) {
            $this->just_buy = $config_productCompare->just_buy;
        }

        $this->products = Product::getProductToCompare(array(
            'limit' => $this->limit,
        ));

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
