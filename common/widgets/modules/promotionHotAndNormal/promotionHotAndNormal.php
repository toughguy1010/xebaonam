<?php

/**
 * Hien thi cac chuong trinh khuyan mai o trang trang chu va cac san pham trong chuong trinh khuyan mai nay
 */
class promotionHotAndNormal extends WWidget
{

    public $totalitem = 0; // promotions is show in home
    public $data = array(); // promtion info and its products
    public $limit = 1; // Giới hạn cac chuong trinh khuyen mai o trang chu
    public $show_on_time = 0; // Show Promotion On Time
    public $split_hot_and_normal = 1; // Show Promotion On Time
    protected $name = 'promotionHotAndNormal'; // name of widget
    protected $view = 'view'; // view of widget

    public function init()
    {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_promotionHotAndNormal = new config_promotionHotAndNormal('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_promotionHotAndNormal->limit))
            $this->limit = (int)$config_promotionHotAndNormal->limit;
        if ($config_promotionHotAndNormal->show_on_time)
            $this->show_on_time = $config_promotionHotAndNormal->show_on_time;
        if ($config_promotionHotAndNormal->widget_title)
            $this->widget_title = $config_promotionHotAndNormal->widget_title;
        if (isset($config_promotionHotAndNormal->show_wiget_title))
            $this->show_widget_title = $config_promotionHotAndNormal->show_wiget_title;
        if (isset($config_promotionHotAndNormal->split_hot_and_normal))
            $this->split_hot_and_normal = $config_promotionHotAndNormal->split_hot_and_normal;
        //
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page || isset($page)) {
            $page = 1;
        }

        $this->data = Promotions::getPromotionListHotAndNormal(array(
            'limit' => $this->limit,
            'show_on_time' => $this->show_on_time,
            ClaSite::PAGE_VAR => $page));

        parent::init();
    }

    public function run()
    {
        $this->render($this->view, array(
            'data' => $this->data,
            'totalitem' => $this->totalitem,
            'limit' => $this->limit,
        ));
    }

}
