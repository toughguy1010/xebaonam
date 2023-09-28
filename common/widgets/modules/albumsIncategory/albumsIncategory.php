<?php

/**
 * get album in the category
 */
class albumsIncategory extends WWidget {

    public $albums;
    public $limit = 10;
    public $cat_id = 0;
    public $category = null;
    protected $name = 'albumsIncategory'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_albumsIncategory = new config_albumsIncategory('', array('page_widget_id' => $this->page_widget_id));
        
        if (isset($config_albumsIncategory->limit)) {
            $this->limit = (int) $config_albumsIncategory->limit;
        }
        if ($config_albumsIncategory->widget_title) {
            $this->widget_title = $config_albumsIncategory->widget_title;
        }
        if (isset($config_albumsIncategory->show_wiget_title)) {
            $this->show_widget_title = $config_albumsIncategory->show_wiget_title;
        }
        if (isset($config_albumsIncategory->cat_id)) {
            $this->cat_id = $config_albumsIncategory->cat_id;
        }
        //
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
            // get album in category
        }
        $this->albums = Albums::getAlbumsInCategory($this->cat_id, array('limit' => $this->limit));
        //
        $this->category = AlbumsCategories::model()->findByPk($this->cat_id);
        $this->category = $this->category->attributes;
        $this->category['link'] = '';
        if ($this->category){
            $this->category['link'] = Yii::app()->createUrl('/media/album/category', array('id' => $this->category['cat_id'], 'alias' => $this->category['alias']));
        }
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'albums' => $this->albums,
            'category' => $this->category,
        ));
    }

}
