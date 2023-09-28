<?php

/**
 * Hiển thị các ảnh mới nhất của web(không giới hạn trong album nào)
 */
class imagenew extends WWidget {

    public $images = array();
    public $limit = 5;
    protected $link = '';
    protected $name = 'imagenew'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        $config_imagenew = new config_imagenew('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_imagenew->widget_title))
            $this->widget_title = $config_imagenew->widget_title;
        if (isset($config_imagenew->show_wiget_title))
            $this->show_widget_title = $config_imagenew->show_wiget_title;
        if (isset($config_imagenew->limit))
            $this->limit = $config_imagenew->limit;
        // get hot images
        $this->images = Images::getImagesInSite(array('limit' => $this->limit));
        //
        $this->link = Yii::app()->createUrl('/media/album/all');
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
            'images' => $this->images,
            'link' => $this->link,
        ));
    }

}
