<?php

class hotproduct extends WWidget {

    public $products;
    public $limit = 5;
    public $select_all = false;
    protected $name = 'hotproduct'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        $config_hotproduct = new config_hotproduct('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_hotproduct->limit))
            $this->limit = (int) $config_hotproduct->limit;
        if ($config_hotproduct->widget_title)
            $this->widget_title = $config_hotproduct->widget_title;
        if (isset($config_hotproduct->show_wiget_title))
            $this->show_widget_title = $config_hotproduct->show_wiget_title;
        if (isset($config_hotproduct->select_all))
            $this->select_all = $config_hotproduct->select_all;
        if (isset($config_hotproduct->help_text)) {
            $this->help_text = $config_hotproduct->help_text;
        }
        // get hot news
        $this->products = Product::getHotProducts(array('limit' => $this->limit, 'select_all' => $this->select_all));
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
            'help_text' => $this->help_text,
        ));
    }

}
