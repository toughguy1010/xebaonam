<?php

/**
 * @author hungtm
 */
class courseNearOpen extends WWidget {

    public $courses;
    public $limit = 5;
    public $show_via_hot_order = null;
    public $use_new_schedule = false; // Sử dụng lịch khai giảng mới - HATV
    protected $name = 'courseNearOpen'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        $config_courseNearOpen = new config_courseNearOpen('', array('page_widget_id' => $this->page_widget_id));
        $this->widget_title = $config_courseNearOpen->widget_title;
        $this->show_widget_title = $config_courseNearOpen->show_wiget_title;
        $this->limit = $config_courseNearOpen->limit;
        if ($config_courseNearOpen->show_via_hot_order) {
            $this->show_via_hot_order = $config_courseNearOpen->show_via_hot_order;
        }
        if ($config_courseNearOpen->use_new_schedule) {
            $this->use_new_schedule = $config_courseNearOpen->use_new_schedule;
        }
        //
        // get course new
        if (!$this->show_via_hot_order) {
            $this->courses = Course::getCourseNearOpen(array('limit' => $this->limit));
        } else {
            $this->courses = Course::getHotAndNearOpen(array('limit' => $this->limit));
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

    public function run() {
        $this->render($this->view, array(
            'courses' => $this->courses,
        ));
    }

}
