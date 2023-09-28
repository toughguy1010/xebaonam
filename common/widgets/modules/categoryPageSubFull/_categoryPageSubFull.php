<?php

class categoryPageSubFull extends WWidget
{
    public $type = 'product'; // Loại danh mục hiển thị: Danh mục tin tức hay danh mục sản phẩm
    public $data = array();
    protected $view = 'view';
    protected $name = 'categoryPageSubFull';
    protected $linkkey = 'news/news/detail';
    protected $news_id = '';

    public function init()
    {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }

        // Load config
        $config_category_page_sub_full = new config_categoryPageSubFull('', array('page_widget_id' => $this->page_widget_id));
        if ($config_category_page_sub_full) {
            $this->widget_title = $config_category_page_sub_full->widget_title;
        }
        if ($config_category_page_sub_full->type)
            $this->type = $config_category_page_sub_full->type;

        // set name for widget, default is class name
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));

        if ($viewname != '') {
            $this->view = $viewname;
        }

        $cat_id = Yii::app()->request->getParam('id', 0);

        $categoryClass = new ClaCategory(array('type' => ClaCategory::CATEGORY_NEWS, 'create' => true));
        $categoryClass->application = 'public';
        $track = $categoryClass->saveTrack($cat_id);
        $track = array_reverse($track);
        if (count($track) > 0) {
            $root_cate = $track[0];
            $cat_id = $root_cate;
        }

        if ($this->linkkey == ClaSite::getLinkKey()) {
            $this->news_id = Yii::app()->request->getParam('id');
        }
        if ($this->news_id) {
            $news = News::model()->findByPk($this->news_id);
            if ($news) {
                $cat_id = $news['news_category_id'];
                $categoryClass = new ClaCategory(array('type' => ClaCategory::CATEGORY_NEWS, 'create' => true));
                $categoryClass->application = 'public';
                $track = $categoryClass->saveTrack($news->news_category_id);
                $track = array_reverse($track);
                if (count($track) > 0) {
                    $root_cate = $track[0];
                }
            }
        }


        if ($this->type) {
            switch ($this->type) {
                case ClaCategory::CATEGORY_NEWS: {
                    $category = NewsCategories::model()->findByPk($cat_id);
                    $category_model = new ClaCategory(array('type' => $this->type, 'create' => true));
                    $category_model->application = 'public';
                    $data_child = $category_model->createArrayCategory($root_cate);
                    if ($category) {
                        $this->data['category'] = $category;
                        $this->data['children_category'] = $data_child;
                    }
                }
                    break;
                case ClaCategory::CATEGORY_PRODUCT: {
                    $category = ProductCategories::model()->findByPk($cat_id);
                    $model_cla_category = new ClaCategory(array('type' => $this->type, 'create' => true));
                    $model_cla_category->application = false;
                    if ($category) {
                        $this->data['category'] = $category;
                        $this->data['children_category'] = $model_cla_category->getSubCategory($cat_id);
                    }
                    if (count($this->data['children_category']) === 0) {
                        $category2 = ProductCategories::model()->findByPk($category['cat_parent']);
                        if ($category2) {
                            $this->data['category'] = $category2;
                            $this->data['children_category'] = $model_cla_category->getSubCategory($category2['cat_id']);
                            $this->data['children_category'][$cat_id]['active'] = 1;
                        }
                    }
                }
                    break;
            }
        }
        parent::init();
    }

    public function run()
    {
        $this->render($this->view, array(
            'data' => $this->data,
        ));
    }

}


