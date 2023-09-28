<?php

class supportUser extends WWidget {

    public $limit;
    protected $name = 'supportUser';
    protected $view = 'view';
    protected $data = array(); 

    //
    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        // Load config
        $config_supportUser = new config_supportUser('', array('page_widget_id' => $this->page_widget_id));
        //CVarDumper::dump($config_supportUser);
        if ($config_supportUser->limit) {
            $this->limit = $config_supportUser->limit;
            $this->widget_title = $config_supportUser->widget_title;
            $this->show_widget_title = $config_supportUser->show_wiget_title;
            //
            $support = new SiteUsers();
            
            $this->data = $support->getData($this->limit);
            //
        }
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
            'limit' => $this->limit,
            'data' => $this->data,
        ));
    }

}
