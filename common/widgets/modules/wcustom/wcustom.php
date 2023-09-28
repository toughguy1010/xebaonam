<?php

class wcustom extends WWidget {

    public $siteinfo = null;
    public $widget_id = null;
    public $widget = null;
    protected $view = 'view';
    protected $name = 'wcustom';

    public function init() {
        if (!$this->siteinfo)
            $this->siteinfo = Yii::app()->siteinfo;
        if (!$this->widget) {
            if (!$this->widget_id)
                return false;
            $this->widget = Widgets::getCustomWidgetInfo($this->widget_id);
        }
//        $themename = Yii::app()->theme->name;
//        $sitetypename = ClaSite::getSiteTypeName($this->siteinfo);
//        $viewname = 'webroot.themes.' . $sitetypename . '.' . $themename . '.views.modules.wcustom.view';
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
        return parent::init();
    }

    public function run() {
        if (!count($this->widget))
            return false;
        $this->render($this->view, array(
            'siteinfo' => $this->siteinfo,
            'widget_id' => $this->widget_id,
            'widget' => $this->widget,
        ));
    }

}
