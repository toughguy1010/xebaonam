<?php

class albumsrelation extends WWidget {

    public $limit = 0;
    protected $albums = array();
    protected $view = 'view'; // view of widget
    protected $name = 'albumsrelation';
    protected $album_id = '';
    protected $linkkey = 'media/album/detail';

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }

        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        // Load config
        $config_albumsrelation = new config_albumsrelation('', array('page_widget_id' => $this->page_widget_id));
        if ($config_albumsrelation->widget_title) {
            $this->widget_title = $config_albumsrelation->widget_title;
        }
        if (isset($config_albumsrelation->show_wiget_title)) {
            $this->show_widget_title = $config_albumsrelation->show_wiget_title;
        }
        if ($config_albumsrelation->limit) {
            $this->limit = $config_albumsrelation->limit;
        }
        //
        if ($this->linkkey == ClaSite::getLinkKey()) {
            $this->album_id = Yii::app()->request->getParam('id');
        }
        //
        if ($this->album_id) {
            $album = Albums::model()->findByPk($this->album_id);
            if ($album) {
                $this->albums = Albums::getRelationAlbums($album->cat_id, $this->album_id, array('limit' => $this->limit, '_album_id' => $this->album_id));
            }
        }
        parent::init();
    }

    //
    public function run() {
        $this->render($this->view, array(
            'albums' => $this->albums,
            'album_id' => $this->album_id,
        ));
    }

}
