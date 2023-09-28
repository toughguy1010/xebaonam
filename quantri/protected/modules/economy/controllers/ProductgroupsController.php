<?php

class ProductgroupsController extends BackController
{

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $this->breadcrumbs = array(
            Yii::t('product', 'product_group') => Yii::app()->createUrl('economy/productgroups'),
            Yii::t('product', 'product_group_create') => Yii::app()->createUrl('economy/productgroups/create'),
        );
        //
        $model = new ProductGroups;
        if (isset($_POST['ProductGroups'])) {
            $model->attributes = $_POST['ProductGroups'];
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
                Yii::app()->user->setFlash('success', Yii::t('common', 'createsuccess'));
                $this->redirect(Yii::app()->createUrl('economy/productgroups/update', array('id' => $model->group_id, 'create' => 1)));
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
        $model = $this->loadModel($id);
        //
        $this->breadcrumbs = array(
            Yii::t('product', 'product_group') => Yii::app()->createUrl('economy/productgroups'),
            $model->name => Yii::app()->createUrl('economy/productgroups/update', array('id' => $id)),
        );
        //
        if (isset($_POST['ProductGroups'])) {
            //
            $model->attributes = $_POST['ProductGroups'];
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
                Yii::app()->user->setFlash('success', Yii::t('common', 'updatesuccess'));
                $this->redirect(array('index'));
            }
            //
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDeleteAvatar() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = Yii::app()->request->getParam('id', 0);
            if (isset($id) && $id != 0) {
                $model = $this->loadModel($id);
                if ($model) {
                    $model->image_path = '';
                    $model->image_name = '';
                    $model->save();
                    $this->jsonResponse(200);
                }
            }
            $this->jsonResponse(404);
        }
    }


    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $productgroups = $this->loadModel($id);
        if ($productgroups->site_id != $this->site_id)
            $this->jsonResponse(400);
        $productgroups->delete();
    }

    /**
     * delete a product in group
     * @param type $id
     */
    public function actionDeleteproduct($id)
    {
        $producttogroup = ProductToGroups::model()->findByPk($id);
        if ($producttogroup) {
            if ($producttogroup->site_id != $this->site_id) {
                if (Yii::app()->request->isAjaxRequest)
                    $this->jsonResponse(400);
                else
                    $this->sendResponse(400);
            }
        }
        $producttogroup->delete();
        //
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $this->breadcrumbs = array(
            Yii::t('product', 'product_group') => Yii::app()->createUrl('economy/productgroups')
        );
        $model = new ProductGroups('search');
        $model->unsetAttributes();  // clear any default values
        $model->site_id = $this->site_id;
        if (isset($_GET['ProductGroups']))
            $model->attributes = $_GET['ProductGroups'];
        $model->site_id = $this->site_id;
        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Add product to group
     */
    function actionAddproduct()
    {
        $isAjax = Yii::app()->request->isAjaxRequest;
        $group_id = Yii::app()->request->getParam('gid');
        if (!$group_id)
            $this->jsonResponse(400);
        $model = ProductGroups::model()->findByPk($group_id);
        if (!$model)
            $this->jsonResponse(400);
        if ($model->site_id != $this->site_id)
            $this->jsonResponse(400);
        $this->breadcrumbs = array(
            Yii::t('product', 'product_group') => Yii::app()->createUrl('economy/productgroups'),
            $model->name => Yii::app()->createUrl('economy/productgroups/update', array('id' => $group_id)),
            Yii::t('product', 'product_group_addproduct') => Yii::app()->createUrl('economy/productgroups/addproduct', array('gid' => $group_id)),
        );
        //
        $productModel = new Product('search');
        $productModel->unsetAttributes();  // clear any default values
        $productModel->site_id = $this->site_id;
        if (isset($_GET['Product']))
            $productModel->attributes = $_GET['Product'];
        //
        if (isset($_POST['products'])) {
            $products = $_POST['products'];
            $products = explode(',', $products);
            if (count($products)) {
                $listproducts = ProductGroups::getProductIdInGroup($group_id);
                foreach ($products as $product_id) {
                    if (isset($listproducts[$product_id]))
                        continue;
                    $product = Product::model()->findByPk($product_id);
                    if (!$product || $product->site_id != $this->site_id)
                        continue;
                    Yii::app()->db->createCommand()->insert(Yii::app()->params['tables']['product_to_group'], array(
                        'group_id' => $group_id,
                        'product_id' => $product_id,
                        'site_id' => $this->site_id,
                        'created_time' => time(),
                    ));
                }
                //
                if ($isAjax)
                    $this->jsonResponse(200, array('redirect' => Yii::app()->createUrl('economy/productgroups/update', array('id' => $group_id))));
                else
                    Yii::app()->createUrl('economy/productgroups/update', array('id' => $group_id));
                //
            }
        }
        //
        if ($isAjax) {
            Yii::app()->clientScript->scriptMap = array(
                'jquery.js' => false,
                'jquery.min.js' => false,
                'jquery-ui.min.js' => false,
                'jquery-ui.js' => false,
                'jquery.yiigridview.js' => false,
            );
            $this->renderPartial('addproduct', array('model' => $model, 'productModel' => $productModel, 'isAjax' => $isAjax), false, true);
        } else {
            $this->render('addproduct', array('model' => $model, 'productModel' => $productModel, 'isAjax' => $isAjax));
        }
    }


    /**
     * Updates order of product
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdateOrder($id)
    {

        $item_id = (int)Yii::app()->request->getParam('item_id', 0);
        $order_num = (int)Yii::app()->request->getParam('order_num', 0);
        if ($order_num < 0 || $item_id < 0) {
            $this->jsonResponse(400);
        }
        $itemModel = ProductToGroups::model()->findByPk($item_id);
        if (!$itemModel) {
            $this->jsonResponse(400);
        }
        if ($itemModel->site_id != $itemModel->site_id) {
            $this->jsonResponse(400);
        }
        $itemModel->order = $order_num;
        if ($itemModel->save()) {
            $this->jsonResponse(200, array('redirect' => Yii::app()->createUrl('economy/productgroups/update', array('id' => $id))));

        }


    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ProductGroups the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = ProductGroups::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($model->site_id != $this->site_id) {
            if (Yii::app()->request->isAjaxRequest)
                $this->jsonResponse(400);
            else
                $this->sendResponse(400);
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ProductGroups $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'product-groups-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    /**
     * upload file
     */
    public function actionUploadfile()
    {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1000) {
                Yii::app()->end();
            }
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'product_group', 'ava'));
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

}
