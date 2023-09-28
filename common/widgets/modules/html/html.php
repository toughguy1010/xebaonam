<?php

class html extends WWidget {

    public $html = '';
    protected $view = 'view';
    protected $name = 'html';

    public function init() {
        // Load config
        $config_html = new config_html('', array('page_widget_id' => $this->page_widget_id));
        if ($config_html->html) {
            $this->html = $config_html->html;
            $this->widget_title = $config_html->widget_title;
            $this->show_widget_title = $config_html->show_wiget_title;
        }
        // set name for widget, default is class name
//         $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
//        $themename = Yii::app()->theme->name;
//        $viewname = 'webroot.themes.' . $sitetypename . '.' . $themename . '.views.modules.html.' . $this->view;
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
            'html' => $this->html,
        ));
    }

}
