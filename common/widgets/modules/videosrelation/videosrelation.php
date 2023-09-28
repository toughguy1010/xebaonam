<?php

class videosrelation extends WWidget {

    public $limit = 0;
    protected $videos = array();
    protected $view = 'view'; // view of widget
    protected $name = 'videosrelation';
    protected $video_id = '';
    protected $linkkey = 'media/video/detail';

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
        $config_videosrelation = new config_videosrelation('', array('page_widget_id' => $this->page_widget_id));
        if ($config_videosrelation->widget_title) {
            $this->widget_title = $config_videosrelation->widget_title;
        }
        if (isset($config_videosrelation->show_wiget_title)) {
            $this->show_widget_title = $config_videosrelation->show_wiget_title;
        }
        if ($config_videosrelation->limit) {
            $this->limit = $config_videosrelation->limit;
        }
        //
        if ($this->linkkey == ClaSite::getLinkKey()) {
            $this->video_id = Yii::app()->request->getParam('id');
        }
        //
        
        if ($this->video_id) {
            $video = Videos::model()->findByPk($this->video_id);
            if ($video) {
                $this->videos = Videos::getRelationVideos($video->cat_id, $this->video_id, array('limit' => $this->limit, '_video_id' => $this->video_id));
            }
            
        }
        parent::init();
    }

    //
    public function run() {
        $this->render($this->view, array(
            'videos' => $this->videos,
            'video_id' => $this->video_id,
        ));
    }

}
