<?php

/**
 * Hiển thị các tin tuyển dụng mói nhất
 */
class joball extends WWidget
{

    public $jobs = array();
    public $totalitem = 0;
    public $limit = 5;
    public $only_hot = 0;
    protected $name = 'joball'; // name of widget
    protected $view = 'view'; // view of widget

    public function init()
    {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        $config_joball = new config_joball('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_joball->widget_title)) {
            $this->widget_title = $config_joball->widget_title;
        }
        if (isset($config_joball->show_wiget_title)) {
            $this->show_widget_title = $config_joball->show_wiget_title;
        }
        if (isset($config_joball->limit)) {
            $this->limit = $config_joball->limit;
        }
        if (isset($config_joball->only_hot)) {
            $this->only_hot = $config_joball->only_hot;
        }
        //
        // get hot jobs

        $order = 'ishot DESC, order ASC, publicdate DESC';
        $this->jobs = Jobs::getJobInSite(array(
            'limit' => $this->limit,
            'order' => $order,
            'only_hot' => $this->only_hot
        ));
        $this->totalitem = Jobs::countJobInSite();
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

    public function run()
    {
        $this->render($this->view, array(
            'jobs' => $this->jobs,
            'totalitem' => $this->totalitem
        ));
    }

}
