<?php

/**
 * @author hungtm 
 * @date 06/01/2016
 */
class SitePaymentController extends BackController {

    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('site', 'manager_site_payment') => Yii::app()->createUrl('setting/sitePayment'),
        );

        $model = new SitePayment();
        $model->site_id = $this->site_id;

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionCreate() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('site', 'manager_site_payment') => Yii::app()->createUrl('setting/sitePayment'),
            Yii::t('site', 'site_payment_create') => Yii::app()->createUrl('setting/sitePayment/create'),
        );

        $model = new SitePayment();

        if (isset($_POST['SitePayment']) && $_POST['SitePayment']) {
            $model->attributes = $_POST['SitePayment'];
            $model->site_id = $this->site_id;
            if ($model->save()) {
                $this->redirect(array('index'));
            }
        }

        $this->render('add', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('site', 'manager_site_payment') => Yii::app()->createUrl('setting/sitePayment'),
            Yii::t('site', 'site_payment_update') => Yii::app()->createUrl('setting/sitePayment/update'),
        );

        $model = $this->loadModel($id);
        if (isset($_POST['SitePayment']) && $_POST['SitePayment']) {
            $model->attributes = $_POST['SitePayment'];
            $model->site_id = $this->site_id;
            if ($model->save()) {
                $this->redirect(array('index'));
            }
        }

        $this->render('add', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $model = $this->loadModel($id);
        $model->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }
    
    public function loadModel($id) {
        $model = SitePayment::model()->findByPk($id);
        if ($model === NULL) {
            $this->sendResponse(404);
        }
        if ($model->site_id != Yii::app()->controller->site_id) {
            $this->sendResponse(404);
        }
        return $model;
    }

}
