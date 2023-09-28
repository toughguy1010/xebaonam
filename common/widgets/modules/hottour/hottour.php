<?php

class hottour extends WWidget
{

    public $tours;
    public $limit = 5;
    protected $name = 'hottour'; // name of widget
    protected $view = 'view'; // view of widget
    protected $helptext = "";

    public function init()
    {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }

        $config_hottour = new config_hottour('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_hottour->limit)) {
            $this->limit = (int)$config_hottour->limit;
        }
        if ($config_hottour->widget_title) {
            $this->widget_title = $config_hottour->widget_title;
        }
        if (isset($config_hottour->show_wiget_title)) {
            $this->show_widget_title = $config_hottour->show_wiget_title;
        }
        if (isset($config_hottour->helptext)) {
            $this->helptext = $config_hottour->helptext;
        }
        // get hot hotel
        $this->tours = Tour::getHotTours(array('limit' => $this->limit));

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
            'tours' => $this->tours,
            'helptext' => $this->helptext,
        ));
    }

}
