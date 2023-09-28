<?php

class MapController extends BackController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $this->breadcrumbs = array(
            Yii::t('map', 'map') => Yii::app()->createUrl('/setting/map'),
            Yii::t('map', 'map_create') => Yii::app()->createUrl('/setting/map/create'),
        );
        $model = new Maps;
        $model->unsetAttributes();  // clear any default values
        $model->site_id = $this->site_id;
        $model->user_id = Yii::app()->user->id;
        $map_api_key = SiteSettings::model()->findByPk($this->site_id)['map_api_key'];
        $isAjax = Yii::app()->request->isAjaxRequest;
        if (isset($_POST['Maps'])) {
            $model->attributes = $_POST['Maps'];
            if ($model->save()) {
                if (!$isAjax)
                    $this->redirect(array('index'));
                else
                    $this->jsonResponse(200, array(
                        'redirect' => Yii::app()->createUrl('/setting/map'),
                    ));
            }else {
                if ($isAjax)
                    $this->jsonResponse(400, array(
                        'errors' => $model->getJsonErrors(),
                    ));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'map_api_key' => $map_api_key,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $this->breadcrumbs = array(
            Yii::t('map', 'map') => Yii::app()->createUrl('/setting/map'),
            Yii::t('map', 'map_update') => Yii::app()->createUrl('/setting/map/update', array('id' => $id)),
        );
        $model = $this->loadModel($id);

        $isAjax = Yii::app()->request->isAjaxRequest;
        $map_api_key = SiteSettings::model()->findByPk($this->site_id)['map_api_key'];
        if (isset($_POST['Maps'])) {
            $model->attributes = $_POST['Maps'];
            if ($model->save()) {
                if (!$isAjax)
                    $this->redirect(array('index'));
                else
                    $this->jsonResponse(200, array(
                        'redirect' => Yii::app()->createUrl('/setting/map'),
                    ));
            }else {
                if ($isAjax)
                    $this->jsonResponse(400, array(
                        'errors' => $model->getJsonErrors(),
                    ));
            }
        }

        $this->render('update', array(
            'model' => $model,
            'map_api_key' => $map_api_key,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        if ($model->site_id == $this->site_id)
            $model->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $this->breadcrumbs = array(
            Yii::t('map', 'map') => Yii::app()->createUrl('/setting/map'),
        );
        $model = new Maps('search');
        $model->unsetAttributes();  // clear any default values
        $model->site_id = $this->site_id;
        $map_api_key = SiteSettings::model()->findByPk($this->site_id)['map_api_key'];
        if (isset($_GET['Maps']))
            $model->attributes = $_GET['Maps'];

        $this->render('index', array(
            'model' => $model,
            'map_api_key' => $map_api_key,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Maps the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        //
        $Maps = new Maps();
        $Maps->setTranslate(false);
        //
        $OldModel = $Maps->findByPk($id);
        //
        if ($OldModel === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($OldModel->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        if (ClaSite::getLanguageTranslate()) {
            $Maps->setTranslate(true);
            $model = $Maps->findByPk($id);
            if (!$model) {
                $model = new Maps();
                $model->id = $id;
                $model->headoffice = $OldModel->headoffice;
                $model->latlng = $OldModel->latlng;
            }
        } else
            $model = $OldModel;
        //
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Maps $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'maps-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
