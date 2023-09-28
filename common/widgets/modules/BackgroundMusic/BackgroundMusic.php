<?php

/**
 * @author minhbn
 */
class BackgroundMusic extends WWidget {

    public $hours;
    public $limit = 5;
    protected $name = 'BackgroundMusic'; // name of widget
    protected $view = 'view'; // view of widget
    protected $audio_path = '';
    protected $audio_name = '';
    protected $autoPlay = false;
    protected $repeat = false;
    protected $showControl = false;

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        $siteinfo = Yii::app()->siteinfo;
        //
        $config_BackgroundMusic = new config_BackgroundMusic('', array('page_widget_id' => $this->page_widget_id));
        if ($config_BackgroundMusic) {
            $this->widget_title = $config_BackgroundMusic->widget_title;
            $this->show_widget_title = $config_BackgroundMusic->show_wiget_title;
            //
            if(isset($siteinfo['audio_options']) && $siteinfo['audio_options']){
                $options = json_decode($siteinfo['audio_options'], true);
                $config_BackgroundMusic->attributes = $options;
            }
            //
            $this->autoPlay = $config_BackgroundMusic->autoPlay;
            $this->repeat = $config_BackgroundMusic->repeat;
            $this->showControl = $config_BackgroundMusic->showControl;
        }
        //
        if (isset($siteinfo['audio_path']) && isset($siteinfo['audio_name'])) {
            $this->audio_name = $siteinfo['audio_name'];
            $this->audio_path = $siteinfo['audio_path'];
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
            'audio_path' => $this->audio_path,
            'audio_name' => $this->audio_name,
            'autoPlay' => $this->autoPlay,
            'repeat' => $this->repeat,
            'showControl' => $this->showControl,
        ));
    }

}
