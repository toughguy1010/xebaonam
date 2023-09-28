<?php

class searchhotels extends WWidget {

    protected $view = 'view';
    protected $name = 'searchhotels'; // name of widget
    
    public $listprovince;
    public $listdistrict;
    public $listward;

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        $config_searchbox = new config_searchhotels('', array('page_widget_id' => $this->page_widget_id));
        if ($config_searchbox->widget_title) {
            $this->widget_title = $config_searchbox->widget_title;
        }
        if (isset($config_searchbox->show_wiget_title)) {
            $this->show_widget_title = $config_searchbox->show_wiget_title;
        }
        
        $model = new TourHotel();
        $model->unsetAttributes();
        $province_id = Yii::app()->session['province_id'];
        if (isset($province_id) && ($province_id != '')) {
            $model->province_id = $province_id;
        }
        $district_id = Yii::app()->session['district_id'];
        if (isset($district_id) && ($district_id != '')) {
            $model->district_id = $district_id;
        }
        $ward_id = Yii::app()->session['ward_id'];
        if (isset($ward_id) && ($ward_id != '')) {
            $model->ward_id = $ward_id;
        }

        $this->listprovince = LibProvinces::getListProvinceArr(array('allownull' => true));
        if (!$model->province_id) {
            $first = array_keys($this->listprovince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $model->province_id = $firstpro;
        }
        $this->listdistrict = false;

        if (!$this->listdistrict) {
            $this->listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id, array('allownull' => true));
        }
        if (!$model->district_id) {
            $first = array_keys($this->listdistrict);
            $firstdis = isset($first[0]) ? $first[0] : null;
            $model->district_id = $firstdis;
        }
        $this->listward = false;
        if (!$this->listward) {
            $this->listward = LibWards::getListWardArrFollowDistrict($model->district_id, array('allownull' => true));
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
            'model' => $model,
            'listprovince' => $this->listprovince,
            'listdistrict' => $this->listdistrict,
            'listward' => $this->listward,
        ));
    }

}
