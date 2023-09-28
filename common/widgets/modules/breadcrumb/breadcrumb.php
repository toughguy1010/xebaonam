<?php

class breadcrumb extends WWidget {

    public $data = array(); // category info and its listnews
    protected $view = 'view'; // view of widget
    protected $name = 'breadcrumb';
    public $removeLast = false;

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        // set name for widget, default is class name
//        $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
//        $themename = Yii::app()->theme->name;
//        $viewname = 'webroot.themes.' . $sitetypename . '.' . $themename . '.views.modules.breadcrumb.view';
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
        $this->data = Yii::app()->controller->breadcrumbs;
        if($this->removeLast){
            array_pop($this->data);
        }
        if (!$this->data || !count($this->data))
            return false;
        $this->data = array(Yii::t('common', 'homepage') => Yii::app()->homeUrl) + $this->data;
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'data' => $this->data,
        ));
    }

}
