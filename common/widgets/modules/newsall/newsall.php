<?php

/* * *
 * Lấy tất cả các tin tức trong site ra theo giới hạn
 */

class newsall extends WWidget {

    public $news;
    public $limit = 10;
    public $totalitem = 0;
    protected $name = 'newsall'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_newsall = new config_newsall('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_newsall->limit))
            $this->limit = (int) $config_newsall->limit;
        if ($config_newsall->widget_title)
            $this->widget_title = $config_newsall->widget_title;
        if (isset($config_newsall->show_wiget_title))
            $this->show_widget_title = $config_newsall->show_wiget_title;
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
        $this->news = News::getAllNews(array(
                    'limit' => $this->limit,
                    ClaSite::PAGE_VAR => $page,
        ));
        //
        $this->totalitem = News::countAllNews();
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'news' => $this->news,
            'limit' => $this->limit,
            'totalitem' => $this->totalitem,
        ));
    }

}
