<?php

class filterShoptype extends WWidget {

    protected $view = 'view';

    public function init() {
        parent::init();
    }

    public function run() {
        
        $filter_shop = isset(Yii::app()->session[Shop::FILTER_SHOP]) ? Yii::app()->session[Shop::FILTER_SHOP] : array();
        
        $this->render($this->view, array(
            'filter_shop' => $filter_shop,
        ));
        
    }

}
