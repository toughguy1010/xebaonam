<?php

/**
 * Hien thi cac chuong trinh khuyan mai o trang trang chu va cac san pham trong chuong trinh khuyan mai nay
 */
class productgroupinhome extends WWidget {

    public $productGroupInHome = array(); // promotions is show in home
    public $data = array(); // promtion info and its products
    public $limit = 1; // Giới hạn cac chuong trinh khuyen mai o trang chu
    public $itemslimit = 5; // Gioi han san pham hien thi ra
    protected $name = 'productgroupinhome'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_productgroupinhome = new config_productgroupinhome('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_productgroupinhome->limit))
            $this->limit = (int) $config_productgroupinhome->limit;
        if ($config_productgroupinhome->itemslimit)
            $this->itemslimit = $config_productgroupinhome->itemslimit;
        if ($config_productgroupinhome->widget_title)
            $this->widget_title = $config_productgroupinhome->widget_title;
        if (isset($config_productgroupinhome->show_wiget_title))
            $this->show_widget_title = $config_productgroupinhome->show_wiget_title;
        //
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        // get promotion in home
        $this->productGroupInHome = ProductGroups::getProductGroupInHome(array('limit' => $this->limit));
        // Get news in category
        foreach ($this->productGroupInHome as $productgroup) {
            $this->data[$productgroup['group_id']] = $productgroup;
            $products = ProductGroups::getProductInGroup($productgroup['group_id'], array('limit' => $this->itemslimit));
            $this->data[$productgroup['group_id']]['products'] = $products;
        }
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'productGroupInHome' => $this->productGroupInHome,
            'data' => $this->data,
        ));
    }

}
