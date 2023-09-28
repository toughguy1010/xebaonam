<?php

/**
 * get news in the category
 */
class newsIncategory extends WWidget
{
    public $news;
    public $limit = 10;
    public $cat_id = 0;
    public $full = 0;
    public $news_hot = 0;
    public $news_in_cate = 0;
    public $category = null;
    public $child_category = null;
    protected $name = 'newsIncategory'; // name of widget
    protected $view = 'view'; // view of widget
    public $data = array(); //

    public function init()
    {
//        return array();
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_newsIncategory = new config_newsIncategory('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_newsIncategory->limit)) {
            $this->limit = (int)$config_newsIncategory->limit;
        }
        if ($config_newsIncategory->widget_title) {
            $this->widget_title = $config_newsIncategory->widget_title;
        }
        if (isset($config_newsIncategory->show_wiget_title)) {
            $this->show_widget_title = $config_newsIncategory->show_wiget_title;
        }
        if (isset($config_newsIncategory->cat_id)) {
            $this->cat_id = $config_newsIncategory->cat_id;
        }
        // Get All infomation
        if (isset($config_newsIncategory->full)) {
            $this->full = $config_newsIncategory->full;
        }
        // Get news hot
        if (isset($config_newsIncategory->news_hot)) {
            $this->news_hot = $config_newsIncategory->news_hot;
        }
        // Get child cat news
        if (isset($config_newsIncategory->news_in_cate)) {
            $this->news_in_cate = $config_newsIncategory->news_in_cate;
        }

//        $themename = Yii::app()->theme->name;
//        $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
//        $viewname = 'webroot.themes.' . $sitetypename . '.' . $themename . '.views.modules.' . $this->name . '.view';
//        if ($this->controller->getViewFile($viewname)) {
//            $this->view = $viewname;
//            // get hot news
//            $this->news = News::getNewsInCategory($this->cat_id, array('limit' => $this->limit));
//            //
//            $this->category = NewsCategories::model()->findByPk($this->cat_id);
//            $this->category = $this->category->attributes;
//            $this->category['link'] = '';
//            if ($this->category)
//                $this->category['link'] = Yii::app()->createUrl('/news/news/category', array('id' => $this->category['cat_id'], 'alias' => $this->category['alias']));
//        }
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {

            $this->view = $viewname;
            // get hot news
            $this->news = News::getNewsInCategory($this->cat_id, array('limit' => $this->limit, 'full' => $this->full, 'news_hot' => $this->news_hot));
            $this->category = NewsCategories::model()->findByPk($this->cat_id);
            // Get cat news their news
            if ($this->news_in_cate == 1) {
                $claCategory = new ClaCategory(array('create' => true, 'type' => 'news'));
                $claCategory->application = false;
                $cat_child = $claCategory->getSubCategory($this->category->cat_id);
                if (count($cat_child)) {
                    foreach ($cat_child as $cat) {
                        $this->data[$cat['cat_id']] = $cat;
                        $new_in_cate = News::getNewsInCategory($cat['cat_id'], array('limit' => $this->limit, 'news_in_cate' => $this->news_in_cate));
                        $this->data[$cat['cat_id']]['news'] = $new_in_cate;
                    }
                }
            }
            //
            $this->category = $this->category->attributes;
            $this->category['link'] = '';
            if ($this->category)
                $this->category['link'] = Yii::app()->createUrl('/news/news/category', array('id' => $this->category['cat_id'], 'alias' => $this->category['alias']));
//            $this->$child_category = ClaCategory;
        }
        parent::init();
    }

    public function run()
    {
        if ($this->news_in_cate == 1) {
            $this->render($this->view, array(
                'news' => $this->news,
                'category' => $this->category,
                'data' => $this->data
            ));
        } else {
            $this->render($this->view, array(
                'news' => $this->news,
                'category' => $this->category,
            ));
        }
    }
}
