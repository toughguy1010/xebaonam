<?php

/* * *
 * Lấy tất cả các Dự án bất động sản theo giới hạn
 */

class realestateProjectAll extends WWidget
{

    public $realestateProject;
    public $limit = 10;
    public $totalitem = 0;
    protected $name = 'realestateProjectAll'; // name of widget
    protected $view = 'view'; // view of widget

    public function init()
    {

        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }

        $real_estate_cat_id = Yii::app()->request->getParam('rcid', 0);

        // Load config
        $config_realestateProjectAll = new config_realestateProjectAll('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_realestateProjectAll->limit)) {
            $this->limit = (int)$config_realestateProjectAll->limit;
        }
        if ($config_realestateProjectAll->widget_title) {
            $this->widget_title = $config_realestateProjectAll->widget_title;
        }
        if (isset($config_realestateProjectAll->show_wiget_title)) {
            $this->show_widget_title = $config_realestateProjectAll->show_wiget_title;
        }
        //
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page) {
            $page = 1;
        }
        //
        // Get $realestateProject
        $this->realestateProject = RealEstateProject::getAllRealestateProject(array(
            'limit' => $this->limit,
            ClaSite::PAGE_VAR => $page,
            'real_estate_cat_id' => $real_estate_cat_id
        ));
        //
        $this->totalitem = RealEstateProject::countAllRealestateProject(array('real_estate_cat_id' => $real_estate_cat_id));
        parent::init();
    }

    public function run()
    {
//        $unit_price = RealEstateProject::unitPrice();
        $this->render($this->view, array(
            'list_realestateProject' => $this->realestateProject,
            'limit' => $this->limit,
            'totalitem' => $this->totalitem,
        ));
    }

}
