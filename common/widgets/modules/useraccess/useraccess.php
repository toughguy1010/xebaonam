<?php

/**
 * Description of useraccess
 *
 * @author minhbn
 */
class useraccess extends WWidget {

    public $showonline = 0; // Hiển thị số người online hay không
    protected $view = 'view';
    protected $name = 'useraccess';
    protected $totalAccess = 1;
    protected $online = 1;
    protected $today = 1;
    protected $member = array();
    protected $guest = 0;

    //
    public function init() {
        // Load config
        $config_useraccess = new config_useraccess('', array('page_widget_id' => $this->page_widget_id));
        if ($config_useraccess) {
            $this->showonline = $config_useraccess->showonline;
            $this->widget_title = $config_useraccess->widget_title;
            $this->show_widget_title = $config_useraccess->show_wiget_title;
        }
        //
        $userAccess = new ClaUserAccess();
        $statistic = $userAccess->statistic($this->showonline);
        if (isset($statistic['totalAccess']) && $statistic['totalAccess'])
            $this->totalAccess = $statistic['totalAccess'];

        if ($this->showonline) {
            if (isset($statistic['online']) && $statistic['online'])
                $this->online = $statistic['online'];
            if (isset($statistic['today']) && $statistic['today'])
                $this->today = $statistic['today'];
            if (isset($statistic['member']) && $statistic['member'])
                $this->member = $statistic['member'];
            if (isset($statistic['guest']) && $statistic['guest'])
                $this->guest = $statistic['guest'];
        }
        // set name for widget, default is class name
//        $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
//        $themename = Yii::app()->theme->name;
//        $viewname = 'webroot.themes.' . $sitetypename . '.' . $themename . '.views.modules.useraccess.' . $this->view;
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
            'showonline' => $this->showonline,
            'totalAccess' => $this->totalAccess,
            'online' => $this->online,
            'today' => $this->today,
            'member' => $this->member,
            'guest' => $this->guest,
        ));
    }

}
