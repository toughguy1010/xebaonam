<?php

class categoryPageSub extends WWidget {
    
    public $data = array();
    protected $view = 'view';
    protected $name = 'categoryPageSub';

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        
        // Load config
        $config_category_page_sub = new config_categoryPageSub('', array('page_widget_id' => $this->page_widget_id));
        if ($config_category_page_sub) {
            $this->widget_title = $config_category_page_sub->widget_title;
        }
        
        // set name for widget, default is class name
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        
        if ($viewname != '') {
            $this->view = $viewname;
        }
        
        $cat_id = Yii::app()->request->getParam('id', 0);
        
        $category = ProductCategories::model()->findByPk($cat_id);
        $model_cla_category = new ClaCategory(array('type' => 'product', 'create' => true));
        $model_cla_category->application = false;
        if ($category) {
            $this->data['category'] = $category;
            $this->data['children_category'] = $model_cla_category->getSubCategory($cat_id);
        }
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'data' => $this->data,
        ));
    }
    
}


