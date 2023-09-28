<?php

class hotcar extends WWidget {

    public $cars;
    public $limit = 5;
    protected $name = 'hotcar'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        $config_hotcar = new config_hotcar('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_hotcar->limit))
            $this->limit = (int) $config_hotcar->limit;
        if ($config_hotcar->widget_title)
            $this->widget_title = $config_hotcar->widget_title;
        if (isset($config_hotcar->show_wiget_title))
            $this->show_widget_title = $config_hotcar->show_wiget_title;
        // get hot car
        $this->cars = Car::getHotCars(array('limit' => $this->limit));
        
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
        ));
    }

}
