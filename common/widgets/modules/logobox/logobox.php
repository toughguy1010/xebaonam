<?php

class logobox extends WWidget {

    protected $logo = '';
    protected $title = '';
    protected $method = 'get';
    protected $view = 'view';
    protected $name = 'logobox';

    public function init() {
        // Load config
        $config_logobox = new config_logobox('', array('page_widget_id' => $this->page_widget_id));
        if ($config_logobox) {
            $this->widget_title = $config_logobox->widget_title;
        }
        //
        $this->logo = Yii::app()->siteinfo['site_logo'];
        $this->title = Yii::app()->siteinfo['site_title'];
        // set name for widget, default is class name
//        $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
//        $themename = Yii::app()->theme->name;
//        $viewname = 'webroot.themes.' . $sitetypename . '.' . $themename . '.views.modules.logobox.' . $this->view;
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
        //
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'logo' => $this->logo,
            'title' => $this->title,
        ));
    }

}
