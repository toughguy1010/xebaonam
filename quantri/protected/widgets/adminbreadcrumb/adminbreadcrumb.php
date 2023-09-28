<?php

class adminbreadcrumb extends CWidget {

    public $data = array(); // category info and its listnews
    protected $view = 'view'; // view of widget

    public function init() {
        $this->data = Yii::app()->controller->breadcrumbs;
        if (!$this->data || !count($this->data))
            return false;
        $this->data = array(Yii::t('common', 'homepage') => Yii::app()->homeUrl) + $this->data;
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'data' => $this->data,
        ));
    }

}
