<?php

/**
 * Module filter job
 */
class jobfilter extends WWidget {

    public $limit = 5;
    protected $name = 'jobfilter'; // name of widget
    protected $view = 'view'; // view of widget
    public $trades = array();
    public $locations = array();
    public $degrees = array();
    public $typeofworks = array();

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        $config_jobfilter = new config_jobfilter('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_jobfilter->widget_title)) {
            $this->widget_title = $config_jobfilter->widget_title;
        }
        if (isset($config_jobfilter->show_wiget_title)) {
            $this->show_widget_title = $config_jobfilter->show_wiget_title;
        }
        // ngành nghề id
        $i = Yii::app()->request->getParam('i', 0);
        // tỉnh thành id
        $v = Yii::app()->request->getParam('v', 0);
        //
        $action = Yii::app()->controller->action->id;
        $this->trades = Jobs::getTradesSite(array('i' => $i, 'v' => $v, 'action' => $action));
        $this->locations = Jobs::getLocationsSite(array('i' => $i, 'v' => $v, 'action' => $action));
        $this->degrees = Jobs::getDegreesSite(array('i' => $i, 'v' => $v, 'action' => $action));
        $this->typeofworks = Jobs::getTypeofworksSite(array('i' => $i, 'v' => $v, 'action' => $action));
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
            'trades' => $this->trades,
            'locations' => $this->locations,
            'degrees' => $this->degrees,
            'typeofworks' => $this->typeofworks
        ));
    }

}
