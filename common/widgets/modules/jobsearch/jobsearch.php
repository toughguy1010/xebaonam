<?php

/**
 * Module filter job
 */
class jobsearch extends WWidget {

    public $limit = 5;
    protected $name = 'jobsearch'; // name of widget
    protected $view = 'view'; // view of widget
    public $trades = array();
    public $locations = array();

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        $config_jobsearch = new config_jobsearch('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_jobsearch->widget_title)) {
            $this->widget_title = $config_jobsearch->widget_title;
        }
        if (isset($config_jobsearch->show_wiget_title)) {
            $this->show_widget_title = $config_jobsearch->show_wiget_title;
        }
        //
        $this->trades = Jobs::getTradesSite();
        $this->locations = Jobs::getLocationsSite();
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
            'trades' => $this->trades,
            'locations' => $this->locations,
        ));
    }

}
