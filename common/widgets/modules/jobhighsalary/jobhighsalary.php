<?php

/**
 * Hiển thị các tin tuyển dụng lương cao
 */
class jobhighsalary extends WWidget {

    public $jobs = array();
    public $limit = 5;
    protected $name = 'jobhighsalary'; // name of widget
    protected $view = 'view'; // view of widget
    public $salary_min = 3000000; // default 3 triệu

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        $config_jobhighsalary = new config_jobhighsalary('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_jobhighsalary->widget_title)) {
            $this->widget_title = $config_jobhighsalary->widget_title;
        }
        if (isset($config_jobhighsalary->show_wiget_title)) {
            $this->show_widget_title = $config_jobhighsalary->show_wiget_title;
        }
        if (isset($config_jobhighsalary->limit)) {
            $this->limit = $config_jobhighsalary->limit;
        }
        if (isset($config_jobhighsalary->salary_min)) {
            $this->salary_min = $config_jobhighsalary->salary_min;
        }
        //
        //
        // get hot jobs
        $this->jobs = Jobs::getJobHighsalary(array(
                    'limit' => $this->limit,
                    'salary_min' => $this->salary_min
        ));
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
