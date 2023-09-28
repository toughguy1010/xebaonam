<?php

/**
 * Hien thi cac danh mục sản phẩm được hiển thị ở trang chủ và các sản phẩm trong danh mục này
 */
class videoscategoryinhome extends WWidget
{

    public $cateinhome = array(); // promotions is show in home
    public $data = array(); // promtion info and its products
    public $limit = 1; // Giới hạn cac chuong trinh khuyen mai o trang chu
    public $itemslimit = 5; // Gioi han san pham hien thi ra
    protected $name = 'videoscategoryinhome'; // name of widget
    protected $view = 'view'; // view of widget
    protected $onlyisHot = 0; // view of ishot

    public function init()
    {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_videoscategoryinhome = new config_videoscategoryinhome('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_videoscategoryinhome->limit)) {
            $this->limit = (int)$config_videoscategoryinhome->limit;
        }
        if ($config_videoscategoryinhome->itemslimit) {
            $this->itemslimit = $config_videoscategoryinhome->itemslimit;
        }
        if ($config_videoscategoryinhome->widget_title) {
            $this->widget_title = $config_videoscategoryinhome->widget_title;
        }
        if (isset($config_videoscategoryinhome->show_wiget_title)) {
            $this->show_widget_title = $config_videoscategoryinhome->show_wiget_title;
        }
        if (isset($config_videoscategoryinhome->onlyisHot)) {
            $this->onlyisHot = $config_videoscategoryinhome->onlyisHot;
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
        }
        $this->cateinhome = VideosCategories::getCategoryInHome(array('limit' => $this->limit));
        // Get news in category

        foreach ($this->cateinhome as $cate) {
            $this->data[$cate['cat_id']] = $cate;
            $videos = Videos::getVideosInCategory($cate['cat_id'], array('limit' => $this->itemslimit, 'onlyisHot' => $this->onlyisHot));

            $this->data[$cate['cat_id']]['videos'] = $videos;
        }
        parent::init();
    }

    public function run()
    {
        $this->render($this->view, array(
            'cateinhome' => $this->cateinhome,
            'itemslimit' => $this->itemslimit,
            'data' => $this->data,
        ));
    }

}
