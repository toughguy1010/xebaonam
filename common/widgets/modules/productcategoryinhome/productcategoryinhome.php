<?php

/**
 * Hien thi cac danh mục sản phẩm được hiển thị ở trang chủ và các sản phẩm trong danh mục này
 */
class productcategoryinhome extends WWidget
{

    public $cateinhome = array(); // promotions is show in home
    public $data = array(); // promtion info and its products
    public $manufacturerCatInHome = array(); // promtion info and its products
    public $limit = 1; // Giới hạn cac chuong trinh khuyen mai o trang chu
    public $itemslimit = 5; // Gioi han san pham hien thi ra
    protected $name = 'productcategoryinhome'; // name of widget
    protected $view = 'view'; // view of widget
    protected $onlyisHot = 0; // view of ishot
    protected $getAttribute = 0; // view of ishot

    public function init()
    {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_productcategoryinhome = new config_productcategoryinhome('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_productcategoryinhome->limit)) {
            $this->limit = (int)$config_productcategoryinhome->limit;
        }
        if ($config_productcategoryinhome->itemslimit) {
            $this->itemslimit = $config_productcategoryinhome->itemslimit;
        }
        if ($config_productcategoryinhome->widget_title) {
            $this->widget_title = $config_productcategoryinhome->widget_title;
        }
        if (isset($config_productcategoryinhome->show_wiget_title)) {
            $this->show_widget_title = $config_productcategoryinhome->show_wiget_title;
        }
        if (isset($config_productcategoryinhome->onlyisHot)) {
            $this->onlyisHot = $config_productcategoryinhome->onlyisHot;
        }
        if (isset($config_productcategoryinhome->getAttribute)) {
            $this->getAttribute = $config_productcategoryinhome->getAttribute;
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
            $this->cateinhome = ProductCategories::getCategoryInHome(array('limit' => $this->limit));
            // Get news in category
            foreach ($this->cateinhome as $cate) {
                if ($this->getAttribute) {
                    // Object
                    $this->data[$cate['cat_id']] = $cate;
                    $products = Product::getProductsInCate($cate['cat_id'], array('limit' => $this->itemslimit, 'getAttribute' => $this->getAttribute, 'onlyisHot' => $this->onlyisHot));
                    if (isset($products) && count($products)) {

                        foreach ($products as $product) {
                            $attributesDynamic = $product->getProductAttribute();
                            $this->data[$cate['cat_id']]['products'][$product->id] = $product->attributes;
                            $this->data[$cate['cat_id']]['products'][$product->id]['product_info'] = $product->product_info->attributes;
                            $this->data[$cate['cat_id']]['products'][$product->id]['attr'] = $attributesDynamic;
                            $this->data[$cate['cat_id']]['products'][$product->id]['link'] = Yii::app()->createUrl('economy/product/detail', array('id' => $product->id, 'alias' => $product->alias));
                        }
                    }
                } else {
                    // Array

                    $this->data[$cate['cat_id']] = $cate;
                    $products = Product::getProductsInCate($cate['cat_id'], array('limit' => $this->itemslimit, 'getAttribute' => $this->getAttribute, 'onlyisHot' => $this->onlyisHot));
                    $this->data[$cate['cat_id']]['products'] = $products;
                }
                $this->data[$cate['cat_id']]['manufacturers'] = ProductCategories::getManufacturerInCategory($cate['cat_id']);
                $this->manufacturerCatInHome = $this->data[$cate['cat_id']]['manufacturers'];
            }
        }
    }

    public function run()
    {
        $this->render($this->view, array(
            'cateinhome' => $this->cateinhome,
            'itemslimit' => $this->itemslimit,
            'data' => $this->data,
            'manufacturerCatInHome' => $this->manufacturerCatInHome,
        ));
    }

}
