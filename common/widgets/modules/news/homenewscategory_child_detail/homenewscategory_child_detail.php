<?php

class homenewscategory_child_detail extends WWidget {

    public $cateinhome = array(); // categories is show in home
//    public $cat_child = array(); // categories is show in home
    public $data = array(); // category info and its listnews
    public $limit = 4; // Giới hạn các danh mục tin tức trong trang chủ
    public $itemslimit = 5; // Giới hạn tin tức của danh mục
    protected $name = 'homenewscategory_child_detail'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_homenewscategory_child_detail = new config_homenewscategory_child_detail('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_homenewscategory_child_detail->limit))
            $this->limit = (int) $config_homenewscategory_child_detail->limit;
        if ($config_homenewscategory_child_detail->itemslimit)
            $this->itemslimit = $config_homenewscategory_child_detail->itemslimit;
        if ($config_homenewscategory_child_detail->widget_title)
            $this->widget_title = $config_homenewscategory_child_detail->widget_title;
        if (isset($config_homenewscategory_child_detail->show_wiget_title))
            $this->show_widget_title = $config_homenewscategory_child_detail->show_wiget_title;

        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));

        if ($viewname != '') {
            $this->view = $viewname;
            // get categories in home
            $this->cateinhome= NewsCategories::getCategoryInHome(array('limit' => $this->limit));
            // Get news in category
            $claCategory = new ClaCategory(array('create' => true, 'type' => 'news'));
            $claCategory->application = false;
            foreach ($this->cateinhome as $key => $cate) {
                $this->cateinhome[$key]['child'] = $claCategory->getSubCategory($cate['cat_id']);
                if(count( $this->cateinhome[$key]['child'])){
                    foreach ( $this->cateinhome[$key]['child'] as $cat) {
                        $listnews = News::getNewsInCategory($cat['cat_id'], array('limit' => $this->itemslimit));
                        $this->data[$cat['cat_id']] = $listnews;
                    }
                }
            }
        }
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'cateinhome' => $this->cateinhome,
//            'cat_child' => $this->cat_child,
            'data' => $this->data,
        ));
    }
}
