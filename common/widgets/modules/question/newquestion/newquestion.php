<?php

class newquestion extends WWidget
{

    public $questions;
    public $limit = 5;
    protected $name = 'newquestion'; // name of widget
    protected $view = 'view'; // view of widget

    public function init()
    {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        $config_newquestion = new config_newquestion('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_newquestion->limit))
            $this->limit = (int)$config_newquestion->limit;
        if ($config_newquestion->widget_title)
            $this->widget_title = $config_newquestion->widget_title;
        if (isset($config_newquestion->show_wiget_title))
            $this->show_widget_title = $config_newquestion->show_wiget_title;

        // get hot news
        $this->questions = QuestionAnswer::getNewQuestion(array('limit' => $this->limit));

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
            'questions' => $this->questions,
        ));
    }

}
