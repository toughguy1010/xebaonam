<?php

class SeServiceWidget extends WWidget {

    public $services;
    public $limit = 5;
    public $ishot = 0;
    protected $name = 'SeServiceWidget'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        $config_SeServiceWidget = new config_SeServiceWidget('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_SeServiceWidget->limit)) {
            $this->limit = (int) $config_SeServiceWidget->limit;
        }
        if ($config_SeServiceWidget->widget_title) {
            $this->widget_title = $config_SeServiceWidget->widget_title;
        }
        if (isset($config_SeServiceWidget->show_wiget_title)) {
            $this->show_widget_title = $config_SeServiceWidget->show_wiget_title;
        }
        if(isset($config_SeServiceWidget->ishot)) {
            $this->ishot = $config_SeServiceWidget->ishot;
        }
        // get hot hotel
//        $this->services = BdsProjectConfig::getHotProjects(array('limit' => $this->limit));
        $this->services = SeServices::getServices(array('limit' => $this->limit, 'ishot' => $this->ishot));
        
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
            'services' => $this->services,
        ));
    }

}
