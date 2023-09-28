<?php

class OrderRentSimpleController extends BackController {
    
    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('shoppingcatr', Yii::t('shoppingcart', 'order_manager')) => Yii::app()->createUrl('/economy/orderRentSimple/index')
        );
        $model = new OrderRentSimple('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['OrderRentSimple'])) {
            $model->attributes = $_GET['OrderRentSimple'];
        }
        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        /* Init */
        $this->breadcrumbs = array(
            Yii::t('shoppingcart', Yii::t('shoppingcart', 'order_manager')) => Yii::app()->createUrl('/economy/orderRentSimple'),
            Yii::t('shoppingcart', Yii::t('shoppingcart', 'order_update')) => Yii::app()->createUrl('/economy/orderRentSimple/update', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);
        //
        if (isset($_POST['OrderRentSimple'])) {
            $model->attribute = $_POST['OrderRentSimple'];
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl('economy/orderRentSimple'));
            }
        }
        //
        //
        $this->render('update', array(
            'model' => $model,
        ));
    }
    
    //IN hóa đơn
    public function actionPrintBillAdmin($id) {
        $site = Yii::app()->siteinfo;
        $this->layout = 'disable';
        $model = $this->loadModel($id);
        if ($model->site_id != $this->site_id)
            $this->sendResponse(404);

        $products = OrderProducts::getProductsDetailInOrder($id);

        $paymentmethod = OrderRent::getPaymentMethodInfo($model->payment_method);
        $transportmethod = OrderRent::getTransportMethodInfo($model->transport_method);

        if ($model->viewed == OrderRent::ORDER_NOTVIEWED)
            $model->save();
        $this->render('printbilladmin', array(
            'model' => $model,
            'products' => $products,
            'site' => $site,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $order = $this->loadModel($id);
        if ($order->site_id != $this->site_id)
            $this->jsonResponse(400);
        $order->delete();
// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Xóa các sản phẩm được chọn
     */
    public function actionDeleteall() {
        if (Yii::app()->request->isAjaxRequest) {
            $list_id = Yii::app()->request->getParam('lid');
            if (!$list_id) {
                Yii::app()->end();
            }
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
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return OrderRent the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = OrderRentSimple::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param OrderRent $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'OrderRent-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
