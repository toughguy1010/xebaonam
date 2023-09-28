<?php

class GiftCardController extends BackController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        //breadcrumbs
        $this->breadcrumbs = array(
            'Gift card' => Yii::app()->createUrl('banner/giftCard/'),
            'Create gift card' => Yii::app()->createUrl('banner/giftCard/create'),
        );
        //
        $model = new GiftCard;
        $model->unsetAttributes();
        $model->status = ActiveRecord::STATUS_ACTIVED;
        //
        $model->order = 0;
        if (isset($_POST['GiftCard'])) {
            $model->attributes = $_POST['GiftCard'];

            $file = $_FILES['src'];

            if ($file && $file['name']) {
                $model->src = 'true';
                $extensions = GiftCard::allowExtensions();
                if (!isset($extensions[$file['type']]))
                    $model->addError('src', Yii::t('banner', 'banner_invalid_format'));
            }
            //
            if (!$model->getErrors()) {
                $up = new UploadLib($file);
                $up->setPath(array($this->site_id, 'banners'));
//                $up->setForceSize(array((int) $model->banner_width, (int) $model->banner_height));
                $up->uploadFile();
                $response = $up->getResponse(true);
                //
                if ($up->getStatus() == '200') {
                    $model->src = ClaHost::getMediaBasePath() . $response['baseUrl'] . $response['name'];
                } else {
                    $model->src = '';
                }
                //
                if ($model->save()) {
                    $this->redirect(array('index'));
                }
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
            'Gift card' => Yii::app()->createUrl('banner/giftCard/'),
            'Create gift card' => Yii::app()->createUrl('banner/giftCard/update', array('id' => $id)),
        );
        //
        $banner_group_id = Yii::app()->request->getParam('bgid');
        $model = $this->loadModel($id);
        //
        if (isset($_POST['GiftCard'])) {
            $model->attributes = $_POST['GiftCard'];

            $file = $_FILES['src'];

            if ($file && $file['name']) {
                $model->src = 'true';
                $extensions = GiftCard::allowExtensions();
                if (!isset($extensions[$file['type']]))
                    $model->addError('src', Yii::t('banner', 'banner_invalid_format'));

                //
                if (!$model->getErrors()) {
                    $up = new UploadLib($file);
                    $up->setPath(array($this->site_id, 'banners'));
//                $up->setForceSize(array((int) $model->banner_width, (int) $model->banner_height));
                    $up->uploadFile();
                    $response = $up->getResponse(true);
                    //
                    if ($up->getStatus() == '200') {
                        $model->src = ClaHost::getMediaBasePath() . $response['baseUrl'] . $response['name'];
                    } else {
                        $model->src = '';
                    }
                    //
                }
            }
            if ($model->save()) {
                $this->redirect(array('index'));
            }
        }

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
        $model = new GiftCard('search');
        $model->unsetAttributes();  // clear any default values
        $model->site_id = $this->site_id;
//        $giftcards = GiftCard::getGiftCards();
        if (isset($_GET['GiftCard'])) {
            $model->attributes = $_GET['GiftCard'];
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
     * @return GiftCard the loaded model
     * @throws CHttpException
     */
    public function loadModel($id, $noTranslate = false) {
        //
        $language = ClaSite::getLanguageTranslate();
        $GiftCard = new GiftCard();
        if (!$noTranslate) {
            $GiftCard->setTranslate(false);
        }
        //
        $OldModel = $GiftCard->findByPk($id);
        //
        if ($OldModel === NULL && $language == ClaSite::getDefaultLanguage())
            throw new CHttpException(404, 'The requested page does not exist.');
        if (!$noTranslate && $language) {
            $GiftCard->setTranslate(true);
            $model = $GiftCard->findByPk($id);
            if (!$model) {
                $model = new GiftCard();
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
     * @param GiftCard $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'banners-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
