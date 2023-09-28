<?php

class hotquestion extends WWidget {

    public $questions;
    public $limit = 5;
    protected $name = 'hotquestion'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        $config_hotquestion = new config_hotquestion('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_hotquestion->limit))
            $this->limit = (int) $config_hotquestion->limit;
        if ($config_hotquestion->widget_title)
            $this->widget_title = $config_hotquestion->widget_title;
        if (isset($config_hotquestion->show_wiget_title))
            $this->show_widget_title = $config_hotquestion->show_wiget_title;

        // get hot news
        $this->questions = QuestionAnswer::getHotQuestion(array('limit' => $this->limit));
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
            'questions' => $this->questions,
        ));
    }

}
