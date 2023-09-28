<?php

/**
 * @minhcoltech
 * suggestController
 * @date 10-30-2013
 */
class SuggestController extends BackController {

    /**
     * suggest category
     */
    function actionCategory() {
        $type = Yii::app()->request->getParam('type');
        //
        $category = new ClaCategory(array('type' => $type, 'showAll' => true, 'create' => true));
        $arr = array('' => Yii::t('category', 'category_parent_0'));
        $options = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $arr);

        $html = $this->renderPartial('sCategory', array(
            'options' => $options,
                ), true);
        //
        $this->jsonResponse(200, array(
            'html' => $html,
        ));
    }

    /**
     * sugguest folder
     */
    function actionFolder() {
        $options = Folders::getFolderOptionsArr();
        //
        $html = $this->renderPartial('sFoldrer', array(
            'options' => $options,
                ), true);
        //
        $this->jsonResponse(200, array(
            'html' => $html,
        ));
    }

    /**
     * 
     * @param type $action
     * @return type
     */
    function beforeAction($action) {
        if (!Yii::app()->request->isAjaxRequest)
            $this->sendResponse(400);
        return parent::beforeAction($action);
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
