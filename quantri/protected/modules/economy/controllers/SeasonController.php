<?php

class SeasonController extends BackController
{

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('product', 'season') => Yii::app()->createUrl('/economy/season'),
            Yii::t('product', 'season_create') => Yii::app()->createUrl('/economy/season/create'),
        );
        $model = new Season();
        $isAjax = Yii::app()->request->isAjaxRequest;
        if (Yii::app()->request->isPostRequest && isset($_POST['Season'])) {
            $model->attributes = $_POST['Season'];
            if ($model->save()) {
                if ($isAjax) {
                    $this->jsonResponse(200);
                } else
                    $this->redirect(Yii::app()->createUrl("/economy/season"));
            } else {
                if ($isAjax) {
                    $this->jsonResponse(0, array(
                        'errors' => $model->getJsonErrors(),
                    ));
                }
            }
        }
        if ($isAjax) {
            $this->renderPartial("create", array(
                "model" => $model,
                'isAjax' => $isAjax,
            ), false, true);
        } else {
            $this->render("create", array(
                "model" => $model,
                'isAjax' => $isAjax,
            ));
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('product', 'season') => Yii::app()->createUrl('/economy/season'),
            Yii::t('product', 'season_update') => Yii::app()->createUrl('/economy/season/update', array('id' => $id)),
        );
        $model = $this->loadModel($id);
        //
        if (isset($_POST['Season'])) {
            $model->attributes = $_POST['Season'];
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl("economy/season"));
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
        $season = $this->loadModel($id);
        if ($season->site_id != $this->site_id)
            $this->jsonResponse(400);
        if ($season->delete()) {

        }
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Xóa các sản phẩm được chọn
     */
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
                    $pro_id = $model->id;
                    if ($model->site_id == $this->site_id) {
                        if ($model->delete()) {

                        }
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
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('product', 'season') => Yii::app()->createUrl('/economy/season'),
        );
        $model = new Season('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Season']))
            $model->attributes = $_GET['Season'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Season the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        //
        $Season = new Season();
        $Season->setTranslate(false);
        //
        $OldModel = $Season->findByPk($id);
        //
        if ($OldModel === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($OldModel->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        if (ClaSite::getLanguageTranslate()) {
            $Season->setTranslate(true);
            $model = $Season->findByPk($id);
            if (!$model) {
                $model = new Season();
                $model->id = $id;
                $model->image_path = $OldModel->image_path;
                $model->image_name = $OldModel->image_name;
                $model->order = $OldModel->order;
            }
        } else
            $model = $OldModel;
        //
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Season $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'season-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function allowedActions()
    {
        return 'uploadfile';
    }

}
