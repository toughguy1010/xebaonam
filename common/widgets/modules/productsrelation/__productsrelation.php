<?php

class productsrelation extends WWidget {

    public $limit = 0;
    protected $products = array();
    protected $view = 'view'; // view of widget
    protected $name = 'productsrelation';
    protected $product_id = '';
    protected $linkkey = 'economy/product/detail';

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        // set name for widget, default is class name
//        $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
//        $themename = Yii::app()->theme->name;
//        $viewname = 'webroot.themes.' . $sitetypename . '.' . $themename . '.views.modules.productsrelation.view';
//        if ($this->controller->getViewFile($viewname)) {
//            $this->view = $viewname;
//        }
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        // Load config
        $config_productsrelation = new config_productsrelation('', array('page_widget_id' => $this->page_widget_id));
        if ($config_productsrelation->widget_title)
            $this->widget_title = $config_productsrelation->widget_title;
        if (isset($config_productsrelation->show_wiget_title))
            $this->show_widget_title = $config_productsrelation->show_wiget_title;
        if ($config_productsrelation->limit)
            $this->limit = $config_productsrelation->limit;
        //
        if ($this->linkkey == ClaSite::getLinkKey())
            $this->product_id = Yii::app()->request->getParam('id');
        //
        if ($this->product_id) {
            $product = Product::model()->findByPk($this->product_id);
            if ($product) {
                $this->products = Product::getRelationProducts($product->product_category_id, $this->product_id, array('limit' => $this->limit, '_product_id' => $this->product_id));
            }
        }
        parent::init();
    }

    //
    public function run() {
        $this->render($this->view, array(
            'products' => $this->products,
            'product_id' => $this->product_id,
        ));
    }

}
