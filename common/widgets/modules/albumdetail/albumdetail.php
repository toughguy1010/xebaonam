<?php

// Album Detail
class albumdetail extends WWidget {

    public $album_id = null;
    protected $name = 'albumdetail'; // name of widget
    protected $view = 'view'; // view of widget
    protected $link = '';
    public $album = array();
    public $images = array();

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_albumdetail = new config_albumdetail('', array('page_widget_id' => $this->page_widget_id));
        if ($config_albumdetail->widget_title) {
            $this->widget_title = $config_albumdetail->widget_title;
        }
        if (isset($config_albumdetail->show_wiget_title)) {
            $this->show_widget_title = $config_albumdetail->show_wiget_title;
        }
        if (isset($config_albumdetail->album_id)) {
            $this->album_id = $config_albumdetail->album_id;
        }
        //
        if ($this->album_id) {
            $album = Albums::model()->findByPk($this->album_id);
            $this->album = $album;
            $this->images = Albums::getImages($this->album_id);
        }

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
            'album' => $this->album,
            'images' => $this->images
        ));
    }

}
