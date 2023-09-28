<?php

/* * *
 * Lấy tất cả các tin tức bất động sản trong site ra theo giới hạn
 */

class realestateall extends WWidget {

    public $realestate;
    public $limit = 10;
    public $totalitem = 0;
    protected $name = 'realestateall'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_realestateall = new config_realestateall('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_realestateall->limit)) {
            $this->limit = (int) $config_realestateall->limit;
        }
        if ($config_realestateall->widget_title) {
            $this->widget_title = $config_realestateall->widget_title;
        }
        if (isset($config_realestateall->show_wiget_title)) {
            $this->show_widget_title = $config_realestateall->show_wiget_title;
        }
        //
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page) {
            $page = 1;
        }
        //
        // get realestateall
        $this->realestate = RealEstate::getAllRealestate(array(
                    'limit' => $this->limit,
                    ClaSite::PAGE_VAR => $page,
        ));
        //
        $this->totalitem = RealEstate::countAllRealestate();
        parent::init();
    }

    public function run() {
        $unit_price = RealEstate::unitPrice();
        $this->render($this->view, array(
            'list_realestate' => $this->realestate,
            'limit' => $this->limit,
            'totalitem' => $this->totalitem,
            'unit_price' => $unit_price
        ));
    }

}
