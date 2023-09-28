<?php

class relquestion extends WWidget {

    public $questions;
    public $limit = 5;
    protected $name = 'relquestion'; // name of widget
    protected $view = 'view'; // view of widget
    protected $linkkey = 'economy/question/detail';
    protected $link = null;
    protected $question_id = null;

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        $config_relquestion = new config_relquestion('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_relquestion->limit))
            $this->limit = (int) $config_relquestion->limit;
        if ($config_relquestion->widget_title)
            $this->widget_title = $config_relquestion->widget_title;
        if (isset($config_relquestion->show_wiget_title))
            $this->show_widget_title = $config_relquestion->show_wiget_title;

        if (!$this->link)
            $this->link = ClaSite::getFullCurrentUrl();
        if ($this->linkkey == ClaSite::getLinkKey()) {
            $this->question_id = Yii::app()->request->getParam('id');
            $question = QuestionAnswer::model()->findByPk($this->question_id);
        }

        // get hot news
        if ($question) {
            $this->questions = QuestionAnswer::getRelationQuestion($question->type, $this->question_id, array('limit' => $this->limit));
        }
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        parent::init();
    }

    public
            function run() {
        $this->render($this->view, array(
            'questions' => $this->questions,
        ));
    }

}
