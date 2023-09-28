<?php

class avatarImageProfile extends WWidget {

    public $data = array();
    protected $view = 'view';
    public $url_return;
    public $id;
    public $only_allow = 0;
    protected $name = 'avatarImageProfile'; // name of widget

    public function init() {
        parent::init();
    }

    public function run() {

        $model = new CourseRegister();
        $model->unsetAttributes();
        $course_id = $this->id;
        $only_allow = $this->only_allow;
        $option_course = Course::getOptionCourse($only_allow);
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        $this->render($this->view, array(
            'model' => $model,
            'option_course' => $option_course,
            'course_id' => $course_id,
            'type' => $only_allow
        ));
    }

}
