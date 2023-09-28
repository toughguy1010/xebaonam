<?php

class InterpretationOrderController extends BackController
{

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdateUser($id)
    {
        if (isset($_POST['InterpretationOrder'])) {
            $model = $this->loadModel($id);
            $model->user_id = $_POST['InterpretationOrder']['user_id'];
            if ($model->save()) {
                $this->redirect(array('update', 'id' => $id));
            };
        }
    }

    /**
     * Updates a order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        /*Init*/
        $this->breadcrumbs = array(
            Yii::t('shoppingcart', Yii::t('shoppingcart', 'order_manager')) => Yii::app()->createUrl('/economy/translateOrder'),
            Yii::t('shoppingcart', Yii::t('shoppingcart', 'order_update')) => Yii::app()->createUrl('/economy/translateOrder/update', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);
        //
        $items = InterpretationOrderItem::getItemssDetailInOrder($id);
        if (isset($_POST['InterpretationOrder'])) {
            $model->attribute = $_POST['InterpretationOrder'];
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl('economy/order'));
            }
        }
        //
        //
        $this->render('update', array(
            'model' => $model,
            'items' => $items,

        ));
    }

    /**
     * Edit a order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public
    function actionEdit($id)
    {
        /* Init */
        $this->breadcrumbs = array(
            Yii::t('shoppingcart', Yii::t('shoppingcart', 'order_manager')) => Yii::app()->createUrl('/economy/translateOrder'),
            Yii::t('shoppingcart', Yii::t('shoppingcart', 'order_edit')) => Yii::app()->createUrl('/economy/translateOrder/edit', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);
        $modelAttributes = $model->attributes;
        if ($model->site_id != $this->site_id)
            $this->sendResponse(404);
        if ($model->order_status == InterpretationOrder::ORDER_COMPLETE)
            $this->sendResponse(404);
        //
        if ($model->viewed == InterpretationOrder::ORDER_NOTVIEWED)
            $model->viewed = InterpretationOrder::ORDER_VIEWED;
        //
        $products = OrderProducts::getProductsDetailInOrder($id);
        $paymentmethod = InterpretationOrder::getPaymentMethodInfo($model->payment_method);
        $transportmethod = InterpretationOrder::getTransportMethodInfo($model->transport_method);
        $bonusConfig = BonusConfig::checkBonusConfig();
        $orderInfo = $model->attributes;
        $oldtransportmethod = $model->transport_method;
        //
        $error = $model->getErrors();
        if (isset($_POST['InterpretationOrder']) && $model->order_status != InterpretationOrder::ORDER_COMPLETE) {
            $model->order_status = $_POST['InterpretationOrder']['order_status'];
            $model->payment_status = $_POST['InterpretationOrder']['payment_status'];
            $model->transport_status = $_POST['InterpretationOrder']['transport_status'];
            $model->transport_freight = $_POST['InterpretationOrder']['transport_freight'];
            $model->discount_percent = $_POST['InterpretationOrder']['discount_percent'];
            if ($model->validate()) {
                $model->discount_percent = $_POST['InterpretationOrder']['discount_percent'];
                $model->discount_for_dealers = $model->old_order_total * ($model->discount_percent) / 100;
                $model->order_total = $model->old_order_total - $model->discount_for_dealers + $model->transport_freight;
            }

            if ($model->save()) {

                $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                    'mail_key' => 'customerordernotice_update_order',
                ));
                if ($mailSetting) {
                    //Hiện ra danh sách sản phẩm được chọn.
                    $order_prd = $this->renderPartial('_products_bill_admin', array(
                        'products' => $products
                    ), true);
                    // Chi tiết trong thư
                    $detail_order = $data = array(
                        'link' => '<a href="' . Yii::app()->createAbsoluteUrl('/economy/shoppingcart/order', array('id' => $model->order_id, 'key' => $model->key)) . '">Link</a>',
                        'customer_name' => $model->billing_name,
                        'customer_email' => $model->billing_email,
                        'customer_address' => $model->billing_address,
                        'customer_phone' => $model->billing_phone,
                        'order_detail' => $order_prd,
                        'coupon_code' => $model->coupon_code,
                        'order_total' => HtmlFormat::money_format($model->order_total),
                        'old_order_total' => HtmlFormat::money_format($model->old_order_total),
                        'transport_freight' => HtmlFormat::money_format($model->transport_freight),
                        'discount_percent' => '(' . $model->discount_percent . ' %)',
                        'discount' => HtmlFormat::money_format($model->discount_for_dealers)
                    );
                    //
                    $content = $mailSetting->getMailContent($data);
                    //
                    $subject = $mailSetting->getMailSubject($data);
                    //
                    if ($content && $subject) {
                        Yii::app()->mailer->send("", $model->billing_email, $subject, $content);
                    }
                }
                $this->redirect(Yii::app()->createUrl('economy/order'));
//                $this->redirect(Yii::app()->createUrl('economy/order'));
            } else {
                $error = $model->getErrors();
            }
            //
        }
        if ($model->viewed == InterpretationOrder::ORDER_NOTVIEWED) {
            $model->save();
        }
        //
        $this->render('edit', array(
            'error' => $error,
            'model' => $model,
            'products' => $products,
            'paymentmethod' => $paymentmethod,
            'transportmethod' => $transportmethod,
        ));
    }

    //IN hóa đơn
    public function actionPrintBill($id)
    {
        $site = Yii::app()->siteinfo;
        $this->layout = 'disable';
        $model = $this->loadModel($id);
        if ($model->site_id != $this->site_id)
            $this->sendResponse(404);

        $model = $this->loadModel($id);
        //
        $items = InterpretationOrderItem::getItemssDetailInOrder($id);
        //
        $this->render('printbill', array(
            'model' => $model,
            'items' => $items,
            'site' => $site,
        ));
    }


    //IN hóa đơn
    public function actionPrintBillAdmin($id)
    {
        $site = Yii::app()->siteinfo;
        $this->layout = 'disable';
        $model = $this->loadModel($id);
        if ($model->site_id != $this->site_id)
            $this->sendResponse(404);

        $products = OrderProducts::getProductsDetailInOrder($id);

        $paymentmethod = InterpretationOrder::getPaymentMethodInfo($model->payment_method);
        $transportmethod = InterpretationOrder::getTransportMethodInfo($model->transport_method);

        if ($model->viewed == InterpretationOrder::ORDER_NOTVIEWED)
            $model->save();
        $this->render('printbilladmin', array(
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
    function logBonusPoint($model, $bonus_point, $type, $note)
    {
        $bonus_log_use = new BonusPointLog();
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
    public
    function actionDelete($id)
    {
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
    public
    function actionDeleteall()
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
    public
    function actionIndex()
    {
//breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('shoppingcatr', Yii::t('shoppingcart', 'order_manager')) => Yii::app()->createUrl('/economy/translateOrder')
        );
        $model = new InterpretationOrder('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['InterpretationOrder'])) {
            $model->attributes = $_GET['InterpretationOrder'];
//            $model->from_date = $_GET['InterpretationOrder']['from_date'];
//            $model->to_date = $_GET['InterpretationOrder']['to_date'];
        }
        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * export order to csv
     */
    public
    function actionExportcsv()
    {
        $arrFields = array('Khách hàng', 'Email', 'Số điện thoại', 'Số lượng từ', 'Đơn giá', 'Đơn vị tiền tệ', 'Phương thức thanh toán', 'Tình trạng thanh toán', 'Trạng thái', 'Thời gian tạo', 'Người giới thiệu', '% hoa hồng');
        $string = implode("\t", $arrFields) . "\n";

        $TranslateOrder = Yii::app()->db->createCommand()
            ->select('*')
            ->from('interpretation_order t')
            ->where('t.site_id=:site_id', array(':site_id' => Yii::app()->controller->site_id))
            ->order('t.id DESC')
            ->queryAll();
        $status = Orders::getStatusArr();

        foreach ($TranslateOrder as $order) {
            $user = Users::model()->findByPk($order['affiliate_user']);
            $arr = array(
                $order['name'],
                $order['email'],
                "=\"" . (string)$order['tell'] . "\"",
                $order['words'],
                $order['total_price'],
                $order['currency'],
                TranslateOrder::getPaymentMethod()[$order['payment_method']],
                TranslateOrder::getPaymentStatus()[$order['payment_status']],
                $status[$order['status']],
                "=\"" . date('d-m-Y H:i:s', $order['created_time']) . "\"",
                ($user) ? $user->name : '',
                ($user) ? $order['aff_percent'] : '',
            );
            $string .= implode("\t", $arr) . "\n";
        }
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Type: text/csv; charset=utf-8");
        header("Content-Disposition: attachment; filename=" . Yii::app()->siteinfo['domain_default'] . "_" . Date('dmY_hsi') . ".csv");
        header("Content-Transfer-Encoding: binary");

        $string = chr(255) . chr(254) . mb_convert_encoding($string, 'UTF-16LE', 'UTF-8');


        echo $string;
    }

    public
    function actionOrderProduct()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('shoppingcatr', Yii::t('shoppingcart', 'order_manager')) => Yii::app()->createUrl('/economy/translateOrder'),
            Yii::t('shoppingcatr', Yii::t('shoppingcart', 'orderProduct')) => Yii::app()->createUrl('/economy/translateOrder'),
        );
        $model = new OrderProducts('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['OrderProducts'])) {
            $model->attributes = $_GET['OrderProducts'];
            $model->from_date = $_GET['OrderProducts'];
            $model->to_date = $_GET['OrderProducts'];
        }
        $this->render('order_product', array(
            'model' => $model,
        ));
    }

    /**
     * Lists all models.
     */
    public
    function actionUserShoppingCart($id)
    {
//breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('shoppingcart', Yii::t('shoppingcart', 'order_manager')) => Yii::app()->createUrl('/economy/translateOrder'),
            Yii::t('shoppingcart', Yii::t('shoppingcart', 'order_manager')) => Yii::app()->createUrl('/economy/translateOrder'),
        );
//
        $model = new InterpretationOrder('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['InterpretationOrder']))
            $model->attributes = $_GET['InterpretationOrder'];
        $model->user_id = $id;

        $this->render('list_user_order', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return InterpretationOrder the loaded model
     * @throws CHttpException
     */
    public
    function loadModel($id)
    {
        $model = InterpretationOrder::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param InterpretationOrder $model the model to be validated
     */
    protected
    function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'InterpretationOrder-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }



}
