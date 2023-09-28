<?php

class tourall extends WWidget {

    public $tours;
    public $limit = 10;
    public $totalitem = 0;
    protected $name = 'tourall'; // name of widget
    protected $view = 'view'; // view of widget
    //
    public $category_id = 0;
    public $name_filter = '';
    public $destination = '';
    public $price = 0;
    public $departure_at = '';
    public $destination_id = '';

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_tourall = new config_tourall('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_tourall->limit))
            $this->limit = (int) $config_tourall->limit;
        if ($config_tourall->widget_title)
            $this->widget_title = $config_tourall->widget_title;
        if (isset($config_tourall->show_wiget_title))
            $this->show_widget_title = $config_tourall->show_wiget_title;
        //
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page) {
            $page = 1;
        }
        $order = 'id DESC';
        //
        $this->category_id = Yii::app()->request->getParam('category_id', 0);
        $this->name_filter = Yii::app()->request->getParam('name', '');
        $this->destination = Yii::app()->request->getParam('destination', '');
        $this->price = Yii::app()->request->getParam('price', 0);
        $this->departure_at = Yii::app()->request->getParam('departure_at', '');
        $this->destination_id = Yii::app()->request->getParam('destination_id', '' );
        //
        $this->tours = Tour::getAlltours(array(
                    'limit' => $this->limit,
                    ClaSite::PAGE_VAR => $page,
                    'order' => $order,
                    'category_id' => $this->category_id,
                    'name_filter' => $this->name_filter,
                    'destination' => $this->destination,
                    'price' => $this->price,
                    'departure_at' => $this->departure_at,
                    'destination_id' => $this->destination_id
        ));
        $this->totalitem = Tour::countAll(array(
                    'category_id' => $this->category_id,
                    'name_filter' => $this->name_filter,
                    'destination' => $this->destination,
                    'price' => $this->price,
                    'departure_at' => $this->departure_at,
                    'destination_id' => $this->destination_id
        ));
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
            'tours' => $this->tours,
            'limit' => $this->limit,
            'totalitem' => $this->totalitem,
        ));
    }

}
