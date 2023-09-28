<?php

class SuggestController extends PublicController {

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xEEEEEE,
            ),
        );
    }

    /**
     * get district of province
     */
    function actionGetdistrict() {
        $province_id = Yii::app()->request->getParam('pid');
        $allownull = Yii::app()->request->getParam('allownull', 0);
        $filter = Yii::app()->request->getParam('filter', 0);
        if ($province_id) {
            if ($filter) {
                if ($province_id == 'all') {
                    unset(Yii::app()->session['province_id']);
                } else {
                    Yii::app()->session['province_id'] = $province_id;
                }
                unset(Yii::app()->session['district_id']);
                unset(Yii::app()->session['ward_id']);
            }
            $listdistrict = LibDistricts::getListDistrictFollowProvince($province_id);
            if ($listdistrict) {
                $this->jsonResponse('200', array(
                    'html' => $this->renderPartial('ldistrict', array('listdistrict' => $listdistrict, 'allownull' => $allownull), true),
                ));
            }
        } else {
            $listdistrict = array();
            $this->jsonResponse('200', array(
                'html' => $this->renderPartial('ldistrict', array('listdistrict' => $listdistrict, 'allownull' => $allownull), true),
            ));
        }
    }

    /**
     * get district of province
     */
    function actionGetdistrictDefault() {
        $province_id = Yii::app()->request->getParam('pid');
        $allownull = Yii::app()->request->getParam('allownull', 0);
        $filter = Yii::app()->request->getParam('filter', 0);
        if ($province_id) {
            if ($filter) {
                if ($province_id == 'all') {
                    unset(Yii::app()->session['province_id']);
                } else {
                    Yii::app()->session['province_id'] = $province_id;
                }
                unset(Yii::app()->session['district_id']);
                unset(Yii::app()->session['ward_id']);
            }
            $listdistrict = LibDistricts::getListDistrictFollowProvince($province_id);
            if ($listdistrict) {
                $this->jsonResponse('200', array(
                    'html' => $this->renderPartial('ldistrict_default', array('listdistrict' => $listdistrict, 'allownull' => $allownull), true),
                ));
            }
        } else {
            $listdistrict = array();
            $this->jsonResponse('200', array(
                'html' => $this->renderPartial('ldistrict_default', array('listdistrict' => $listdistrict, 'allownull' => $allownull), true),
            ));
        }
    }

    /**
     * get ward of district
     */
    function actionGetward() {
        $district_id = Yii::app()->request->getParam('did');
        $allownull = Yii::app()->request->getParam('allownull', 0);
        $filter = Yii::app()->request->getParam('filter', 0);
        if ($district_id) {
            if ($filter) {
                if ($district_id == 'all') {
                    unset(Yii::app()->session['district_id']);
                } else {
                    Yii::app()->session['district_id'] = $district_id;
                }
                unset(Yii::app()->session['ward_id']);
            }
            $listward = LibWards::getListWardFollowDistrict($district_id);
            if ($listward) {
                $this->jsonResponse('200', array(
                    'html' => $this->renderPartial('lward', array('listward' => $listward, 'allownull' => $allownull), true),
                ));
            }
        } else {
            $listward = array();
            $this->jsonResponse('200', array(
                'html' => $this->renderPartial('lward', array('listward' => $listward, 'allownull' => $allownull), true),
            ));
        }
    }

    public function actionSetFilterWard() {
        $ward_id = Yii::app()->request->getParam('ward_id', 0);
        if ($ward_id) {
            if ($ward_id == 'all') {
                unset(Yii::app()->session['ward_id']);
            } else {
                Yii::app()->session['ward_id'] = $ward_id;
            }
            $this->jsonResponse(200);
        } else {
            $this->jsonResponse(404);
        }
    }
    function actionGetprovider() {
        $service_id = Yii::app()->request->getParam('sid', 0);
        $allownull = Yii::app()->request->getParam('allownull', 1);
        if ($service_id) {
            $providers = SeProviders::getProviders(array(
                        'service_id' => $service_id,
            ));
            $this->jsonResponse('200', array(
                'html' => $this->renderPartial('lproviders', array('providers' => $providers, 'allownull' => $allownull), true),
            ));
        } else {
            $providers = array();
            $this->jsonResponse('200', array(
                'html' => $this->renderPartial('lproviders', array('providers' => $providers, 'allownull' => $allownull), true),
            ));
        }
    }

}
