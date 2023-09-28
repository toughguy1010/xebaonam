<?php

class imageInAlbum extends WWidget {

    public $albums;
    public $limit = 5;
    protected $name = 'imageInAlbum'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        $config_albumshot = new config_imageInAlbum('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_albumshot->limit))
            $this->limit = (int) $config_albumshot->limit;
        if ($config_albumshot->widget_title)
            $this->widget_title = $config_albumshot->widget_title;
        if (isset($config_albumshot->show_wiget_title))
            $this->show_widget_title = $config_albumshot->show_wiget_title;
        // get hot news
        $this->albums = Albums::getAlbumshot(array('limit' => $this->limit));

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
            'albums' => $this->albums,
        ));
    }

}
