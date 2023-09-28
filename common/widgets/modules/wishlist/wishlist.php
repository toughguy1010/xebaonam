<?php

class wishlist extends WWidget {

    protected $link = '';
    protected $products = array();
    protected $quantity = 0;
    protected $view = 'view';
    protected $name = 'wishlist';
    protected $shoppingcart = null;

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        // Load config
        $config_wishlist = new config_wishlist('', array('page_widget_id' => $this->page_widget_id));
        if ($config_wishlist) {
            $this->show_widget_title = $config_wishlist->show_wiget_title;
            $this->widget_title = $config_wishlist->widget_title;
        }
        //
        $this->products = Likes::getProductLikedByUser();
        $this->quantity = count($this->products);
        $this->link = Yii::app()->createUrl('/economy/like/product');
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
        ));
    }

}
