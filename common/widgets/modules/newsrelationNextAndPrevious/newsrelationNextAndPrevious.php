<?php

class newsrelationNextAndPrevious extends WWidget
{

    public $limit = 0;
    protected $listnews = array();
    protected $view = 'view'; // view of widget
    protected $name = 'newsrelationNextAndPrevious';
    protected $news_id = '';
    protected $linkkey = 'news/news/detail';

    public function init()
    {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        // Load config
        $config_newsrelationNextAndPrevious = new config_newsrelationNextAndPrevious('', array('page_widget_id' => $this->page_widget_id));
        if ($config_newsrelationNextAndPrevious->widget_title)
            $this->widget_title = $config_newsrelationNextAndPrevious->widget_title;
        //
        if (isset($config_newsrelationNextAndPrevious->show_wiget_title))
            $this->show_widget_title = $config_newsrelationNextAndPrevious->show_wiget_title;
        //
        if ($config_newsrelationNextAndPrevious->limit)
            $this->limit = $config_newsrelationNextAndPrevious->limit;

        if ($this->linkkey == ClaSite::getLinkKey())
            $this->news_id = Yii::app()->request->getParam('id');

        //
        $this->listnews['next'] = array();
        $this->listnews['prev'] = array();
        if ($this->news_id) {
            $news = News::model()->findByPk($this->news_id);
            if ($news) {
                //Get Next
                $next = News::getRelationNews($news->news_category_id, $this->news_id, array('news_public_date' => $news->publicdate, 'get_next' => true, 'limit' => $this->limit, '_news_id' => $this->news_id));
                if (count($next)) {
                    $this->listnews['next'] = $next;
                }
                //Get Previous
                $prev = News::getRelationNews($news->news_category_id, $this->news_id, array('news_public_date' => $news->publicdate, 'get_prev' => true, 'limit' => $this->limit, '_news_id' => $this->news_id));
                if (count($prev)) {
                    $this->listnews['prev'] = $prev;
                }
            }
        }
        parent::init();
    }

    public function run()
    {
        $this->render($this->view, array(
            'listnews' => $this->listnews,
            'news_id' => $this->news_id,
        ));
    }

}
