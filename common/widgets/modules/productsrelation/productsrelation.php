<?php

class productsrelation extends WWidget {

    public $limit = 0;
    protected $products = array();
    protected $view = 'view'; // view of widget
    protected $name = 'productsrelation';
    protected $product_id = '';
    protected $linkkey = 'economy/product/detail';
    protected $linkkey2 = 'news/news/detail';
    protected $news_id = '';
    protected $fromParent = 0;
    protected $showProductDesc = 0;
    protected $fromManufacture = 0;

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        // Load config
        $config_productsrelation = new config_productsrelation('', array('page_widget_id' => $this->page_widget_id));
        //
        if ($config_productsrelation->widget_title)
            $this->widget_title = $config_productsrelation->widget_title;
        //
        if (isset($config_productsrelation->show_wiget_title))
            $this->show_widget_title = $config_productsrelation->show_wiget_title;
        //
        if ($config_productsrelation->limit)
            $this->limit = $config_productsrelation->limit;
        //
        if (isset($config_productsrelation->fromParent)) {
            $this->fromParent = $config_productsrelation->fromParent;
        }
        if (isset($config_productsrelation->fromManufacture)) {
            $this->fromManufacture = $config_productsrelation->fromManufacture;
        }
        //
        if (isset($config_productsrelation->showProductDesc)) {
            $this->showProductDesc = $config_productsrelation->showProductDesc;
        }
        //
        if (ClaSite::getLinkKey() == $this->linkkey) {
            $this->product_id = Yii::app()->request->getParam('id');
            if ($this->product_id) {
                $product = Product::model()->findByPk($this->product_id);
                if ($product) {
                    $number_track = array_reverse(explode(' ', $product['category_track']));
                    if ($this->fromParent) {
                        $cnumber = count($number_track);
                        $pcat = isset($number_track[$cnumber - 1]) ? $number_track[$cnumber - 1] : $product->product_category_id;
                        //
                        $options = array(
                            'limit' => $this->limit,
                            '_product_id' => $this->product_id,
                            'showProductDesc' => $this->showProductDesc,
                        );
                        $this->products = Product::getRelationProducts($pcat, $this->product_id, $options);
                    } else if ($this->fromManufacture) {
                        $options = array(
                            'limit' => $this->limit,
                            'manufacture' => $product['manufacturer_id'],
                        );
                        if (isset($product['manufacturer_id']) && (int)$product['manufacturer_id']) {
                            $this->products = Product::getProduct($options);
                        } else {
                            $this->products = array();
                        }
                    } else {
                        //
                        $options = array(
                            'limit' => $this->limit,
                            '_product_id' => $this->product_id,
                            'showProductDesc' => $this->showProductDesc,
                        );
                        $this->products = Product::getRelationProducts($product->product_category_id, $this->product_id, $options);
                    }
                }
            }
        } else if (ClaSite::getLinkKey() == $this->linkkey2) { // Lấy ra các sản phẩm được rel với tin tức.
            $this->news_id = Yii::app()->request->getParam('id');
            if ($this->news_id) {
                $news = News::model()->findByPk($this->news_id);
                if ($news) {
                    $this->products = ProductNewsRelation::getProductInRel($this->news_id, array('limit' => $this->limit));
                }
            }
        }
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'products' => $this->products,
            'product_id' => $this->product_id,
        ));
    }

}
