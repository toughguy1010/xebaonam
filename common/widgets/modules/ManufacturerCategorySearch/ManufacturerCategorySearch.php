<?php

/**
 * @author hungtm
 */
class ManufacturerCategorySearch extends WWidget {

    public $limit = 5;
    public $parent_id = 0;
    protected $name = 'ManufacturerCategorySearch'; // name of widget
    protected $view = 'view'; // view of widget
    protected $dataManufacturer = [];
    public $manufacturer_id = 0;
    public $root_id = 0;
    public $manufacturer_id_lv2 = 0;
    public $manufacturer_id_lv3 = 0;


    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        $this->manufacturer_id = Yii::app()->request->getParam('id', 0); //get id
        $manufacturer = ManufacturerCategories::model()->findByPk($this->manufacturer_id); //
        $this->root_id = $manufacturer->cat_id;
        if(isset($manufacturer->cat_parent) && $manufacturer->cat_parent) {
            $manufacturerParent = ManufacturerCategories::model()->findByPk($manufacturer->cat_parent);
            $this->root_id = $manufacturerParent->cat_id;
            $this->manufacturer_id_lv2 = $this->manufacturer_id;
            if (isset($manufacturerParent->cat_parent) && $manufacturerParent->cat_parent) {
                $this->manufacturer_id_lv2 = $manufacturerParent->cat_id;
                $manufacturerParent1 = ManufacturerCategories::model()->findByPk($manufacturerParent->cat_parent);
                $this->root_id = $manufacturerParent1->cat_id;
                $this->manufacturer_id_lv3 = $this->manufacturer_id;
                if (isset($manufacturerParent1->cat_parent) && $manufacturerParent1->cat_parent) {
                    $this->manufacturer_id_lv2 = $manufacturerParent1->cat_id;
                    $this->manufacturer_id_lv3 = $manufacturerParent->cat_id;
                    $manufacturerRoot = ManufacturerCategories::model()->findByPk($manufacturerParent1->cat_parent);
                    if (isset($manufacturerRoot) && $manufacturerRoot) {
                        $this->root_id = $manufacturerRoot->cat_id;
                    }
                }


            }
        }
        //
        $config_ManufacturerCategorySearch = new config_ManufacturerCategorySearch('', array('page_widget_id' => $this->page_widget_id));
        $this->widget_title = $config_ManufacturerCategorySearch->widget_title;
        $this->show_widget_title = $config_ManufacturerCategorySearch->show_wiget_title;
        //
        $this->dataManufacturer = ManufacturerCategories::getCategoryByParent($this->parent_id);
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
            'dataManufacturer' => $this->dataManufacturer,
            'manufacturer_id' => $this->manufacturer_id,
            'root_id' => $this->root_id,
            'manufacturer_id_lv2' => $this->manufacturer_id_lv2,
            'manufacturer_id_lv3' => $this->manufacturer_id_lv3
        ));
    }


}
