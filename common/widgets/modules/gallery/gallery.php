<?php

class gallery extends WWidget {

    public $images = null; 
    public $album_id = null;
    public $style = 'default';
    protected $view = 'view';
    protected $name = 'gallery';
    public function init() {
        // set name for widget, default is class name
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
            
        ));
    }

}
