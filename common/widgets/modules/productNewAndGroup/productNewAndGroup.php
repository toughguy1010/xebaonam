<?php

// Sản phẩm mới và trong nhóm
class productNewAndGroup extends WWidget {

    public $group_id = null;
    public $limit = 10;
    protected $name = 'productNewAndGroup'; // name of widget
    protected $view = 'view'; // view of widget
    protected $products_group = array();
    protected $products_new = array();
    protected $link = '';
    protected $show_group_in_home = false;
    protected $groups = [];

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config products group
        $config_product_new_and_group = new config_productNewAndGroup('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_product_new_and_group->limit))
            $this->limit = (int) $config_product_new_and_group->limit;
        if ($config_product_new_and_group->widget_title)
            $this->widget_title = $config_product_new_and_group->widget_title;
        if (isset($config_product_new_and_group->show_wiget_title))
            $this->show_widget_title = $config_product_new_and_group->show_wiget_title;
        if (isset($config_product_new_and_group->group_id))
            $this->group_id = $config_product_new_and_group->group_id;
        if (isset($config_product_new_and_group->show_group_in_home))
            $this->show_group_in_home = $config_product_new_and_group->show_group_in_home;
        //
        if (!$this->show_group_in_home) {
            if ($this->group_id) {
                $group = ProductGroups::model()->findByPk($this->group_id);
                if ($group && $group->site_id == Yii::app()->controller->site_id) {
                    $this->link = Yii::app()->createUrl('/economy/product/group', array('id' => $this->group_id, 'alias' => $group['alias']));
                    $this->products_group = ProductGroups::getProductInGroup($this->group_id, array(
                        'limit' => $this->limit,
                    ));
                }
            }
        }else{
            $this->groups = ProductGroups::getProductGroupInHome();
            if (count( $this->groups)) {
                foreach ( $this->groups as $key => $each_group){
                    $this->groups[$key]['items'] =  ProductGroups::getProductInGroup($key, array(
                        'limit' => $this->limit,
                    ));
                }
            }
        }
        // get new products
        $this->products_new = Product::getSetNewProducts(array('limit' => $this->limit));
        //

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
            'products_group' => $this->products_group,
            'products_new' => $this->products_new,
            'limit' => $this->limit,
            'link' => $this->link,
            'groups' => $this->groups,
        ));
    }

}
