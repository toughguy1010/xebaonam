<?php

class productFilterManufacturerCat extends WWidget {

    public $data;
    public $manufacturers;
    public $manu_id = '';
    public $manu_models;
    public $manu_model_id = '';
    public $manu_types;
    public $manu_type_id = '';
    protected $name = 'productFilterManufacturerCat'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_productFilterManufacturerCat = new config_productFilterManufacturerCat('', array('page_widget_id' => $this->page_widget_id));
        if ($config_productFilterManufacturerCat->widget_title) {
            $this->widget_title = $config_productFilterManufacturerCat->widget_title;
        }
        if (isset($config_productFilterManufacturerCat->show_wiget_title)) {
            $this->show_widget_title = $config_productFilterManufacturerCat->show_wiget_title;
        }
        //
        $this->manu_id = Yii::app()->request->getParam('manu_id', '');
        $this->manufacturers = ManufacturerCategories::getCategoryByParent(0);
        //
        $this->manu_model_id = Yii::app()->request->getParam('manu_model_id', '');
        $this->manu_models = ManufacturerCategories::getCategoryByParentIds($this->manu_id);
        //
        $this->manu_type_id = Yii::app()->request->getParam('manu_type_id', '');
        $this->manu_types = ManufacturerCategories::getCategoryByParentIds($this->manu_model_id);
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
            'data' => $this->data,
            'manufacturers' => $this->manufacturers,
            'manu_id' => $this->manu_id,
            'manu_models' => $this->manu_models,
            'manu_model_id' => $this->manu_model_id,
            'manu_types' => $this->manu_types,
            'manu_type_id' => $this->manu_type_id
        ));
    }

}
