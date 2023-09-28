<?php

class scrollup extends WWidget {

    protected $fromTop = 0;
    protected $scrollTime = 600;
    protected $btnID = 'scrollup';
    protected $view = 'view';
    protected $name = 'scrollup';

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        // Load config
        $config_scrollup = new config_scrollup('', array('page_widget_id' => $this->page_widget_id));
        if ($config_scrollup) {
            $this->show_widget_title = $config_scrollup->show_wiget_title;
            $this->widget_title = $config_scrollup->widget_title;
            $this->fromTop = $config_scrollup->fromTop;
        }
        //
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        //
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'fromTop' => $this->fromTop,
            'btnID' => $this->btnID,
            'scrollTime' => $this->scrollTime,
        ));
    }

}
