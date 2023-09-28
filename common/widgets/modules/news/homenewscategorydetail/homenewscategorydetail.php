<?php

class homenewscategorydetail extends WWidget {

    public $cateinhome = array(); // categories is show in home
    public $data = array(); // category info and its listnews
    public $limit = 4; // Giới hạn các danh mục tin tức trong trang chủ
    public $itemslimit = 5; // Giới hạn tin tức của danh mục
    protected $name = 'homenewscategorydetail'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_homenewscategorydetail = new config_homenewscategorydetail('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_homenewscategorydetail->limit))
            $this->limit = (int) $config_homenewscategorydetail->limit;
        if ($config_homenewscategorydetail->itemslimit)
            $this->itemslimit = $config_homenewscategorydetail->itemslimit;
        if ($config_homenewscategorydetail->widget_title)
            $this->widget_title = $config_homenewscategorydetail->widget_title;
        if (isset($config_homenewscategorydetail->show_wiget_title))
            $this->show_widget_title = $config_homenewscategorydetail->show_wiget_title;

        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
            // get categories in home
            $this->cateinhome = NewsCategories::getCategoryInHome(array('limit' => $this->limit));
            // Get news in category
            foreach ($this->cateinhome as $cate) {
                $this->data[$cate['cat_id']] = $cate;
                $listnews = News::getNewsInCategory($cate['cat_id'], array('limit' => $this->itemslimit));
                $this->data[$cate['cat_id']]['listnews'] = $listnews;
            }
        }
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'cateinhome' => $this->cateinhome,
            'data' => $this->data,
        ));
    }

}
