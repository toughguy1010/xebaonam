<?php

/* * *
 * Lấy tất cả các khóa học
 */

class courseall extends WWidget {

    public $course;
    public $limit = 10;
    public $totalitem = 0;
    protected $name = 'courseall'; // name of widget
    protected $view = 'view'; // view of widget
    public $ishot = false; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_courseall = new config_courseall('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_courseall->limit))
            $this->limit = (int) $config_courseall->limit;
        if ($config_courseall->widget_title)
            $this->widget_title = $config_courseall->widget_title;
        if (isset($config_courseall->show_wiget_title))
            $this->show_widget_title = $config_courseall->show_wiget_title;
        if (isset($config_courseall->ishot))
            $this->ishot = $config_courseall->ishot;
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
        // get hot news
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page)
            $page = 1;
        //
        // get hot news
        $this->course = Course::getAllCourse(array(
                    'limit' => $this->limit,
                    'ishot' => $this->ishot,
                    ClaSite::PAGE_VAR => $page,
        ));
        //
        $this->totalitem = Course::countAllCourse();
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'listcourse' => $this->course,
            'limit' => $this->limit,
            'totalitem' => $this->totalitem,
        ));
    }

}
