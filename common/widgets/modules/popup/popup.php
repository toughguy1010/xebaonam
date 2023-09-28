<?php

class popup extends WWidget
{

    public $popups = array();
    protected $name = 'popup';
    protected $view = 'view';
    protected $popupLimit = null; // giới hạn số popup lấy trong nhóm
    protected $enable_start_end_time = 0; // giới hạn số popup lấy trong nhóm

    //
    public function init()
    {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_popup = new config_popup('', array('page_widget_id' => $this->page_widget_id));
        //CVarDumper::dump($config_popup);
        $this->enable_start_end_time = $config_popup->enable_start_end_time;
        $result = array();
        $popups = Popups::getPopups(array('limit' => $config_popup->limit, 'enable_start_end_time' => $config_popup->enable_start_end_time));
        $popups = Popups::filterPopups($popups);
        foreach ($popups as $popup) {
            if(!isset($result[$popup['popup_config']])){
                $result[$popup['popup_config']] = $popup;
            }
        }

        $this->popups = $result;
        //Widget title
        $this->widget_title = $config_popup->widget_title;
        $this->show_widget_title = $config_popup->show_wiget_title;
        // set name for widget, default is class name
//        $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
//        $themename = Yii::app()->theme->name;
//        $viewname = 'webroot.themes.' . $sitetypename . '.' . $themename . '.views.modules.popup.' . $this->view;
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

    public function run()
    {
        $this->render($this->view, array(
            'popups' => $this->popups,
        ));
    }

}
