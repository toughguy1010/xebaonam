<?php

class ManufacturerController extends BackController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('product', 'manufacturer') => Yii::app()->createUrl('/economy/manufacturer'),
            Yii::t('product', 'manufacturer_create') => Yii::app()->createUrl('/economy/manufacturer/create'),
        );
        $model = new Manufacturer();
        $isAjax = Yii::app()->request->isAjaxRequest;
        if (Yii::app()->request->isPostRequest && isset($_POST['Manufacturer'])) {
            $model->attributes = $_POST['Manufacturer'];
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }
            if ($model->save()) {
                $manufacturerInfo = new ManufacturerInfo();
                $manufacturerInfo->attributes = $_POST['Manufacturer'];
                $manufacturerInfo->manufacturer_id = $model->id;
                //
                $manufacturerInfo->save();
                //
                unset(Yii::app()->session[$model->avatar]);
                if ($isAjax) {
                    $this->jsonResponse(200);
                } else
                    $this->redirect(Yii::app()->createUrl("/economy/manufacturer"));
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
    public function actionUpdate($id) {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('product', 'manufacturer') => Yii::app()->createUrl('/economy/manufacturer'),
            Yii::t('product', 'manufacturer_update') => Yii::app()->createUrl('/economy/manufacturer/update', array('id' => $id)),
        );
        $model = $this->loadModel($id);
        $modelInfo = $this->loadModelInfo($id);
        $model->attributes = $modelInfo->attributes;
        //
        if (isset($_POST['Manufacturer'])) {
            $model->attributes = $_POST['Manufacturer'];
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if ($avatar) {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }
            if ($model->save()) {
                $modelInfo->attributes = $_POST['Manufacturer'];
                $modelInfo->save();
                //
                if ($model->avatar)
                    unset(Yii::app()->session[$model->avatar]);
                $this->redirect(Yii::app()->createUrl("economy/manufacturer"));
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
        $manufacturer = $this->loadModel($id);
        if ($manufacturer->site_id != $this->site_id)
            $this->jsonResponse(400);
        if ($manufacturer->delete()) {
            
        }
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Xóa các sản phẩm được chọn
     */
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
    public function actionIndex() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('product', 'manufacturer') => Yii::app()->createUrl('/economy/manufacturer'),
        );
        $model = new Manufacturer('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Manufacturer']))
            $model->attributes = $_GET['Manufacturer'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Manufacturer the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        //
        $Manufacturer = new Manufacturer();
        $Manufacturer->setTranslate(false);
        //
        $OldModel = $Manufacturer->findByPk($id);
        //
        if ($OldModel === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($OldModel->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        if (ClaSite::getLanguageTranslate()) {
            $Manufacturer->setTranslate(true);
            $model = $Manufacturer->findByPk($id);
            if (!$model) {
                $model = new Manufacturer();
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

    public function loadModelInfo($id) {
        //
        $ManufacturerInfo = new ManufacturerInfo();
        $ManufacturerInfo->setTranslate(false);
        //
        $OldModel = ManufacturerInfo::model()->findByPk($id);
        //
        if ($OldModel === NULL){
            $OldModel = new ManufacturerInfo();
            $OldModel->manufacturer_id = $id;
        }
//        if ($OldModel->site_id != $this->site_id)
//            throw new CHttpException(404, 'The requested page does not exist.');
        if (ClaSite::getLanguageTranslate()) {
            $ManufacturerInfo->setTranslate(true);
            $model = $ManufacturerInfo->findByPk($id);
            if (!$model) {
                $model = new ManufacturerInfo();
                $model->manufacturer_id = $id;
            }
        } else
            $model = $OldModel;
        //
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Manufacturer $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'manufacturer-form') {
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
            if ($file['size'] > 1024 * 1000)
                Yii::app()->end();
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'manufacturer', 'ava'));
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
