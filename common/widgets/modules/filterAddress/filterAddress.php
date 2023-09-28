<?php

class filterAddress extends WWidget {

    protected $view = 'view';

    public function init() {
        parent::init();
    }

    public function run() {

        $model = new Shop();
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

        $listprovince = LibProvinces::getListProvinceArr(array('allownull' => true));
        if (!$model->province_id) {
            $first = array_keys($listprovince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $model->province_id = $firstpro;
        }
        $listdistrict = false;

        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id, array('allownull' => true));
        }
        if (!$model->district_id) {
            $first = array_keys($listdistrict);
            $firstdis = isset($first[0]) ? $first[0] : null;
            $model->district_id = $firstdis;
        }
        $listward = false;
        if (!$listward) {
            $listward = LibWards::getListWardArrFollowDistrict($model->district_id, array('allownull' => true));
        }
        $this->render($this->view, array(
            'model' => $model,
            'listprovince' => $listprovince,
            'listdistrict' => $listdistrict,
            'listward' => $listward,
        ));
    }

}
