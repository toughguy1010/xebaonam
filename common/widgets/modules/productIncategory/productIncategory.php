<?php

class productIncategory extends WWidget {

    public $products = array();
    public $limit = 10;
    public $child_cat = false;
    public $itemslimit = 6;
    public $cat_id = 0;
    public $category = null;
    public $cat_link = null;
    public $self_category = null;
    public $self_products = array();
    protected $name = 'productIncategory'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_productcategory = new config_productIncategory('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_productcategory->limit))
            $this->limit = (int) $config_productcategory->limit;
        if (isset($config_productcategory->itemslimit))
            $this->itemslimit = (int) $config_productcategory->itemslimit;
        if ($config_productcategory->widget_title)
            $this->widget_title = $config_productcategory->widget_title;
        if (isset($config_productcategory->show_wiget_title))
            $this->show_widget_title = $config_productcategory->show_wiget_title;
        if (isset($config_productcategory->child_cat))
            $this->child_cat = $config_productcategory->child_cat;
        if (isset($config_productcategory->cat_id))
            $this->cat_id = $config_productcategory->cat_id;

        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }

        if ($this->child_cat == true) {
            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_PRODUCT;
            $category->generateCategory();
            $option = $category->createArrayCategory($this->cat_id);
            $this->category['parent'] = ProductCategories::model()->findByPk($this->cat_id)->attributes;
            $this->category['child'] = $option;
            foreach ($option as $key => $cate) {
                $this->products[$key]['products'] = Product::getProductsInCate($key, array('limit' => $this->itemslimit));
            }
        } else {
            $this->products = Product::getProductsInCate($this->cat_id, array('limit' => $this->itemslimit));
            $this->category = ProductCategories::model()->findByPk($this->cat_id)->attributes;
            $this->cat_link = Yii::app()->createUrl('/economy/product/category', array('id' => $this->self_category['cat_id'], 'alias' => $this->self_category['alias']));
        }
    }

    public function run() {
        $this->render($this->view, array(
            'products' => $this->products,
            'category' => $this->category,
//            'self_category' => $this->self_category,
//            'self_products' => $this->self_products,
            'cat_link' => $this->cat_link,
        ));
    }

}
