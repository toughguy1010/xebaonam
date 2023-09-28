<?php

class shopstorelocation extends WWidget {

    public $shopstorelocation;
    public $limit = 5;
    protected $name = 'shopstorelocation'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        $config_shopstorelocation = new config_shopstorelocation('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_shopstorelocation->limit))
            $this->limit = (int) $config_shopstorelocation->limit;
        if ($config_shopstorelocation->widget_title)
            $this->widget_title = $config_shopstorelocation->widget_title;
        if (isset($config_shopstorelocation->show_wiget_title))
            $this->show_widget_title = $config_shopstorelocation->show_wiget_title;
        // get hot news
        $this->shopstorelocation = ShopStore::getShopstoreLocation(array('limit' => $this->limit));

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
            'shopstore' => $this->shopstorelocation,
        ));
    }

}
