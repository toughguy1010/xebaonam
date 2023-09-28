<?php

/**
 * @author hungtm
 */
class BusinessHour extends WWidget {

    public $hours;
    public $limit = 5;
    protected $name = 'BusinessHour'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        $config_BusinessHour = new config_BusinessHour('', array('page_widget_id' => $this->page_widget_id));
        $this->widget_title = $config_BusinessHour->widget_title;
        $this->show_widget_title = $config_BusinessHour->show_wiget_title;
        //
        // get business hours
        $this->hours = ClaService::getBusinessHours(Yii::app()->controller->site_id);
        //
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
            'hours' => $this->hours
        ));
    }

}
