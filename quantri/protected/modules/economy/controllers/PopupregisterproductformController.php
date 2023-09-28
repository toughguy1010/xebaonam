<?php

class PopupregisterproductformController extends BackController {

    /**
    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('product', 'PopupRegisterProductForm') => Yii::app()->createUrl('/economy/popupregisterproductform'),
            Yii::t('product', 'PopupRegisterProductForm_update') => Yii::app()->createUrl('/economy/popupregisterproductform/update', array('id' => $id)),
        );
        $model = $this->loadModel($id);
        //
        if (isset($_POST['PopupRegisterProductForm'])) {
            $model->attributes = $_POST['PopupRegisterProductForm'];
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl("economy/popupregisterproductform"));
            }
        }
        $this->render('update', array(
            'model' => $model,
            'listprovince' => Province::getAllProvinceArr(false),
            'listdistrict' => LibDistricts::getOptionDistrictFromProvince($model->province_id),
            'listward' => LibWards::getListWardArr($model->district_id),
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $PopupRegisterProductForm = $this->loadModel($id);
        if ($PopupRegisterProductForm->site_id != $this->site_id)
            $this->jsonResponse(400);
        if ($PopupRegisterProductForm->delete()) {
            
        }
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }


    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('product', 'PopupRegisterProductForm') => Yii::app()->createUrl('/economy/popupregisterproductform'),
        );
        $model = new PopupRegisterProductForm('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PopupRegisterProductForm']))
            $model->attributes = $_GET['PopupRegisterProductForm'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return PopupRegisterProductForm the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        //
        $PopupRegisterProductForm = new PopupRegisterProductForm();
        // $PopupRegisterProductForm->setTranslate(false);
        //
        $OldModel = $PopupRegisterProductForm->findByPk($id);
        //
        if ($OldModel === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($OldModel->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        $model = $OldModel;
        //
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param PopupRegisterProductForm $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'PopupRegisterProductForm-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
