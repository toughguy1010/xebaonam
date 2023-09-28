<?php

class FolderController extends ApiController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('file', 'folder_manager') => Yii::app()->createUrl('media/folder'),
            Yii::t('file', 'folder_create') => Yii::app()->createUrl('/meida/folder/create'),
        );
        //
        $isAjax = Yii::app()->request->isAjaxRequest;
        //
        $model = new Folders;
        if (isset($_POST['Folders'])) {
            $model->attributes = $_POST['Folders'];
            if ($model->folder_name) {
                $model->alias = HtmlFormat::parseToAlias($model->folder_name);
            }
            $model->site_id = $this->site_id;
            $model->user_id = Yii::app()->user->id;
            if ($model->save()) {
                if ($isAjax) {
                    $this->jsonResponse(200);
                } else
                    $this->redirect(Yii::app()->createUrl("/media/folder"));
            }
            else {
                if ($isAjax) {
                    $this->jsonResponse(0, array(
                        'errors' => $model->getJsonErrors(),
                    ));
                }
            }
        }
        //
        if ($isAjax) {
            $this->renderPartial('create', array(
                'model' => $model,
                'isAjax' => $isAjax,
                    ), false, true);
        } else {
            $this->render('create', array(
                'model' => $model,
                'isAjax' => $isAjax,
            ));
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('file', 'folder_manager') => Yii::app()->createUrl('media/folder'),
            Yii::t('file', 'folder_edit') => Yii::app()->createUrl('/meida/folder/update', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);
        if ($model->site_id != $this->site_id)
            Yii::app()->end();
        if (isset($_POST['Folders'])) {
            $model->attributes = $_POST['Folders'];
            if (!trim($model->alias) && $model->folder_name) {
                $model->alias = HtmlFormat::parseToAlias($model->folder_name);
            }
            if ($model->save())
                $this->redirect(array('index'));
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
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('file', 'folder_manager') => Yii::app()->createUrl('media/folder'),
        );
        $model = new Folders('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Folders']))
            $model->attributes = $_GET['Folders'];
        //
        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionList() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('file', 'folder_manager') => Yii::app()->createUrl('/media/folder'),
        );
        //
        $folder_id = Yii::app()->request->getParam('fid');
        if (!$folder_id)
            $this->sendResponse(400);
        $folder = Folders::model()->findByPk($folder_id);
        if (!$folder)
            $this->sendResponse(404);
        if ($folder->site_id != $this->site_id)
            $this->sendResponse(404);

        $this->breadcrumbs = array_merge($this->breadcrumbs, array(
            $folder->folder_name => Yii::app()->createUrl('/media/media/list', array('fid' => $folder_id)),
        ));
        $this->render('list', array(
            'folder' => $folder,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Folders the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $Folders = new Folders();
        $Folders->setTranslate(false);
        //
        $OldModel = $Folders->findByPk($id);
        //
        if ($OldModel === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($OldModel->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        if (ClaSite::getLanguageTranslate()) {
            $Folders->setTranslate(true);
            $model = $Folders->findByPk($id);
            if (!$model) {
                $model = new Folders();
                $model->folder_id = $id;
                $model->site_id = $this->site_id;
            }
        } else {
            $model = $OldModel;
        }
        //
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Folders $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'folders-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
