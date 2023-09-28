<?php

class carall extends WWidget {

    public $cars;
    public $limit = 10;
    public $totalitem = 0;
    protected $name = 'carall'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_carall = new config_carall('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_carall->limit)) {
            $this->limit = (int) $config_carall->limit;
        }
        if ($config_carall->widget_title) {
            $this->widget_title = $config_carall->widget_title;
        }
        if (isset($config_carall->show_wiget_title)) {
            $this->show_widget_title = $config_carall->show_wiget_title;
        }
        //
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page) {
            $page = 1;
        }
        $order = 'position ASC, id DESC';
        //
        $this->cars = Car::getAllCarsPagging(array(
                    'limit' => $this->limit,
                    ClaSite::PAGE_VAR => $page,
                    'order' => $order,
        ));
        $this->totalitem = Car::countAll();
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
            'cars' => $this->cars,
            'limit' => $this->limit,
            'totalitem' => $this->totalitem,
        ));
    }

}
