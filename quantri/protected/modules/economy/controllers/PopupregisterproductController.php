<?php

class PopupregisterproductController extends BackController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('product', 'PopupRegisterProducts') => Yii::app()->createUrl('/economy/popupregisterproduct'),
            Yii::t('product', 'PopupRegisterProducts_create') => Yii::app()->createUrl('/economy/popupregisterproduct/create'),
        );
        $model = new PopupRegisterProducts();
        if (Yii::app()->request->isPostRequest && isset($_POST['PopupRegisterProducts'])) {
            $model->attributes = $_POST['PopupRegisterProducts'];
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->avatar_path = $avatar['baseUrl'];
                    $model->avatar_name = $avatar['name'];
                }
            }
            $model->site_id = $this->site_id;
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl("/economy/popupregisterproduct"));
            }
        }
        $this->render("create", array(
            "model" => $model,
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
            Yii::t('product', 'PopupRegisterProducts') => Yii::app()->createUrl('/economy/popupregisterproduct'),
            Yii::t('product', 'PopupRegisterProducts_update') => Yii::app()->createUrl('/economy/popupregisterproduct/update', array('id' => $id)),
        );
        $model = $this->loadModel($id);
        //
        if (isset($_POST['PopupRegisterProducts'])) {
            $model->attributes = $_POST['PopupRegisterProducts'];
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if ($avatar) {
                    $model->avatar_path = $avatar['baseUrl'];
                    $model->avatar_name = $avatar['name'];
                }
            }
            if ($model->save()) {
                if ($model->avatar) {
                    unset(Yii::app()->session[$model->avatar]);
                }
                $this->redirect(Yii::app()->createUrl("economy/popupregisterproduct"));
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
        $PopupRegisterProducts = $this->loadModel($id);
        if ($PopupRegisterProducts->site_id != $this->site_id)
            $this->jsonResponse(400);
        if ($PopupRegisterProducts->delete()) {
            
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
            Yii::t('product', 'PopupRegisterProducts') => Yii::app()->createUrl('/economy/popupregisterproduct'),
        );
        $model = new PopupRegisterProducts('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PopupRegisterProducts']))
            $model->attributes = $_GET['PopupRegisterProducts'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return PopupRegisterProducts the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        //
        $PopupRegisterProducts = new PopupRegisterProducts();
        // $PopupRegisterProducts->setTranslate(false);
        //
        $OldModel = $PopupRegisterProducts->findByPk($id);
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
     * @param PopupRegisterProducts $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'PopupRegisterProducts-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * upload file
     */
    public function actionUploadfile() {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1024 * 8)
                Yii::app()->end();
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'PopupRegisterProducts', 'ava'));
            $up->uploadImage();
            $return = array();
            $response = $up->getResponse(true);
            $return = array('status' => $up->getStatus(), 'data' => $response, 'host' => ClaHost::getImageHost(), 'size' => '');
            if ($up->getStatus() == '200') {
                $keycode = ClaGenerate::getUniqueCode();
                $return['data']['realurl'] = ClaHost::getImageHost() . $response['baseUrl'] . 's100_100/' . $response['name'];
                $return['data']['avatar'] = $keycode;
                Yii::app()->session[$keycode] = $response;
            }
            echo json_encode($return);
            Yii::app()->end();
        }
        //
    }

    public function allowedActions() {
        return 'uploadfile';
    }

}
