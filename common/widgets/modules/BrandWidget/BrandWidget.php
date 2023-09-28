<?php

class BrandWidget extends WWidget {

    public $brands;
    public $limit = 5;
    public $ishot = 0;
    protected $name = 'BrandWidget'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        $config_BrandWidget = new config_BrandWidget('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_BrandWidget->limit)) {
            $this->limit = (int) $config_BrandWidget->limit;
        }
        if ($config_BrandWidget->widget_title) {
            $this->widget_title = $config_BrandWidget->widget_title;
        }
        if (isset($config_BrandWidget->show_wiget_title)) {
            $this->show_widget_title = $config_BrandWidget->show_wiget_title;
        }
        // get hot hotel
        $this->brands = Brand::getAllData(array('limit' => $this->limit));
        
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
            'brands' => $this->brands,
        ));
    }

}
