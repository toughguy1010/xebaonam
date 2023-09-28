<?php

// Sản phẩm trong nhóm
class productgroup extends WWidget {

    public $group_id = null;
    public $limit = 10;
    protected $name = 'productgroup'; // name of widget
    protected $view = 'view'; // view of widget
    protected $products = array();
    protected $link = '';
    public $group = array();

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_productgroup = new config_productgroup('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_productgroup->limit))
            $this->limit = (int) $config_productgroup->limit;
        if ($config_productgroup->widget_title)
            $this->widget_title = $config_productgroup->widget_title;
        if (isset($config_productgroup->show_wiget_title))
            $this->show_widget_title = $config_productgroup->show_wiget_title;
        if (isset($config_productgroup->group_id))
            $this->group_id = $config_productgroup->group_id;
        //
        if ($this->group_id) {
            $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
            $group = ProductGroups::model()->findByPk($this->group_id);
            if((int)$group->status!==ProductGroups::STATUS_ACTIVED){
                $group = false;
                echo ProductGroups::STATUS_ACTIVED;
            }
            $this->group = $group;
            if ($group && $group->site_id == Yii::app()->controller->site_id) {
                $this->link = Yii::app()->createUrl('/economy/product/group', array('id' => $this->group_id, 'alias' => $group['alias']));
                $this->products = ProductGroups::getProductInGroup($this->group_id, array(
                            'limit' => $this->limit,
                            ClaSite::PAGE_VAR => $page,
                ));
            }
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
            'products' => $this->products,
            'limit' => $this->limit,
            'link' => $this->link,
            'group' => $this->group,
        ));
    }

}
