<?php

/**
 * Hien thi cac chuong trinh khuyan mai o trang trang chu va cac san pham trong chuong trinh khuyan mai nay
 */
class productpromotioninhome extends WWidget {

    public $promotionInHome = array(); // promotions is show in home
    public $data = array(); // promtion info and its products
    public $limit = 1; // Giới hạn cac chuong trinh khuyen mai o trang chu
    public $itemslimit = 5; // Gioi han san pham hien thi ra
    protected $name = 'productpromotioninhome'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_productpromotioninhome = new config_productpromotioninhome('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_productpromotioninhome->limit))
            $this->limit = (int) $config_productpromotioninhome->limit;
        if ($config_productpromotioninhome->itemslimit)
            $this->itemslimit = $config_productpromotioninhome->itemslimit;
        if ($config_productpromotioninhome->widget_title)
            $this->widget_title = $config_productpromotioninhome->widget_title;
        if (isset($config_productpromotioninhome->show_wiget_title))
            $this->show_widget_title = $config_productpromotioninhome->show_wiget_title;
        //
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        // get promotion in home
        $this->promotionInHome = Promotions::getPromotionInHome(array('limit' => $this->limit));
        // Get news in category
        foreach ($this->promotionInHome as $promotion) {
            $this->data[$promotion['promotion_id']] = $promotion;
            $products = Promotions::getProductInPromotion($promotion['promotion_id'], array('limit' => $this->itemslimit));
            $this->data[$promotion['promotion_id']]['products'] = $products;
        }
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'promotionInHome' => $this->promotionInHome,
            'data' => $this->data,
        ));
    }

}
