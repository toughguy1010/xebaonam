<?php

class SeStaffWidget extends WWidget {

    public $staffs;
    public $limit = 5;
    public $totalitem = 0;
    public $gender = '';
    public $lang = '';
    public $n = '';
    public $faculty = '';
    public $edu = '';
    protected $name = 'SeStaffWidget'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        $config_SeStaffWidget = new config_SeStaffWidget('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_SeStaffWidget->limit)) {
            $this->limit = (int) $config_SeStaffWidget->limit;
        }
        if ($config_SeStaffWidget->widget_title) {
            $this->widget_title = $config_SeStaffWidget->widget_title;
        }
        if (isset($config_SeStaffWidget->show_wiget_title)) {
            $this->show_widget_title = $config_SeStaffWidget->show_wiget_title;
        }
        //
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page) {
            $page = 1;
        }
        $order = 'order ASC, id DESC';
        // Params Search
        $this->n = Yii::app()->request->getParam('n', '');
        $this->faculty = Yii::app()->request->getParam('faculty', '');
        $this->gender = Yii::app()->request->getParam('gender', '');
        $this->edu = Yii::app()->request->getParam('edu', '');
        $this->lang = Yii::app()->request->getParam('lang', '');
        //
        $this->staffs = SeProviders::getProviders(array(
                    'limit' => $this->limit,
                    ClaSite::PAGE_VAR => $page,
                    'order' => $order,
                    'n' => $this->n,
                    'faculty' => $this->faculty,
                    'gender' => $this->gender,
                    'edu' => $this->edu,
                    'lang' => $this->lang
        ));
        //
        $this->totalitem = SeProviders::countAll(array(
                    'n' => $this->n,
                    'faculty' => $this->faculty,
                    'gender' => $this->gender,
                    'edu' => $this->edu,
                    'lang' => $this->lang
        ));

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
            'staffs' => $this->staffs,
            'limit' => $this->limit,
            'totalitem' => $this->totalitem,
        ));
    }

}
