<?php

class questionsubmit extends WWidget {

    public $model;
    public $questions;
    public $limit = 5;
    protected $name = 'questionsubmit'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        $config_hotquestion = new config_questionsubmit('', array('page_widget_id' => $this->page_widget_id));

        if ($config_hotquestion->widget_title)
            $this->widget_title = $config_hotquestion->widget_title;
        if (isset($config_hotquestion->show_wiget_title))
            $this->show_widget_title = $config_hotquestion->show_wiget_title;

        // get hot news
        $this->questions = QuestionAnswer::getHotQuestion(array('limit' => $this->limit));
        //
        $this->model = new QuestionAnswer();
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
//            $themename = Yii::app()->theme->name;
//            $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
//            $this->basepath = 'webroot.themes.' . $sitetypename . '.' . $themename . '.views.modules.' . $this->name;
        }
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'questions' => $this->questions,
            'model' => $this->model,
        ));
    }

}
