<?php

class ProductWarrantyController extends BackController
{
    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('warranty', 'warranty') => Yii::app()->createUrl('/economy/productwarranty'),
            Yii::t('warranty', 'warranty_create') => Yii::app()->createUrl('/economy/productwarranty/create'),
        );
        $model = new ProductWarranty();
        $model->site_id = $this->site_id;
        //
        $option_product = Product::getAllProductNotlimit('id, name');
        $option_product = array('' => 'Chọn sản phẩm') + $option_product;
        if (isset($_POST['ProductWarranty'])) {
            $model->unsetAttributes();
            $model->attributes = $_POST['ProductWarranty'];
            $model->created_time = time();
            $model->site_id = Yii::app()->controller->site_id;
            if ($model->start_date && $model->start_date != '') {
                $date = DateTime::createFromFormat('d/m/Y', $model->start_date);
                $model->start_date = $date->format('Y-m-d');
            } else {
                $model->start_date = null;
            }
            if ($model->end_date && $model->end_date != '') {
                $date = DateTime::createFromFormat('d/m/Y', $model->end_date);
                $model->end_date = $date->format('Y-m-d');
            } else {
                $model->end_date = null;
            }
            if ($model->save()) {
                $this->redirect(array('index'));
            }else{
                
            }
        }
        $this->render('create', array(
            'model' => $model,
            'option_product' => $option_product
        ));
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
            Yii::t('warranty', 'warranty') => Yii::app()->createUrl('/economy/productwarranty'),
            Yii::t('warranty', 'warranty_edit') => Yii::app()->createUrl('/economy/productupdate', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);
        $model->site_id = $this->site_id;
        //
        $option_product = Product::getAllProductNotlimit('id, name');
        $option_product = array('' => 'Chọn sản phẩm') + $option_product;
        //
        if (isset($_POST['ProductWarranty'])) {
//            $model->unsetAttributes();
            $model->attributes = $_POST['ProductWarranty'];
            $model->modified_time = time();
            $model->site_id = Yii::app()->controller->site_id;
            if ($model->start_date && $model->start_date != '') {
                $date = DateTime::createFromFormat('d/m/Y', $model->start_date);
                $model->start_date = $date->format('Y-m-d');
            } else {
                $model->start_date = null;
            }
            if ($model->end_date && $model->end_date != '') {
                $date = DateTime::createFromFormat('d/m/Y', $model->end_date);
                $model->end_date = $date->format('Y-m-d');
            } else {
                $model->end_date = null;
            }
            if ($model->save()) {
                $this->redirect(array('index'));
            }
        }
        $this->render('update', array(
            'model' => $model,
            'option_product' => $option_product
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $product_warranty = $this->loadModel($id);
        if ($product_warranty->site_id != $this->site_id)
            $this->jsonResponse(400);
        $pro_id = $product_warranty->id;
        if ($product_warranty->delete()) {
//            $product_warrantyInfo = ProductInfo::model()->findByPk($pro_id);
//            $product_warrantyInfo->delete();
        }
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
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
                            $productInfo = ProductInfo::model()->findByPk($pro_id);
                            $productInfo->delete();
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
            Yii::t('warranty', 'warranty_manager') => Yii::app()->createUrl('/economy/product'),
        );
        //
        $model = new ProductWarranty('search');
        $model->unsetAttributes();  // clear any default values
        $model->site_id = $this->site_id;
        if (isset($_GET['ProductWarranty'])) {
            $model->attributes = $_GET['ProductWarranty'];
        }

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Product the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        //
        $ProductWarranty = new ProductWarranty();
        $ProductWarranty->setTranslate(false);
        //
        $OldModel = $ProductWarranty->findByPk($id);
        //
        if ($OldModel === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($OldModel->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
//        if (ClaSite::getLanguageTranslate()) {
//            $ProductWarranty->setTranslate(true);
//            $model = $ProductWarranty->findByPk($id);
//            if (!$model) {
//                $model = new Product();
//                $model->id = $id;
//                $model->attribute_set_id = $OldModel->attribute_set_id;
//                $model->ishot = $OldModel->ishot;
//                $model->product_category_id = $OldModel->product_category_id;
//                $model->status = $OldModel->status;
//                $model->state = $OldModel->state;
//                $model->isnew = $OldModel->isnew;
//                $model->avatar_id = $OldModel->avatar_id;
//                $model->avatar_path = $OldModel->avatar_path;
//                $model->avatar_name = $OldModel->avatar_name;
//                $model->price = $OldModel->price;
//                $model->price_market = $OldModel->price_market;
//                $model->name = $OldModel->name;
//            }
//        } else
        $model = $OldModel;
        //
        return $model;
    }

    public function loadModelProductInfo($id, $noTranslate = false)
    {
        //
        $language = ClaSite::getLanguageTranslate();
        $ProductInfo = new ProductInfo();
        if (!$noTranslate) {
            $ProductInfo->setTranslate(false);
        }
        //
        $OldModel = $ProductInfo->findByPk($id);
        //
        if (!$noTranslate && $language) {
            $ProductInfo->setTranslate(true);
            $model = $ProductInfo->findByPk($id);
            if (!$model) {
                $model = new ProductInfo();
                $model->product_id = $id;
                $model->site_id = Yii::app()->controller->site_id;
            }
        } else {
            $model = $OldModel;
        }
        if ($OldModel && $OldModel->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        //
        return $model;
    }


    public static function deleteDir($dirPath)
    {
        if (!is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

}
