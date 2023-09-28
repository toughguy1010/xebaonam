<?php

class ShareholderrelationsController extends BackController
{

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('shareholder_relations', 'shareholder_relations') => Yii::app()->createUrl('/economy/Shareholderrelations'),
            Yii::t('shareholder_relations', 'shareholder_relations_create') => Yii::app()->createUrl('/economy/Shareholderrelations/create'),
        );
        //
        $model = new Shareholderrelations;
        $model->site_id = $this->site_id;
        if (isset($_POST['Shareholderrelations'])) {
            $model->attributes = $_POST['Shareholderrelations'];
            if ($model->site_id !== $this->site_id)
                throw new CHttpException(403, "You don't have permission");
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Thêm mới thành công');
                if (Yii::app()->request->isAjaxRequest) {
                    $this->jsonResponse(200, array(
                        'redirect' => $this->createUrl('/economy/Shareholderrelations'),
                    ));
                } else {
                    $this->redirect(array('index'));
                }
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
    public function actionUpdate($id)
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('shareholder_relations', 'shareholder_relations') => Yii::app()->createUrl('/economy/Shareholderrelations'),
            Yii::t('shareholder_relations', 'shareholder_relations_edit') => Yii::app()->createUrl('/economy/Shareholderrelations/update', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Shareholderrelations'])) {
            $model->attributes = $_POST['Shareholderrelations'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('common', 'updatesuccess'));
                if (Yii::app()->request->isAjaxRequest) {
                    $this->jsonResponse(200, array(
                        'redirect' => $this->createUrl('/economy/Shareholderrelations'),
                    ));
                } else {
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
        $attributeSet = $this->loadModel($id);
        if ($attributeSet->site_id != $this->site_id)
            $this->jsonResponse(400);
        if ($attributeSet->delete()) {
            Yii::app()->user->setFlash('success', 'Xóa nhóm cổ đông thành công');
        } else {
            Yii::app()->user->setFlash('error', 'Lỗi!');
        }
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
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
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('shareholder_relations', 'shareholder_relations') => Yii::app()->createUrl('/economy/Shareholderrelations'),
        );
        //
        $model = new Shareholderrelations('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Shareholderrelations']))
            $model->attributes = $_GET['Shareholderrelations'];
        $model->site_id = $this->site_id;
        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Shareholderrelations the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        //
        $Shareholderrelations = new Shareholderrelations();
        $Shareholderrelations->setTranslate(false);
        //
        $OldModel = $Shareholderrelations->findByPk($id);
        //
        if ($OldModel === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($OldModel->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        if (ClaSite::getLanguageTranslate()) {
            $Shareholderrelations->setTranslate(true);
            $model = $Shareholderrelations->findByPk($id);
            if (!$model) {
                $model = new Shareholderrelations();
                $model->id = $id;
                $model->site_id = $this->site_id;
            }
        } else
            $model = $OldModel;
        //
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Shareholderrelations $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'product-attribute-set-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
