<?php

class newsrelation extends WWidget {

    public $limit = 0;
    protected $listnews = array();
    protected $view = 'view'; // view of widget
    protected $name = 'newsrelation';
    protected $news_id = '';
    protected $linkkey = 'news/news/detail';
    protected $linkkey2 = 'bds/bdsProjectConfig/newsdetail';

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        // set name for widget, default is class name
//        $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
//        $themename = Yii::app()->theme->name;
//        $viewname = 'webroot.themes.' . $sitetypename . '.' . $themename . '.views.modules.newsrelation.view';
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
        $config_newsrelation = new config_newsrelation('', array('page_widget_id' => $this->page_widget_id));
        if ($config_newsrelation->widget_title)
            $this->widget_title = $config_newsrelation->widget_title;
        if (isset($config_newsrelation->show_wiget_title))
            $this->show_widget_title = $config_newsrelation->show_wiget_title;
        if ($config_newsrelation->limit)
            $this->limit = $config_newsrelation->limit;
        //
        if ($this->linkkey == ClaSite::getLinkKey() || $this->linkkey2 == ClaSite::getLinkKey() )
            $this->news_id = Yii::app()->request->getParam('id');
        //
        if ($this->news_id) {
            $news = News::model()->findByPk($this->news_id);
            if ($news) {
                $this->listnews = News::getRelationNews($news->news_category_id, $this->news_id, array('limit' => $this->limit, '_news_id' => $this->news_id));
            }
        }
        parent::init();
    }

    public
            function run() {
        $this->render($this->view, array(
            'listnews' => $this->listnews,
            'news_id' => $this->news_id,
        ));
    }

}
