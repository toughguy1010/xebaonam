<?php

// Trang nội dung
class pageContent extends WWidget {

    public $page_id = null;
    protected $name = 'pageContent'; // name of widget
    protected $view = 'view'; // view of widget
    protected $link = '';
    public $page = array();

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_pageContent = new config_pageContent('', array('page_widget_id' => $this->page_widget_id));
        if ($config_pageContent->widget_title) {
            $this->widget_title = $config_pageContent->widget_title;
        }
        if (isset($config_pageContent->show_wiget_title)) {
            $this->show_widget_title = $config_pageContent->show_wiget_title;
        }
        if (isset($config_pageContent->page_id)) {
            $this->page_id = $config_pageContent->page_id;
        }
        //
        if ($this->page_id) {
            $page = CategoryPage::model()->findByPk($this->page_id);
            $this->page = $page;
            $this->link = Yii::app()->createUrl('/page/category/detail', array(
                'id' => $page->id,
                'alias' => $page->alias
            ));
        }

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
            'page' => $this->page,
            'link' => $this->link
        ));
    }

}
