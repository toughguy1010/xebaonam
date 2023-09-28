<?php

/**
 * Hiển thị các album mới nhất của trang web
 */
class albumnew extends WWidget {

    public $albums = array();
    public $limit = 5;
    protected $name = 'albumnew'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        $config_albumnew = new config_albumnew('', array('page_widget_id' => $this->page_widget_id));
        $this->widget_title = $config_albumnew->widget_title;
        $this->show_widget_title = $config_albumnew->show_wiget_title;
        $this->limit = $config_albumnew->limit;
        //
        // get hot albums
        $this->albums = Albums::getAllAlbum(array('limit' => $this->limit));
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
            'albums' => $this->albums,
        ));
    }

}
