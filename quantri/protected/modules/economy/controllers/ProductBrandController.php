<?php

class ProductBrandController extends BackController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('product', 'product_brand') => Yii::app()->createUrl('/economy/productBrand'),
            Yii::t('product', 'product_brand_create') => Yii::app()->createUrl('/economy/productBrand/create'),
        );
        $model = new ProductBrand();
        $isAjax = Yii::app()->request->isAjaxRequest;
        if (Yii::app()->request->isPostRequest && isset($_POST['ProductBrand'])) {
            $model->attributes = $_POST['ProductBrand'];
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
                $prdBrandInfo = new ProductBrandInfo();
                $prdBrandInfo->attributes = $_POST['ProductBrand'];
                $prdBrandInfo->product_brand_id = $model->id;
                //
                $prdBrandInfo->save();
                //
                unset(Yii::app()->session[$model->avatar]);
                if ($isAjax) {
                    $this->jsonResponse(200);
                } else
                    $this->redirect(Yii::app()->createUrl("/economy/productBrand"));
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
            Yii::t('product', 'product_brand') => Yii::app()->createUrl('/economy/productBrand'),
            Yii::t('product', 'product_brand_update') => Yii::app()->createUrl('/economy/productBrand/update', array('id' => $id)),
        );
        $model = $this->loadModel($id);
        $modelInfo = $this->loadModelInfo($id);
        $model->attributes = $modelInfo->attributes;
        //
        if (isset($_POST['ProductBrand'])) {
            $model->attributes = $_POST['ProductBrand'];
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if ($avatar) {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }
            if ($model->save()) {
                $modelInfo->attributes = $_POST['ProductBrand'];
                $modelInfo->save();
                //
                if ($model->avatar)
                    unset(Yii::app()->session[$model->avatar]);
                $this->redirect(Yii::app()->createUrl("economy/productBrand"));
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
        $prdBrand = $this->loadModel($id);
        if ($prdBrand->site_id != $this->site_id)
            $this->jsonResponse(400);
        if ($prdBrand->delete()) {
            
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
            Yii::t('product', 'product_brand') => Yii::app()->createUrl('/economy/productBrand'),
        );
        $model = new ProductBrand('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ProductBrand']))
            $model->attributes = $_GET['ProductBrand'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ProductBrand the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        //
        $ProductBrand = new ProductBrand();
        $ProductBrand->setTranslate(false);
        //
        $OldModel = $ProductBrand->findByPk($id);
        //
        if ($OldModel === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($OldModel->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        if (ClaSite::getLanguageTranslate()) {
            $ProductBrand->setTranslate(true);
            $model = $ProductBrand->findByPk($id);
            if (!$model) {
                $model = new ProductBrand();
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
        $ProductBrandInfo = new ProductBrandInfo();
        $ProductBrandInfo->setTranslate(false);
        //
        $OldModel = $ProductBrandInfo->findByPk($id);
        //
        if ($OldModel === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($OldModel->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        if (ClaSite::getLanguageTranslate()) {
            $ProductBrandInfo->setTranslate(true);
            $model = $ProductBrandInfo->findByPk($id);
            if (!$model) {
                $model = new ProductBrandInfo();
                $model->product_brand_id = $id;
            }
        } else
            $model = $OldModel;
        //
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ProductBrand $model the model to be validated
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
            $up->setPath(array($this->site_id, 'product_brand', 'ava'));
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
