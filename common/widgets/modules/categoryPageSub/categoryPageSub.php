<?php

class categoryPageSub extends WWidget
{
    public $type = 'product'; // Loại danh mục hiển thị: Danh mục tin tức hay danh mục sản phẩm
    public $data = array();
    protected $view = 'view';
    protected $name = 'categoryPageSub';
    protected $linkkey = 'news/news/detail';
    protected $product_id = '';

    public function init()
    {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }

        // Load config
        $config_category_page_sub = new config_categoryPageSub('', array('page_widget_id' => $this->page_widget_id));
        if ($config_category_page_sub) {
            $this->widget_title = $config_category_page_sub->widget_title;
        }
        if ($config_category_page_sub->type)
            $this->type = $config_category_page_sub->type;
        $this->show_widget_title = $config_category_page_sub->show_wiget_title;
        // set name for widget, default is class name
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));

        if ($viewname != '') {
            $this->view = $viewname;
        }

        $cat_id = Yii::app()->request->getParam('id', 0);
        if ($this->linkkey == ClaSite::getLinkKey()) {
            $this->product_id = Yii::app()->request->getParam('id');
        }
//        if ($this->product_id) {
//            $product = News::model()->findByPk($this->product_id);
//            if ($product) {
//                $categoryClass = new ClaCategory(array('type' => ClaCategory::CATEGORY_NEWS, 'create' => true));
//                $categoryClass->application = 'public';
//                $track = $categoryClass->saveTrack($product->news_category_id);
//                $track = array_reverse($track);
//            }
//        }

//        $categoryClass = new ClaCategory(array('type' => ClaCategory::CATEGORY_NEWS, 'create' => true));
//        $categoryClass->application = 'public';
//        $track = $categoryClass->saveTrack($cat_id);
//        $track = array_reverse($track);

        if ($this->type) {
            switch ($this->type) {
                case ClaCategory::CATEGORY_NEWS: {
                    $model_cla_category = new ClaCategory(array('type' => $this->type, 'create' => true));
                    $model_cla_category->application = false;
                    //$category = NewsCategories::model()->findByPk($cat_id);
                    $category = $model_cla_category->getItem($cat_id);
                    if ($category) {
                        $this->data['category'] = $category;
                        $this->data['children_category'] = $model_cla_category->getSubCategory($cat_id);
                    }
                    if (count($this->data['children_category']) === 0) {
                        //$category2 = NewsCategories::model()->findByPk($category['cat_parent']);
                        $category2 = $model_cla_category->getItem($category['cat_parent']);
                        if ($category2) {
                            $this->data['category'] = $category2;
                            $this->data['children_category'] = $model_cla_category->getSubCategory($category2['cat_id']);
                            $this->data['children_category'][$cat_id]['active'] = 1;
                        }
                    }
                }
                    break;
                case ClaCategory::CATEGORY_PRODUCT: {
                    $model_cla_category = new ClaCategory(array('type' => $this->type, 'create' => true));
                    $model_cla_category->application = false;
                    $category = $model_cla_category->getItem($cat_id);
                    //$category = ProductCategories::model()->findByPk($cat_id);
                    if ($category) {
                        $this->data['category'] = $category;
                        $this->data['children_category'] = $model_cla_category->getSubCategory($cat_id);
                    }
                    if (count($this->data['children_category']) === 0) {
                        $category2 = $model_cla_category->getItem($category['cat_parent']);
                        //$category2 = ProductCategories::model()->findByPk($category['cat_parent']);
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


