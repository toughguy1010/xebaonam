<?php

class shoppingcart extends WWidget {

    protected $link = '';
    protected $products = array();
    protected $quantity = 0;
    protected $view = 'view';
    protected $name = 'shoppingcart';
    protected $shoppingcart = null;

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        // Load config
        $config_shoppingcart = new config_shoppingcart('', array('page_widget_id' => $this->page_widget_id));
        if ($config_shoppingcart) {
            $this->show_widget_title = $config_shoppingcart->show_wiget_title;
            $this->widget_title = $config_shoppingcart->widget_title;
        }
        //
        $this->shoppingcart = Yii::app()->customer->getShoppingCart();
        $this->products = $this->shoppingcart->getProducts();
        $this->quantity = $this->shoppingcart->countProducts();
        $this->link = Yii::app()->createUrl('/economy/shoppingcart');
        //
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        //
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'products' => $this->products,
            'quantity' => $this->quantity,
            'link' => $this->link,
            'shoppingcart' => $this->shoppingcart,
            'total_price' => $this->shoppingcart->getTotalPrice(),
        ));
    }

}
