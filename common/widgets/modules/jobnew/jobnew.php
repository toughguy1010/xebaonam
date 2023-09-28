<?php

/**
 * Hiển thị các tin tuyển dụng mói nhất
 */
class jobnew extends WWidget {

    public $jobs = array();
    public $limit = 5;
    protected $name = 'jobnew'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        $config_jobnew = new config_jobnew('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_jobnew->widget_title))
            $this->widget_title = $config_jobnew->widget_title;
        if (isset($config_jobnew->show_wiget_title))
            $this->show_widget_title = $config_jobnew->show_wiget_title;
        if (isset($config_jobnew->limit))
            $this->limit = $config_jobnew->limit;
        //
        //
        // get hot jobs
        $this->jobs = Jobs::getJobInSite(array('limit' => $this->limit));
        //
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
            'jobs' => $this->jobs,
        ));
    }

}
