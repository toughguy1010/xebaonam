<?php

class OrderController extends PublicController {

    public $layout = '//layouts/admin_column2';

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdateUser($id) {
        if (isset($_POST['Orders'])) {
            $model = $this->loadModel($id);
            $model->user_id = $_POST['Orders']['user_id'];
            if ($model->save()) {
                $this->redirect(array('update', 'id' => $id));
            };
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
//breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('shoppingcart', Yii::t('shoppingcart', 'order_manager')) => Yii::app()->createUrl('/economy/order'),
            Yii::t('shoppingcart', Yii::t('shoppingcart', 'order_update')) => Yii::app()->createUrl('/economy/order/update', array('id' => $id)),
        );

        $shop = Shop::getCurrentShop();

        if (!$shop) {
            $this->sendResponse(404);
        }
//
        $model = $this->loadModel($id);
        if ($model->site_id != $this->site_id) {
            $this->sendResponse(404);
        }
        if ($model->shop_id != $shop['id']) {
            $this->sendResponse(404);
        }
//
        if ($model->viewed == Orders::ORDER_NOTVIEWED) {
            $model->viewed = Orders::ORDER_VIEWED;
        }
//
        $products = OrderProducts::getProductsDetailInOrder($id);
//
        $paymentmethod = Orders::getPaymentMethodInfo($model->payment_method);
        $transportmethod = Orders::getTransportMethodInfo($model->transport_method);
        $bonusconfig = BonusConfig::checkBonusConfig();
        if (isset($_POST['Orders'])) {
            $old_order_status = $model->order_status;
            $model->order_status = $_POST['Orders']['order_status'];
            $model->payment_status = $_POST['Orders']['payment_status'];
            $model->transport_status = $_POST['Orders']['transport_status'];
            //Trạng thái đơn hàng hoàn thành cộng điểm
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl('economy/order'));
            }
        }
        if ($model->viewed == Orders::ORDER_NOTVIEWED) {
            $model->save();
        }
       
        $this->render('update', array(
            'error' => $error,
            'model' => $model,
            'products' => $products,
            'paymentmethod' => $paymentmethod,
            'transportmethod' => $transportmethod,
        ));
    }

    //IN hóa đơn
    public function actionPrintBill($id) {
        $site = Yii::app()->siteinfo;
        $this->layout = 'disable';
        $model = $this->loadModel($id);
        if ($model->site_id != $this->site_id)
            $this->sendResponse(404);

        $products = OrderProducts::getProductsDetailInOrder($id);

        $paymentmethod = Orders::getPaymentMethodInfo($model->payment_method);
        $transportmethod = Orders::getTransportMethodInfo($model->transport_method);

        if ($model->viewed == Orders::ORDER_NOTVIEWED)
            $model->save();
        $this->render('printbill', array(
            'error' => $error,
            'model' => $model,
            'products' => $products,
            'site' => $site,
        ));
    }

    /**
     * Thao tác với điểm cộng.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    function logBonusPoint($model, $bonus_point, $type, $note) {
        $bonus_log_use = new BonusPoint();
        $bonus_log_use->user_id = $model->user_id;
        $bonus_log_use->site_id = Yii::app()->controller->site_id;
        $bonus_log_use->order_id = $model->order_id;
        $bonus_log_use->point = $bonus_point;
        $bonus_log_use->type = $type; //type điểm cộng
        $bonus_log_use->created_time = time();
        $bonus_log_use->note = $note;
        if ($bonus_log_use->save()) {
            return true;
        }
        return false;
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
//breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('shoppingcart', Yii::t('shoppingcart', 'order_manager')) => Yii::app()->createUrl('/economy/order'),
        );
//
        $model = new Orders('search');
        $model->unsetAttributes();  // clear any default values
        $shop = Shop::getCurrentShop();
        $model->shop_id = $shop['id'];
        if (isset($_GET['Orders']))
            $model->attributes = $_GET['Orders'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionUserShoppingCart($id) {
//breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('shoppingcart', Yii::t('shoppingcart', 'order_manager')) => Yii::app()->createUrl('/economy/order'),
            Yii::t('shoppingcart', Yii::t('shoppingcart', 'order_manager')) => Yii::app()->createUrl('/economy/order'),
        );
//
        $model = new Orders('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Orders']))
            $model->attributes = $_GET['Orders'];
        $model->user_id = $id;

        $this->render('list_user_order', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Orders the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Orders::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Orders $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'orders-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
