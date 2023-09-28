<?php

class SeServiceAllWidget extends WWidget {

    public $services;
    public $totalitem = 0;
    public $limit = 5;
    protected $name = 'SeServiceAllWidget'; // name of widget
    public $view = 'view'; // view of widget
    public $style;

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        $config_SeServiceAllWidget = new config_SeServiceAllWidget('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_SeServiceAllWidget->limit)) {
            $this->limit = (int) $config_SeServiceAllWidget->limit;
        }
        if ($config_SeServiceAllWidget->widget_title) {
            $this->widget_title = $config_SeServiceAllWidget->widget_title;
        }
        if (isset($config_SeServiceAllWidget->show_wiget_title)) {
            $this->show_widget_title = $config_SeServiceAllWidget->show_wiget_title;
        }
        //
        if (isset($config_SeServiceAllWidget->style)) {
            $this->style = $config_SeServiceAllWidget->style;
        }
        if (isset($config_SeServiceAllWidget->view) && $config_SeServiceAllWidget->view) {
            $this->view = $config_SeServiceAllWidget->view;
        }
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        //
        $this->services = SeServices::getServices(array(
                    'limit' => $this->limit,
                    ClaSite::PAGE_VAR => $page,
        ));
        //
        $this->totalitem = SeServices::getServices(array(), true);
        //
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        } elseif ($this->view != 'view') {
            $this->view = 'view';
        }
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'services' => $this->services,
            'totalitem' => $this->totalitem,
            'limit' => $this->limit,
            'style' => $this->style
        ));
    }

}
