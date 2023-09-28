<?php

/**
 * Danh mục khóa học và các khóa học trong danh mục đó
 */
class courseCategoryInHome extends WWidget {

    public $cateinhome = array(); // categories is show in home
    public $data = array(); // category info and its listnews
    public $limit = 4; // Giới hạn các danh mục tin tức trong trang chủ
    public $itemslimit = 5; // Giới hạn tin tức của danh mục
    public $onlyisHot = 0; //is hot only
    protected $name = 'courseCategoryInHome'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_coursecategoryinhome = new config_courseCategoryInHome('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_coursecategoryinhome->limit)) {
            $this->limit = (int) $config_coursecategoryinhome->limit;
        }
        if ($config_coursecategoryinhome->itemslimit) {
            $this->itemslimit = $config_coursecategoryinhome->itemslimit;
        }
        if ($config_coursecategoryinhome->widget_title) {
            $this->widget_title = $config_coursecategoryinhome->widget_title;
        }
        if (isset($config_coursecategoryinhome->onlyisHot)) {
            $this->onlyisHot = $config_coursecategoryinhome->onlyisHot;
        }
        if (isset($config_coursecategoryinhome->show_wiget_title)) {
            $this->show_widget_title = $config_coursecategoryinhome->show_wiget_title;
        }
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        // get categories in home
        $this->cateinhome = CourseCategories::getCategoryInHome(array('limit' => $this->limit));
        // Get news in category
        foreach ($this->cateinhome as $cate) {
            $this->data[$cate['cat_id']] = $cate;
            $listcourse = Course::getCourseInCategory($cate['cat_id'], array('limit' => $this->itemslimit, 'onlyisHot' => $this->onlyisHot));
            $this->data[$cate['cat_id']]['course'] = $listcourse;
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
