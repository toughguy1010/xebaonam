<?php

/**
 * Danh sach cac danh muc san pham, tin tuc
 */
class categorybox extends WWidget {

    public $type = 0;
    public $parent = 0;
    public $level = 0;
    protected $data = array();
    protected $name = 'categorybox'; // name of widget
    protected $view = 'view'; // view of widget
    protected $linkkey = 'economy/product/detail'; // view of widget
    protected $product = null; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_categorybox = new config_categorybox('', array('page_widget_id' => $this->page_widget_id));
        if ($config_categorybox->type)
            $this->type = $config_categorybox->type;
        if ($config_categorybox->widget_title)
            $this->widget_title = $config_categorybox->widget_title;
        if (isset($config_categorybox->show_wiget_title))
            $this->show_widget_title = $config_categorybox->show_wiget_title;
        // get get category
        if ($this->type) {
            $category = new ClaCategory(array('type' => $this->type, 'create' => true));
            $category->application = 'public';
            $this->data = $category->createArrayCategory($this->parent);
        }
        if ($this->linkkey == ClaSite::getLinkKey()) {
            $product_id = Yii::app()->request->getParam('id');
            if ($product_id) {
                $this->product = Product::model()->findByPk($product_id);
            }
        }
        //
//        $themename = Yii::app()->theme->name;
//        $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
//        $viewname = 'webroot.themes.' . $sitetypename . '.' . $themename . '.views.modules.' . $this->name . '.view';
//        if ($this->controller->getViewFile($viewname)) {
//            $this->view = $viewname;
//        }
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
        if ($this->type) {
            $this->render($this->view, array(
                'product' => $this->product,
                'data' => $this->data,
                'level' => $this->level,
            ));
        }
    }

}
