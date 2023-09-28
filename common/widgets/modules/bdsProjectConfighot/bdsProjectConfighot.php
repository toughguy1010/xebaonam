<?php

class bdsProjectConfighot extends WWidget {

    public $projects;
    public $limit = 5;
    protected $name = 'bdsProjectConfighot'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        $config_bdsProjectConfighot = new config_bdsProjectConfighot('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_bdsProjectConfighot->limit)) {
            $this->limit = (int) $config_bdsProjectConfighot->limit;
        }
        if ($config_bdsProjectConfighot->widget_title) {
            $this->widget_title = $config_bdsProjectConfighot->widget_title;
        }
        if (isset($config_bdsProjectConfighot->show_wiget_title)) {
            $this->show_widget_title = $config_bdsProjectConfighot->show_wiget_title;
        }
        // get hot hotel
        $this->projects = BdsProjectConfig::getHotProjects(array('limit' => $this->limit));
        
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
            'projects' => $this->projects,
        ));
    }

}
