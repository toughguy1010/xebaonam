<?php

class bdsProjectConfigall extends WWidget {

    public $projects;
    public $limit = 10;
    public $totalitem = 0;
    protected $name = 'bdsProjectConfigall'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_bdsProjectConfigall = new config_bdsProjectConfigall('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_bdsProjectConfigall->limit)) {
            $this->limit = (int) $config_bdsProjectConfigall->limit;
        }
        if ($config_bdsProjectConfigall->widget_title) {
            $this->widget_title = $config_bdsProjectConfigall->widget_title;
        }
        if (isset($config_bdsProjectConfigall->show_wiget_title)) {
            $this->show_widget_title = $config_bdsProjectConfigall->show_wiget_title;
        }
        //
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page) {
            $page = 1;
        }
        $order = 'order ASC ,id DESC';
        //
        $this->projects = BdsProjectConfig::getAllprojects(array(
                    'limit' => $this->limit,
                    ClaSite::PAGE_VAR => $page,
                    'order' => $order,
        ));
        $this->totalitem = BdsProjectConfig::countAll();

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
            'projects' => $this->projects,
            'limit' => $this->limit,
            'totalitem' => $this->totalitem,
        ));
    }

}
