<?php

class ProductRentController extends BackController
{

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $this->breadcrumbs = array(
            Yii::t('product', 'product_group') => Yii::app()->createUrl('economy/productRent'),
            Yii::t('product', 'product_group_create') => Yii::app()->createUrl('economy/productRent/create'),
        );
        //
        $model = new ProductRent();
        if (isset($_POST['ProductRent'])) {
            $model->attributes = $_POST['ProductRent'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('common', 'createsuccess'));
                $this->redirect(array('index'));
//                $this->redirect(Yii::app()->createUrl('economy/productRent/update', array('id' => $model->group_id, 'create' => 1)));
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
            Yii::t('product', 'product_group') => Yii::app()->createUrl('economy/productRent'),
            $model->name => Yii::app()->createUrl('economy/productRent/update', array('id' => $id)),
        );
        //
        if (isset($_POST['ProductRent'])) {
            //
            $model->attributes = $_POST['ProductRent'];
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


    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $productrent = $this->loadModel($id);
        if ($productrent->site_id != $this->site_id)
            $this->jsonResponse(400);
        $productrent->delete();
    }

    /**
     * delete a product in group
     * @param type $id
     */
    public function actionDeleteproduct($id)
    {
        $producttorent = ProductToRent::model()->findByPk($id);
        if ($producttorent) {
            if ($producttorent->site_id != $this->site_id) {
                if (Yii::app()->request->isAjaxRequest)
                    $this->jsonResponse(400);
                else
                    $this->sendResponse(400);
            }
        }
        $producttorent->delete();
        $this->redirect( Yii::app()->createUrl('economy/productRent/view', array('id' => $producttorent->rent_id)));
        //
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $this->breadcrumbs = array(
            Yii::t('product', 'product_group') => Yii::app()->createUrl('economy/productRent')
        );
        $model = new ProductRent('search');
        $model->unsetAttributes();  // clear any default values
        $model->site_id = $this->site_id;
        if (isset($_GET['ProductRent']))
            $model->attributes = $_GET['ProductRent'];
        $model->site_id = $this->site_id;
        $this->render('index', array(
            'model' => $model,
        ));
    }


    /**
     * Add product to group
     */
    function actionAddproduct($gid)
    {
        $isAjax = Yii::app()->request->isAjaxRequest;
        $group_id = $gid;
        if (!$group_id)
            $this->jsonResponse(400);
        $rentGroup = ProductRent::model()->findByPk($group_id);
        $model = new ProductToRent();
        if (!$rentGroup)
            $this->jsonResponse(400);
        $this->breadcrumbs = array(
            Yii::t('product', 'product_rent_group') => Yii::app()->createUrl('economy/productRent'),
            Yii::t('product', 'list_product_rent') => Yii::app()->createUrl('economy/productRent/view', array('id' => $gid)),
            Yii::t('product', 'product_to_rent_create') => '',
        );
        //
        $productModel = new Product('search');
        $productModel->unsetAttributes();  // clear any default values
        $productModel->site_id = $this->site_id;
        if (isset($_GET['Product']))
            $productModel->attributes = $_GET['Product'];
        //

        $option_product = Product::getAllProductNotlimit('id, name');
        $option_product = array('' => 'Chọn sản phẩm') + $option_product;

        if (isset($_POST['ProductToRent'])) {
            $product_id = $_POST['ProductToRent']['product_id'];
            $product = Product::model()->findByPk($product_id);
            if ($product || $product->site_id == $this->site_id){
                $model->attributes = $_POST['ProductToRent'];
                $model->status = ActiveRecord::STATUS_ACTIVED;
                $model->created_time = time();
                $model->rent_id = $rentGroup->rent_id;
                $model->site_id = $this->site_id;
                if ($model->price_day_1)
                    $model->price_day_1 = str_replace('.','',$model->price_day_1);
                if ($model->price_day_2)
                    $model->price_day_2 = str_replace('.','',$model->price_day_2);
                if ($model->price_day_3)
                    $model->price_day_3 = str_replace('.','',$model->price_day_3);
                if($model->save())
                    $this->redirect( Yii::app()->createUrl('economy/productRent/view', array('id' => $group_id)));
            }
        }
        $this->render('createProductInGroup',
            array('model' => $model,
                'productModel' => $productModel,
                'isAjax' => $isAjax,
                'option_product' => $option_product
            ));
    }

    /**
     * Lists all models.
     */
    public function actionView($id)
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('product', 'product_rent_group') => Yii::app()->createUrl('economy/productRent'),
            Yii::t('product', 'list_product_rent') => Yii::app()->createUrl('economy/productRent/addproduct', array('gid' => $id)),

        );
        //
        $model = new ProductToRent('search');
        $model->unsetAttributes();  // clear any default values
        $model->site_id = $this->site_id;
        $model->rent_id = $id;
        if (isset($_GET['ProductRent'])) {
            $model->attributes = $_GET['ProductRent'];
        }

        $this->render('products', array(
            'model' => $model,
        ));
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
        $itemModel = ProductToRent::model()->findByPk($item_id);
        if (!$itemModel) {
            $this->jsonResponse(400);
        }
        if ($itemModel->site_id != $itemModel->site_id) {
            $this->jsonResponse(400);
        }
        $itemModel->order = $order_num;
        if ($itemModel->save()) {
            $this->jsonResponse(200, array('redirect' => Yii::app()->createUrl('economy/productRent/view', array('id' => $id))));

        }


    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ProductRent the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = ProductRent::model()->findByPk($id);
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
     * @param ProductRent $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'product-rent-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
