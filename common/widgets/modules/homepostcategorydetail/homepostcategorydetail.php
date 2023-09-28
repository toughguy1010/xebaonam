<?php
/**
 * Danh mục tin bài viết hiển thi ở trang chủ và bài viết của danh mục đó
 */
class homepostcategorydetail extends WWidget {

    public $cateinhome = array(); // categories is show in home
    public $data = array(); // category info and its listnews
    public $limit = 4; // Giới hạn các danh mục tin tức trong trang chủ
    public $itemslimit = 5; // Giới hạn tin tức của danh mục
    protected $name = 'homepostcategorydetail'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_homepostcategorydetail = new config_homepostcategorydetail('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_homepostcategorydetail->limit))
            $this->limit = (int) $config_homepostcategorydetail->limit;
        if ($config_homepostcategorydetail->itemslimit)
            $this->itemslimit = $config_homepostcategorydetail->itemslimit;
        if ($config_homepostcategorydetail->widget_title)
            $this->widget_title = $config_homepostcategorydetail->widget_title;
        if (isset($config_homepostcategorydetail->show_wiget_title))
            $this->show_widget_title = $config_homepostcategorydetail->show_wiget_title;

        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
            // get categories in home
            $this->cateinhome = PostCategories::getCategoryInHome(array('limit' => $this->limit));
            // Get news in category
            foreach ($this->cateinhome as $cate) {
                $this->data[$cate['cat_id']] = $cate;
                $listpost = Posts::getPostsInCategory($cate['cat_id'], array('limit' => $this->itemslimit));
                $this->data[$cate['cat_id']]['posts'] = $listpost;
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
