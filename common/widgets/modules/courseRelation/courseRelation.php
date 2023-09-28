<?php

class courseRelation extends WWidget {

    public $limit = 0;
    protected $listcourse = array();
    protected $view = 'view'; // view of widget
    protected $name = 'courseRelation';
    protected $course_id = '';
    protected $linkkey = 'economy/course/detail';

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        // Load config
        $config_courseRelation = new config_courseRelation('', array('page_widget_id' => $this->page_widget_id));
        if ($config_courseRelation->widget_title) {
            $this->widget_title = $config_courseRelation->widget_title;
        }
        if (isset($config_courseRelation->show_wiget_title)) {
            $this->show_widget_title = $config_courseRelation->show_wiget_title;
        }
        if ($config_courseRelation->limit) {
            $this->limit = $config_courseRelation->limit;
        }
        //
        if ($this->linkkey == ClaSite::getLinkKey()) {
            $this->course_id = Yii::app()->request->getParam('id');
        }
        //
        if ($this->course_id) {
            $course = Course::model()->findByPk($this->course_id);
            if ($course) {
                $this->listcourse = Course::getCourseRelation($course->cat_id, $this->course_id, array('limit' => $this->limit));
            }
        }
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'listcourse' => $this->listcourse,
            'course_id' => $this->course_id,
        ));
    }

}
