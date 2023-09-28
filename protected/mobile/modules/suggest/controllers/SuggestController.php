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
        if ($province_id) {
            $listdistrict = LibDistricts::getListDistrictFollowProvince($province_id);
            if ($listdistrict) {
                $this->jsonResponse('200', array(
                    'html' => $this->renderPartial('ldistrict', array('listdistrict' => $listdistrict), true),
                ));
            }
        } else {
            $listdistrict = array();
            $this->jsonResponse('200', array(
                'html' => $this->renderPartial('ldistrict', array('listdistrict' => $listdistrict), true),
            ));
        }
    }

    /**
     * get ward of district
     */
    function actionGetward() {
        $district_id = Yii::app()->request->getParam('did');
        if ($district_id) {
            $listward = LibWards::getListWardFollowDistrict($district_id);
            if ($listward) {
                $this->jsonResponse('200', array(
                    'html' => $this->renderPartial('lward', array('listward' => $listward), true),
                ));
            }
        } else {
            $listward = array();
            $this->jsonResponse('200', array(
                'html' => $this->renderPartial('lward', array('listward' => $listward), true),
            ));
        }
    }

}
