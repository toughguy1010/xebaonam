<?php

class consultantall extends WWidget {

    public $lecturers;
    public $limit = 10;
    public $totalitem = 0;
    protected $name = 'consultantall'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_consultantall = new config_consultantall('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_consultantall->limit))
            $this->limit = (int) $config_consultantall->limit;
        if ($config_consultantall->widget_title)
            $this->widget_title = $config_consultantall->widget_title;
        if (isset($config_consultantall->show_wiget_title))
            $this->show_widget_title = $config_consultantall->show_wiget_title;
        //
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page) {
            $page = 1;
        }
        $order = 'order ASC';
        //
        $this->lecturers = Consultant::getAllConsultants(array(
                    'limit' => $this->limit,
                    ClaSite::PAGE_VAR => $page,
                    'order' => $order,
        ));
        $this->totalitem = Consultant::countAll();
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
            'lecturers' => $this->lecturers,
            'limit' => $this->limit,
            'totalitem' => $this->totalitem,
        ));
    }


}
