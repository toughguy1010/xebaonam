<?php

/**
 * Hiển thị các tin tuyển dụng mói nhất
 */
class jobrelation extends WWidget {

    public $jobs = array();
    public $limit = 5;
    protected $name = 'jobrelation'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        $config_jobrelation = new config_jobrelation('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_jobrelation->widget_title)) {
            $this->widget_title = $config_jobrelation->widget_title;
        }
        if (isset($config_jobrelation->show_wiget_title)) {
            $this->show_widget_title = $config_jobrelation->show_wiget_title;
        }
        if (isset($config_jobrelation->limit)) {
            $this->limit = $config_jobrelation->limit;
        }
        // get jobs relation
        $this->jobs = Jobs::getJobRelations(array('limit' => $this->limit));
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
            'jobs' => $this->jobs,
        ));
    }

}
