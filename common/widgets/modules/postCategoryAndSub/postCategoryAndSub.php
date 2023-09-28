<?php

/**
 * Lấy danh mục bài viết con và các bài viết của danh mục đó
 */
class postCategoryAndSub extends WWidget {

    public $data = array(); // category info and its listnews
    public $itemslimit = 5; // Giới hạn tin tức của danh mục
    protected $name = 'postCategoryAndSub'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_postCategoryAndSub = new config_postCategoryAndSub('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_postCategoryAndSub->limit)) {
            $this->limit = (int) $config_postCategoryAndSub->limit;
        }
        if ($config_postCategoryAndSub->itemslimit) {
            $this->itemslimit = $config_postCategoryAndSub->itemslimit;
        }
        if ($config_postCategoryAndSub->widget_title) {
            $this->widget_title = $config_postCategoryAndSub->widget_title;
        }
        if (isset($config_postCategoryAndSub->onlyisHot)) {
            $this->onlyisHot = $config_postCategoryAndSub->onlyisHot;
        }
        if (isset($config_postCategoryAndSub->show_wiget_title)) {
            $this->show_widget_title = $config_postCategoryAndSub->show_wiget_title;
        }
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        $this->data['categories'] = array();
        $cat_id = Yii::app()->request->getParam('id', 0);
        if ($cat_id) {
            $category = PostCategories::model()->findByPk($cat_id);
            if ($category) {
                $claCategory = new ClaCategory(array('type' => ClaCategory::CATEGORY_POST, 'create' => true, 'selectFull' => true));
                $claCategory->application = 'public';
                $this->data['categories'] = $claCategory->getSubCategory($cat_id);
                if (isset($this->data['categories']) && $this->data['categories']) {
                    foreach ($this->data['categories'] as $cate) {
                        $posts = Posts::getPostsInCategory($cate['cat_id'], array('limit' => $this->itemslimit));
                        $this->data['categories'][$cate['cat_id']]['posts'] = $posts;
                    }
                }else{
                    $posts = Posts::getPostsInCategory($cat_id, array('limit' => $this->itemslimit));
                    $this->data['categories'][$cat_id]['posts'] = $posts;
                }
            }
        }
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'data' => $this->data,
        ));
    }

}
