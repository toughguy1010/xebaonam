<?php

class categoryPageSubProduct extends WWidget {

    public $data = array();
    protected $view = 'view';
    protected $name = 'categoryPageSubProduct';
    public $limit = 10;

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }

        // Load config
        $config_category_page_sub_product = new config_categoryPageSubProduct('', array('page_widget_id' => $this->page_widget_id));
        if ($config_category_page_sub_product->widget_title) {
            $this->widget_title = $config_category_page_sub_product->widget_title;
        }
        if (isset($config_category_page_sub_product->limit)) {
            $this->limit = (int) $config_category_page_sub_product->limit;
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
            if (isset($this->data['children_category']) && $this->data['children_category']) {
                foreach ($this->data['children_category'] as $sub_cat_id => $sub_cat) {
                    $this->data['children_category'][$sub_cat_id]['products'] = Product::getProductsInThisCat($sub_cat_id, array(
                                'limit' => $this->limit,
                                ClaSite::PAGE_VAR => 1,
                    ));
                }
            }
        }
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'data' => $this->data,
        ));
    }

}
