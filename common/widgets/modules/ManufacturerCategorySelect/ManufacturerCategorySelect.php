<?php

/**
 * @author hungtm
 */
class ManufacturerCategorySelect extends WWidget
{

    public $limit = 5;
    public $parent_id = 0;
    protected $name = 'ManufacturerCategorySelect'; // name of widget
    protected $view = 'view'; // view of widget
    protected $dataManufacturer = [];


    public function init()
    {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        $config_ManufacturerCategorySelect = new config_ManufacturerCategorySelect('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_ManufacturerCategorySelect->limit)) {
            $this->limit = (int)$config_ManufacturerCategorySelect->limit;
        }
        $this->widget_title = $config_ManufacturerCategorySelect->widget_title;
        $this->dataManufacturer = ManufacturerCategories::getCategoryByParent2(array('limit' => $this->limit));
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        parent::init();
    }

    public function run()
    {
        $this->render($this->view, array(
            'dataManufacturer' => $this->dataManufacturer,
        ));
    }
}

?>