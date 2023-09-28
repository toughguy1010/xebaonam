<?php

class yahoobox extends WWidget {

    public $yahoos = '';
    protected $name = 'yahoobox'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_yahoobox = new config_yahoobox('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_yahoobox->yahoos)) {
            $this->yahoos = explode(',', $config_yahoobox->yahoos);
        }
        if ($config_yahoobox->widget_title)
            $this->widget_title = $config_yahoobox->widget_title;
        if (isset($config_yahoobox->show_wiget_title))
            $this->show_widget_title = $config_yahoobox->show_wiget_title;
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
            'yahoos' => $this->yahoos,
        ));
    }

}
