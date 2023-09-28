<?php

class OfficeImagesController extends BackController
{

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('office', 'Quản lý ảnh văn phòng') => Yii::app()->createUrl('economy/officeImages/'),
            Yii::t('office', 'Tạo mới') => Yii::app()->createUrl('economy/officeImages/create'),
        );
        //
        $model = new OfficeImages();
        $model->unsetAttributes();
        $model->actived = ActiveRecord::STATUS_ACTIVED;

        if (isset($_POST['OfficeImages'])) {
            $model->attributes = $_POST['OfficeImages'];
            $file = $_FILES['src'];
            if ($file && $file['name']) {
                $model->src = 'true';
            }
            //
            if (!$model->getErrors()) {
                $up = new UploadLib($file);
                $up->setPath(array($this->site_id, 'office_image'));
                $up->uploadImage();
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

    public function actionDelimage($iid)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $image = BannerPartial::model()->findByPk($iid);
            if (!$image) {
                $this->jsonResponse(404);
            }
            if ($image->site_id != $this->site_id) {
                $this->jsonResponse(400);
            }
            if ($image->delete()) {
                $this->jsonResponse(200);
            }
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('office', 'Quản lý ảnh văn phòng') => Yii::app()->createUrl('economy/officeImages/'),
            Yii::t('office', 'Cập nhập') => Yii::app()->createUrl('economy/officeImages/update', array('id' => $id)),
        );
        //
        $group_id = Yii::app()->request->getParam('bgid');
        $model = $this->loadModel($id);
        //
        if (isset($_POST['OfficeImages'])) {
            $model->attributes = $_POST['OfficeImages'];

            $file = $_FILES['src'];
            //
            if (!$model->getErrors()) {
                if ($file && $file['name']) {
                    $up = new UploadLib($file);
                    $up->setPath(array($this->site_id, 'office_image'));
                    $up->uploadFile();
                    $response = $up->getResponse(true);
                    if ($up->getStatus() == '200') {
                        $model->src = ClaHost::getMediaBasePath() . $response['baseUrl'] . $response['name'];
                    }
                }
                if ($model->save()) {
                    $this->redirect(array('index'));
                }
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
    public function actionDelete($id)
    {
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

    public function actionDeleteall()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $list_id = Yii::app()->request->getParam('lid');
            if (!$list_id)
                Yii::app()->end();
            $ids = explode(",", $list_id);
            $count = (int)sizeof($ids);
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
    public function actionIndex()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('office', 'Quản lý ảnh văn phòng') => Yii::app()->createUrl('economy/officeImages/'),
        );
        //
        $model = new OfficeImages('search');
        $model->unsetAttributes();  // clear any default values
        $model->site_id = $this->site_id;
        if (isset($_GET['OfficeImages']))
            $model->attributes = $_GET['OfficeImages'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return OfficeImages the loaded model
     * @throws CHttpException
     */
    public function loadModel($id, $noTranslate = false)
    {
        //
        $language = ClaSite::getLanguageTranslate();
        $OfficeImages = new OfficeImages();
        if (!$noTranslate) {
            $OfficeImages->setTranslate(false);
        }
        //
        $OldModel = $OfficeImages->findByPk($id);
        //
        if ($OldModel === NULL && $language == ClaSite::LANGUAGE_DEFAULT)
            throw new CHttpException(404, 'The requested page does not exist.');
        if (!$noTranslate && $language) {
            $OfficeImages->setTranslate(true);
            $model = $OfficeImages->findByPk($id);
            if (!$model) {
                $model = new OfficeImages();
                $model->attributes = $OldModel->attributes;
                $model->id = $id;
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
     * @param OfficeImages $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'banners-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
