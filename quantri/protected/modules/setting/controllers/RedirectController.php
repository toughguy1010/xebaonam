<?php

class RedirectController extends BackController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('setting', 'config_redirect') => Yii::app()->createUrl('setting/redirect'),
            Yii::t('setting', 'redirect_create') => Yii::app()->createUrl('setting/redirect/create'),
        );
        //
        $model = new Redirects;
        $model->scenario = 'create';
        if (isset($_POST['Redirects'])) {
            $model->attributes = $_POST['Redirects'];
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl('setting/redirect'));
            }
        }

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
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('setting', 'config_redirect') => Yii::app()->createUrl('setting/redirect'),
            Yii::t('setting', 'redirect_create') => Yii::app()->createUrl('setting/redirect/create'),
        );
        //
        $model = $this->loadModel($id);
        if (isset($_POST['Redirects'])) {
            $model->attributes = $_POST['Redirects'];
            if ($model->save()){
                $this->redirect(Yii::app()->createUrl('setting/redirect'));
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
        $model = $this->loadModel($id);
        if ($model->site_id != $this->site_id) {
            if (Yii::app()->request->isAjaxRequest)
                $this->jsonResponse(400);
            else
                $this->sendResponse(400);
        }
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
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
        $this->breadcrumbs = array(
            Yii::t('setting', 'config_redirect') => Yii::app()->createUrl('setting/redirect'),
        );
        $model = new Redirects('search');
        $model->unsetAttributes();  // clear any default values
        $model->site_id = $this->site_id;
        if (isset($_GET['Redirects'])){
            $model->attributes = $_GET['Redirects'];
        }

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Redirects the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Redirects::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Redirects $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'redirects-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
