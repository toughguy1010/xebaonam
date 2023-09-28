<?php

/**
 * @author hungtm
 */
class lecturers extends WWidget {

    public $lecturers;
    public $limit = 5;
    protected $name = 'lecturers'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        $config_newnews = new config_lecturers('', array('page_widget_id' => $this->page_widget_id));
        $this->widget_title = $config_newnews->widget_title;
        $this->show_widget_title = $config_newnews->show_wiget_title;
        $this->limit = $config_newnews->limit;
        //
        // get course new
        $this->lecturers = Lecturer::getLecturers(array('limit' => $this->limit));
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
            'lecturers' => $this->lecturers,
        ));
    }

}
