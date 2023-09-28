<?php

class hotRealestateProject extends WWidget {

    public $hotRealestateProject;
    public $limit = 5;
    protected $name = 'hotRealestateProject'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        $config_hotnews = new config_hotRealestateProject('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_hotnews->limit))
            $this->limit = (int) $config_hotnews->limit;
        if ($config_hotnews->widget_title)
            $this->widget_title = $config_hotnews->widget_title;
        if (isset($config_hotnews->show_wiget_title))
            $this->show_widget_title = $config_hotnews->show_wiget_title;

        // get hot news
        $this->hotRealestateProject = RealEstateProject::getHotProject(array('limit' => $this->limit));
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
            'hotRealestateProject' => $this->hotRealestateProject,
        ));
    }

}
