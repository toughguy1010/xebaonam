<?php

class PopupregisterproductController extends PublicController {

    public $layout = '//layouts/popupregisterproduct';

    function actionCreater($popup_id) {
        $popup = PopupRegisterProducts::model()->findByPk($popup_id);
        if(!$popup || $popup->site_id != $this->site_id) {
            Yii::app()->user->setFlash('error', Yii::t('common', 'popupregisterproduct_not_invalable'));
            $siteinfo = ClaSite::getSiteInfo();
            Yii::app()->session['site_id'] = Yii::app()->controller->site_id;
            if ($siteinfo['default_page_path']) {
                $this->redirect(Yii::app()->createUrl($siteinfo['default_page_path'], json_decode($siteinfo['default_page_params'])));
            } else {
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }
        $model = new PopupRegisterProductForm();
        if (isset($_POST['PopupRegisterProductForm'])) {
            $model->attributes = $_POST['PopupRegisterProductForm'];
            $model->site_id = $popup->site_id;
            $model->popup_id = $popup->id;
            $model->product_id = $popup->product_id;
            if ($model->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    $this->jsonResponse(200, array());
                }
                Yii::app()->user->setFlash('success', Yii::t('user', 'popupregisterproduct_success'));
                $siteinfo = ClaSite::getSiteInfo();
                Yii::app()->session['site_id'] = Yii::app()->controller->site_id;
                if ($siteinfo['default_page_path']) {
                    $this->redirect(Yii::app()->createUrl($siteinfo['default_page_path'], json_decode($siteinfo['default_page_params'])));
                } else {
                    $this->redirect(Yii::app()->user->returnUrl);
                }
            } else {
                if (Yii::app()->request->isAjaxRequest) {
                    $this->jsonResponse(400, array(
                        'errors' => $model->getJsonErrors(),
                    ));
                }
            }
        }
        $this->render('creater', array('model' => $model)); 
    }

}
