<?php

/**
 * Hien thi cac danh mục sản phẩm được hiển thị ở trang chủ và các sản phẩm trong danh mục này
 */
class newscategoryinhome extends WWidget
{

    public $cateinhome = array(); // promotions is show in home
    public $data = array(); // promtion info and its products
    public $limit = 1; // Giới hạn cac chuong trinh khuyen mai o trang chu
    public $itemslimit = 5; // Gioi han san pham hien thi ra
    protected $name = 'newscategoryinhome'; // name of widget
    protected $view = 'view'; // view of widget
    protected $onlyisHot = 0; // view of ishot
    protected $getAttribute = 0; // view of ishot

    public function init()
    {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_newscategoryinhome = new config_newscategoryinhome('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_newscategoryinhome->limit)) {
            $this->limit = (int)$config_newscategoryinhome->limit;
        }
        if ($config_newscategoryinhome->itemslimit) {
            $this->itemslimit = $config_newscategoryinhome->itemslimit;
        }
        if ($config_newscategoryinhome->widget_title) {
            $this->widget_title = $config_newscategoryinhome->widget_title;
        }
        if (isset($config_newscategoryinhome->show_wiget_title)) {
            $this->show_widget_title = $config_newscategoryinhome->show_wiget_title;
        }
        if (isset($config_newscategoryinhome->onlyisHot)) {
            $this->onlyisHot = $config_newscategoryinhome->onlyisHot;
        }

        //
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));

        //
        if ($viewname != '') {
            $this->view = $viewname;
            // get categories in home
            $this->cateinhome = NewsCategories::getCategoryInHome(array('limit' => $this->limit));
            // Get news in category
            foreach ($this->cateinhome as $cate) {
                // Array
                $this->data[$cate['cat_id']] = $cate;
                $news = News::getNewsInCategory($cate['cat_id'], array('limit' => $this->itemslimit, 'getAttribute' => $this->getAttribute, 'onlyisHot' => $this->onlyisHot));
                $this->data[$cate['cat_id']]['news'] = $news;

            }
        }
        parent::init();
    }

    public function run()
    {
        $this->render($this->view, array(
            'cateinhome' => $this->cateinhome,
            'itemslimit' => $this->itemslimit,
            'data' => $this->data,
        ));
    }

}
