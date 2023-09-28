<?php

// Sản phẩm mới và trong nhóm
class productCategoryWithBackground extends WWidget {

    public $cateinhome = array(); // promotions is show in home
    public $data = array(); // promtion info and its products
    public $limit = 1; // Giới hạn cac chuong trinh khuyen mai o trang chu
    public $itemslimit = 5; // Gioi han san pham hien thi ra
    protected $name = 'productCategoryWithBackground'; // name of widget
    protected $view = 'view'; // view of widget
    public $children_category = array();

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_product_category_with_background = new config_productCategoryWithBackground('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_product_category_with_background->limit))
            $this->limit = (int) $config_product_category_with_background->limit;
        if ($config_product_category_with_background->itemslimit)
            $this->itemslimit = $config_product_category_with_background->itemslimit;
        if ($config_product_category_with_background->widget_title)
            $this->widget_title = $config_product_category_with_background->widget_title;
        if (isset($config_product_category_with_background->show_wiget_title))
            $this->show_widget_title = $config_product_category_with_background->show_wiget_title;

        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        $this->cateinhome = ProductCategories::getCategoryInHome(array('limit' => $this->limit));
//        echo "<pre>";
//        print_r( $this->cateinhome );
//        echo "</pre>";
//        die();        
// Get news in category
        $claCategory = new ClaCategory(array('create' => true, 'type' => 'product'));
        $claCategory->application = false;
        if (true) {
            foreach ($this->cateinhome as $cate) {
                $this->data[$cate['cat_id']] = $cate;
                $products = Product::getProductsInCate($cate['cat_id'], array('limit' => $this->itemslimit));
                $this->data[$cate['cat_id']]['products'] = $products;
                $this->data[$cate['cat_id']]['children_category'] = $claCategory->getSubCategory($cate['cat_id']);
            }
        }
    }

    public function run() {
        $this->render($this->view, array(
            'cateinhome' => $this->cateinhome,
            'data' => $this->data,
            'type' => 'type2',
        ));
    }

}
