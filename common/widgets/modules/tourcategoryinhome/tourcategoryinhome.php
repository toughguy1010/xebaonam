<?php

/**
 * Hien thi cac danh mục tour được hiển thị ở trang chủ và các tour trong danh mục này
 */
class tourcategoryinhome extends WWidget {

    public $cateinhome = array(); // promotions is show in home
    public $data = array(); // promtion info and its products
    public $limit = 1; // Giới hạn cac chuong trinh khuyen mai o trang chu
    public $itemslimit = 5; // Gioi han san pham hien thi ra
    protected $name = 'tourcategoryinhome'; // name of widget
    protected $view = 'view'; // view of widget
    protected $onlyisHot = 0; // view of ishot

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_tourcategoryinhome = new config_tourcategoryinhome('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_tourcategoryinhome->limit)) {
            $this->limit = (int) $config_tourcategoryinhome->limit;
        }
        if ($config_tourcategoryinhome->itemslimit) {
            $this->itemslimit = $config_tourcategoryinhome->itemslimit;
        }
        if ($config_tourcategoryinhome->widget_title) {
            $this->widget_title = $config_tourcategoryinhome->widget_title;
        }
        if (isset($config_tourcategoryinhome->show_wiget_title)) {
            $this->show_widget_title = $config_tourcategoryinhome->show_wiget_title;
        }
        if (isset($config_tourcategoryinhome->onlyisHot)) {
            $this->onlyisHot = $config_tourcategoryinhome->onlyisHot;
        }
//        $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
//        $themename = Yii::app()->theme->name;
//        $viewname = 'webroot.themes.' . $sitetypename . '.' . $themename . '.views.modules.' . $this->name . '.view';
//        if ($this->controller->getViewFile($viewname)) {
//            $this->view = $viewname;
//            // get categories in home
//            $this->cateinhome = ProductCategories::getCategoryInHome(array('limit' => $this->limit));
//            // Get news in category
//            foreach ($this->cateinhome as $cate) {
//                $this->data[$cate['cat_id']] = $cate;
//                $products = Product::getProductsInCate($cate['cat_id'], array('limit' => $this->itemslimit));
//                $this->data[$cate['cat_id']]['products'] = $products;
//            }
//        }
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
            // get categories in home
            $this->cateinhome = TourCategories::getCategoryInHome(array('limit' => $this->limit));
            // Get news in category

            foreach ($this->cateinhome as $cate) {
                $this->data[$cate['cat_id']] = $cate;
                $tours = Tour::getTourInCategory($cate['cat_id'], array('limit' => $this->itemslimit, 'onlyisHot' => $this->onlyisHot));
                $this->data[$cate['cat_id']]['tours'] = $tours;
            }
        }
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'cateinhome' => $this->cateinhome,
            'itemslimit' => $this->itemslimit,
            'data' => $this->data,
        ));
    }

}
