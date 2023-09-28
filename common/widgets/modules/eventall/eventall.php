<?php

/* * *
 * Lấy tất cả các khóa học
 */

class eventall extends WWidget {

    public $events;
    public $limit = 10;
    public $totalitem = 0;
    protected $name = 'eventall'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_eventall = new config_eventall('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_eventall->limit))
            $this->limit = (int) $config_eventall->limit;
        if ($config_eventall->widget_title)
            $this->widget_title = $config_eventall->widget_title;
        if (isset($config_eventall->show_wiget_title))
            $this->show_widget_title = $config_eventall->show_wiget_title;
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
        $this->events = Event::getAllEvent(array(
                    'limit' => $this->limit,
                    ClaSite::PAGE_VAR => $page,
        ));
        //
        $this->totalitem = Event::countAllEvent();
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'events' => $this->events,
            'limit' => $this->limit,
            'totalitem' => $this->totalitem,
        ));
    }

}
