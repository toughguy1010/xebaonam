<?php

/**
 * @author hungtm
 */
class MapIframe extends WWidget {

    public $iframe_map;
    public $limit = 5;
    public $width = 0;
    public $height = 0;
    protected $name = 'MapIframe'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        $config_MapIframe = new config_MapIframe('', array('page_widget_id' => $this->page_widget_id));
        $this->widget_title = $config_MapIframe->widget_title;
        $this->show_widget_title = $config_MapIframe->show_wiget_title;
        $this->width = $config_MapIframe->width;
        $this->height = $config_MapIframe->height;
        //
        // get course new
        $this->iframe_map = Yii::app()->siteinfo['iframe_map'];
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
            'width' => $this->width,
            'height' => $this->height,
            'iframe_map' => $this->iframe_map
        ));
    }

}
