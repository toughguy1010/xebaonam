<?php

/**
 * Hiển thị những video mới nhất
 */
class videonew extends WWidget {

    public $videos;
    public $limit = 5;
    protected $name = 'videonew'; // name of widget
    protected $view = 'view'; // view of widget
    protected $link = ''; // link to all video

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        $config_videonew = new config_videonew('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_videonew->limit))
            $this->limit = (int) $config_videonew->limit;
        if ($config_videonew->widget_title)
            $this->widget_title = $config_videonew->widget_title;
        if (isset($config_videonew->show_wiget_title))
            $this->show_widget_title = $config_videonew->show_wiget_title;
        // get hot news
        $this->videos = Videos::getVideoInSite(array('limit' => $this->limit));
        //
        $this->link = Yii::app()->createUrl('/media/video/all');
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
            'videos' => $this->videos,
            'link' => $this->link,
        ));
    }

}
