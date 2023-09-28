<?php

//Support online
class support extends WWidget {

    public $limit;
    protected $basepath = '';
    protected $name = 'support';
    protected $view = 'view';
    protected $data = array(); // Mảng các loại support online

    //
    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        // Load config
        $config_support = new config_support('', array('page_widget_id' => $this->page_widget_id));
        //CVarDumper::dump($config_support);
        if ($config_support->limit) {
            $this->limit = $config_support->limit;
            $this->widget_title = $config_support->widget_title;
            $this->show_widget_title = $config_support->show_wiget_title;
            //
            $support = new SiteSupport();
            $this->data = $support->getData();
            //
        }
        //
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
            $themename = Yii::app()->theme->name;
            $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
            $this->basepath = 'webroot.themes.' . $sitetypename . '.' . $themename . '.views.modules.' . $this->name;
        }
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'limit' => $this->limit,
            'data' => $this->data,
            'basepath' => $this->basepath,
        ));
    }

}
