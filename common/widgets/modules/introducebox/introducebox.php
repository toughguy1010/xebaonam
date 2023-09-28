<?php

/**
 * 
 * introduce box
 *
 * @author minhbn
 */
class introducebox extends WWidget {

    protected $data = array();
    protected $view = 'view';
    protected $name = 'introducebox';

    public function init() {
        // set name for widget, default is class name
//        $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
//        $themename = Yii::app()->theme->name;
//        $viewname = 'webroot.themes.' . $sitetypename . '.' . $themename . '.views.modules.introducebox.view';
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
        // Load config
        $config_introducebox = new config_introducebox('', array('page_widget_id' => $this->page_widget_id));
        if ($config_introducebox->widget_title)
            $this->widget_title = $config_introducebox->widget_title;
        if (isset($config_introducebox->show_wiget_title))
            $this->show_widget_title = $config_introducebox->show_wiget_title;
        //
        $this->data = SiteIntroduces::getIntroduce();
        //
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'data' => $this->data,
        ));
    }

}
