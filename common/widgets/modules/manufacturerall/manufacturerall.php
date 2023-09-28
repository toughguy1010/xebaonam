<?php

class manufacturerall extends WWidget {

    public $manufacturers;
    public $limit = 10;
    public $totalitem = 0;
    protected $name = 'manufacturerall'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        $config_manufacturerall = new config_manufacturerall('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_manufacturerall->limit))
            $this->limit = (int) $config_manufacturerall->limit;
        if ($config_manufacturerall->widget_title)
            $this->widget_title = $config_manufacturerall->widget_title;
        if (isset($config_manufacturerall->show_wiget_title))
            $this->show_widget_title = $config_manufacturerall->show_wiget_title;
        //
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page)
            $page = 1;
        $manufacturer = Yii::app()->request->getParam('q',false);

//        $order = $this->getOrderQuery();
        //
      /*  $this->manufacturers = Product::getAllProducts(array(
        // Load config
                    'limit' => $this->limit,
                    ClaSite::PAGE_VAR => $page,
                    'order' => $order,
        ));*/

//        $pagesize = ProductHelper::helper()->getPageSize();
//        $page = ProductHelper::helper()->getCurrentPage();
//        $order = ProductHelper::helper()->getOrderQuery();
        $condition = '';
        $params = [];
        if ($manufacturer) {
            $condition = 'M.name LIKE :manufacturer';
            $params[':manufacturer'] =  '%' . $manufacturer . '%';
        }
        //
        $this->manufacturers = Manufacturer::getAllManufacturer(array(
            'limit' => $this->limit,
            ClaSite::PAGE_VAR => $page,
//            'order'=>$order,
            'condition' => $condition,
            'params' => $params,
        ));
        //Layoutcustom
        $this->totalitem = Manufacturer::getAllManufacturer(array('condition' => $condition, 'params' => $params), true);
        //
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
            'manufacturers' => $this->manufacturers,
            'limit' => $this->limit,
            'totalitem' => $this->totalitem,
        ));
    }

    /**
     * return order query
     * @param type $order
     */
    function getOrderQuery() {
        $sort = Yii::app()->request->getParam(ClaSite::PAGE_SORT);
        $order = '';
        if ($sort) {
            switch ($sort) {
                case 'new': $order = 'isnew DESC,created_time DESC';
                    break;
                case 'new_desc': $order = 'isnew,created_time';
                    break;
                case 'price': $order = 'price';
                    break;
                case 'price_desc': $order = 'price DESC';
                    break;
                case 'name': $order = 'name';
                    break;
                case 'name_desc': $order = 'name DESC';
                    break;
            }
        }
        return $order;
    }

}
