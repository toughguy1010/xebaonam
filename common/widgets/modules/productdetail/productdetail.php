<?php

// Chi tiết sản phẩm
class productdetail extends WWidget {

    public $product_id = null;
    protected $name = 'productdetail'; // name of widget
    protected $view = 'view'; // view of widget
    protected $link = '';
    public $product = array();
    public $category = array();

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_productdetail = new config_productdetail('', array('page_widget_id' => $this->page_widget_id));
        if ($config_productdetail->widget_title) {
            $this->widget_title = $config_productdetail->widget_title;
        }
        if (isset($config_productdetail->show_wiget_title)) {
            $this->show_widget_title = $config_productdetail->show_wiget_title;
        }
        if (isset($config_productdetail->product_id)) {
            $this->product_id = $config_productdetail->product_id;
        }
        //
        if ($this->product_id) {
            $product = Product::model()->findByPk($this->product_id);
            $this->product = $product;
            $this->link = Yii::app()->createUrl('/economy/product/detail', array(
                'id' => $product->id,
                'alias' => $product->alias
            ));
            $this->category = ProductCategories::model()->findByPk($product->product_category_id);
        }

        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'product' => $this->product,
            'link' => $this->link,
            'category' => $this->category
        ));
    }

}
