<?php

class tourfilter extends WWidget {

    public $data = array(); // category info and its listnews
    public $view = 'view'; // view of widget
    protected $name = 'tourfilter';
    public $options = array();
    //
    public $show_in_filter = false;
    public $category_id = 0;
    public $name_filter = '';
    public $destination = '';
    public $departure_at = '';
    public $price = 0;
    public $action = '';
    public $action_suggest = '';

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
        $this->category_id = Yii::app()->request->getParam('category_id', 0);
        $this->name_filter = Yii::app()->request->getParam('name', '');
        $this->destination = Yii::app()->request->getParam('destination', '');
        $this->departure_at = Yii::app()->request->getParam('departure_at', '');
        $this->price = Yii::app()->request->getParam('price', 0);
        //
        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_TOUR;
        $category->generateCategory();
        $arr = array('' => Yii::t('category', 'category_parent_0'));
        //
        $this->options = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $arr);
        if($this->show_in_filter == true){
            $this->options = TourCategories::getCategoryShowInFilter();
        }
        if ($viewname != '') {
            $this->view = $viewname;
        }
        $this->action_suggest = Yii::app()->createUrl('/search/search/suggest');
        $this->action = Yii::app()->createUrl('tour/tour');
        //
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'options' => $this->options,
            'category_id' => $this->category_id,
            'name_filter' => $this->name_filter,
            'destination' => $this->destination,
            'departure_at' => $this->departure_at,
            'price' => $this->price,
            'action' => $this->action,
            'action_suggest' => $this->action_suggest,
        ));
    }

}
