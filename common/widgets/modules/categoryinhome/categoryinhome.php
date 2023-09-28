<?php

/**
 * Hiển thị chỉ các category được chọn hiển thị ở trang chủ
 */
class categoryinhome extends WWidget {

    public $type = 0; // Loại danh mục hiển thị: Danh mục tin tức hay danh mục sản phẩm
    public $limit = 10;
    protected $data = array();
    protected $name = 'categoryinhome'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_categoryinhome = new config_categoryinhome('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_categoryinhome->limit))
            $this->limit = (int) $config_categoryinhome->limit;
        if ($config_categoryinhome->type)
            $this->type = $config_categoryinhome->type;
        if ($config_categoryinhome->widget_title)
            $this->widget_title = $config_categoryinhome->widget_title;
        if (isset($config_categoryinhome->show_wiget_title))
            $this->show_widget_title = $config_categoryinhome->show_wiget_title;
//        $themename = Yii::app()->theme->name;
//        $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
//        $viewname = 'webroot.themes.' . $sitetypename . '.' . $themename . '.views.modules.' . $this->name . '.view';
//        if ($this->controller->getViewFile($viewname)) {
//            $this->view = $viewname;
//            // get hot news
//            if ($this->type) {
//                switch ($this->type) {
//                    case ClaCategory::CATEGORY_NEWS: {
//                            $this->data = NewsCategories::getCategoryInHome(array('limit' => $this->limit));
//                        }break;
//                    case ClaCategory::CATEGORY_PRODUCT: {
//                            $this->data = ProductCategories::getCategoryInHome(array('limit' => $this->limit));
//                        }break;
//                }
//            }
//        }
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
            // get hot news
            if ($this->type) {
                switch ($this->type) {
                    case ClaCategory::CATEGORY_NEWS: {
                            $this->data = NewsCategories::getCategoryInHome(array('limit' => $this->limit));
                        }break;
                    case ClaCategory::CATEGORY_PRODUCT: {
                            $this->data = ProductCategories::getCategoryInHome(array('limit' => $this->limit));
                        }break;
                }
            }
        }
        parent::init();
    }

    public function run() {
        if ($this->type && $this->limit) {
            $this->render($this->view, array(
                'data' => $this->data,
                'limit' => $this->limit,
            ));
        }
    }

}
