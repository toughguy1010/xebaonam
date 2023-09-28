<?php

class mapNew extends WWidget {

    public $limit = 0;
    protected $maps;
    protected $view = 'view'; // view of widget
    protected $name = 'mapNew';
    protected $main;
    public $site_config = '';
    private $id = 'map-canvas';

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        // set name for widget, default is class name
//        $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
//        $themename = Yii::app()->theme->name;
//        $viewname = 'webroot.themes.' . $sitetypename . '.' . $themename . '.views.modules.map.view';
//        if ($this->controller->getViewFile($viewname)) {
//            $this->view = $viewname;
//        }
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        // Load config
        $config_map = new config_mapNew('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_map->limit))
            $this->limit = (int) $config_map->limit;
        if ($config_map->widget_title)
            $this->widget_title = $config_map->widget_title;
        if (isset($config_map->show_wiget_title))
            $this->show_widget_title = $config_map->show_wiget_title;
        //
        $this->id = ClaGenerate::getUniqueCode();
        //
        $this->maps = Maps::getMaps(array('limit' => $this->limit));
        $this->main = array_shift($this->maps);
        //
        $this->site_config = SiteSettings::model()->findByPk(Yii::app()->controller->site_id);
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'maps' => $this->maps,
            'limit' => $this->limit,
            'main' => $this->main,
            'id' => $this->id,
            'site_config' => $this->site_config,
        ));
    }

}
