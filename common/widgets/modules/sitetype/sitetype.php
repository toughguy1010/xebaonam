<?php

class sitetype extends WWidget {

    public $type = 0; // type default
    public $sites = array();
    protected $view = 'view';
    protected $name = 'sitetype';
    protected $limit = null;

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        // Load config
        $config_sitetype = new config_sitetype('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_sitetype->type) && $config_sitetype->type) {
            $this->type = $config_sitetype->type;
            $this->sites = SiteSettings::getSitesByConditions($this->type, array('limit' => $config_sitetype->limit));
            $this->widget_title = $config_sitetype->widget_title;
            $this->show_widget_title = $config_sitetype->show_wiget_title;
        }
        // set name for widget, default is class name
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        //
        //
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'sites' => $this->sites,
        ));
    }

}
