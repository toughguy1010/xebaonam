<?php

/**
 * @author hungtm
 */
class registerForm extends WWidget
{

    public $model;
    public $limit = 5;
    public $action = '';
//    public $register_event = null;
    public $register_event = null;
    protected $name = 'registerForm'; // name of widget
    protected $view = 'view'; // view of widget

    public function init()
    {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        $config_registerform = new config_registerForm('', array('page_widget_id' => $this->page_widget_id));
        $this->widget_title = $config_registerform->widget_title;
        $this->show_widget_title = $config_registerform->show_wiget_title;
        $this->limit = $config_registerform->limit;
        if ($config_registerform->register_event) {
            $this->register_event = $config_registerform->register_event;
        }
        //
        // get course new
//        if (!$this->register_event) {
//            $this->model = Course::getCourseNearOpen(array('limit' => $this->limit));
//        } else {
//            $this->model = Course::getHotAndNearOpen(array('limit' => $this->limit));
//        }
        $this->model = new Users('signup');
        if ($this->register_event) {
            $this->action = Yii::app()->createUrl('login/login/signupEvent');
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

    public function run()
    {
        $this->render($this->view, array(
            'model' => $this->model,
            'action' => $this->action,
        ));
    }

}
