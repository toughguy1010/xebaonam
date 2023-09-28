<?php

class GiftCardCampaignController extends BackController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        //breadcrumbs
        $this->breadcrumbs = array(
            'Campaign' => Yii::app()->createUrl('banner/giftCardCampaign/'),
            'Create new campaign' => Yii::app()->createUrl('banner/giftCardCampaign/create'),
        );
        //
        $model = new GiftCardCampaign;
        $model->unsetAttributes();
        $model->status = ActiveRecord::STATUS_ACTIVED;
        // default value
        $model->price_type = 1;
        $model->expiration = 1;
        $model->sales_limit = 1;
        $model->sales_period = 1;
        //
        if (isset($_POST['GiftCardCampaign']) && $_POST['GiftCardCampaign']) {
            $model->attributes = $_POST['GiftCardCampaign'];
            if ($model->save()) {
                $this->redirect(array('index'));
            }
        }
        //
        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        //breadcrumbs
        $this->breadcrumbs = array(
            'Campaign' => Yii::app()->createUrl('banner/giftCardCampaign/'),
            'Update campaign' => Yii::app()->createUrl('banner/giftCardCampaign/update'),
        );
        //
        $model = $this->loadModel($id);
        //
        if (isset($_POST['GiftCardCampaign']) && $_POST['GiftCardCampaign']) {
            $model->attributes = $_POST['GiftCardCampaign'];
            if ($model->save()) {
                $this->redirect(array('index'));
            }
        }
        //
        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id, true);
        if ($model->site_id != $this->site_id) {
            if (Yii::app()->request->isAjaxRequest)
                $this->jsonResponse(400);
            else
                $this->sendResponse(400);
        }
        $model->delete();
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionDeleteall() {
        if (Yii::app()->request->isAjaxRequest) {
            $list_id = Yii::app()->request->getParam('lid');
            if (!$list_id)
                Yii::app()->end();
            $ids = explode(",", $list_id);
            $count = (int) sizeof($ids);
            for ($i = 0; $i < $count; $i++) {
                if ($ids[$i]) {
                    $model = $this->loadModel($ids[$i]);
                    if ($model->site_id == $this->site_id) {
                        $model->delete();
                    }
                }
            }
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        // breadcrumbs
        $this->breadcrumbs = array(
            'Gift card' => Yii::app()->createUrl('banner/giftCard/'),
        );
        //
        $model = new GiftCardCampaign('search');
        $model->unsetAttributes();  // clear any default values
        $model->site_id = $this->site_id;
//        $giftcards = GiftCardCampaign::getGiftCardCampaigns();
        if (isset($_GET['GiftCardCampaign'])) {
            $model->attributes = $_GET['GiftCardCampaign'];
        }
        $this->render('index', array(
            'model' => $model,
//            'giftcards' => $giftcards,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return GiftCardCampaign the loaded model
     * @throws CHttpException
     */
    public function loadModel($id, $noTranslate = false) {
        //
        $language = ClaSite::getLanguageTranslate();
        $GiftCardCampaign = new GiftCardCampaign();
        if (!$noTranslate) {
            $GiftCardCampaign->setTranslate(false);
        }
        //
        $OldModel = $GiftCardCampaign->findByPk($id);
        //
        if ($OldModel === NULL && $language == ClaSite::getDefaultLanguage())
            throw new CHttpException(404, 'The requested page does not exist.');
        if (!$noTranslate && $language) {
            $GiftCardCampaign->setTranslate(true);
            $model = $GiftCardCampaign->findByPk($id);
            if (!$model) {
                $model = new GiftCardCampaign();
                $model->attributes = $OldModel->attributes;
                $model->id = $id;
//                $model->banner_group_id = $OldModel->banner_group_id;
//                $model->banner_width = $OldModel->banner_width;
//                $model->banner_height = $OldModel->banner_height;
//                $model->banner_order = $OldModel->banner_order;
//                $model->banner_rules = $OldModel->banner_rules;
//                $model->banner_target = $OldModel->banner_target;
//                $model->banner_showall = $OldModel->banner_showall;
//                $model->actived = $OldModel->actived;
            }
        } else {
            $model = $OldModel;
        }
        if ($model->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        //
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param GiftCardCampaign $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'banners-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
