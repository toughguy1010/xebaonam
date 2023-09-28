<?php

class OrderController extends BackController
{

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdateUser($id)
    {
        if (isset($_POST['Orders'])) {
            $model = $this->loadModel($id);
            $model->user_id = $_POST['Orders']['user_id'];
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
            Yii::t('shoppingcart', Yii::t('shoppingcart', 'order_manager')) => Yii::app()->createUrl('/economy/order'),
            Yii::t('shoppingcart', Yii::t('shoppingcart', 'order_update')) => Yii::app()->createUrl('/economy/order/update', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);

        if ($model->site_id != $this->site_id)
            $this->sendResponse(404);
        //
        if ($model->viewed == Orders::ORDER_NOTVIEWED)
            $model->viewed = Orders::ORDER_VIEWED;
        //
        $products = OrderProducts::getProductsDetailInOrder($id);
        $paymentmethod = Orders::getPaymentMethodInfo($model->payment_method);
        $transportmethod = Orders::getTransportMethodInfo($model->transport_method);
        $bonusConfig = BonusConfig::checkBonusConfig();
        $orderInfo = $model->attributes;
        $oldtransportmethod = $model->transport_method;
        //
        if (isset($_POST['Orders'])) {
            $old_order_status = $model->order_status;
            $model->order_status = $_POST['Orders']['order_status'];
            $model->payment_status = $_POST['Orders']['payment_status'];
            $model->transport_status = $_POST['Orders']['transport_status'];
            $model->note = $_POST['Orders']['note'];
            $user = Users::model()->findByPk($model->user_id); //Find User

            //
            if ($model->transport_status == Orders::ORDER_TRANSPORT_SUCCESS && $oldtransportmethod != Orders::ORDER_TRANSPORT_SUCCESS) {
                // send mail
                $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                    'mail_key' => 'transitsucsess',
                ));
                if ($mailSetting) {
                    //Hiện ra danh sách sản phẩm được chọn.
//                    $order_prd = $this->renderPartial('_product_mail_settings', array(
//                        'products' => $products,
//                        'shoppingCart' => $shoppingCart,), true);
                    // Chi tiết trong thư
                    $data = array(
                        'link' => '<a href="' . Yii::app()->createAbsoluteUrl('/economy/shoppingcart/order', array('id' => $model->order_id, 'key' => $model->key)) . '">Link</a>',
                        'customer_name' => $model->billing_name,
                        'customer_email' => $model->billing_email,
                        'customer_address' => $model->billing_address,
                        'customer_phone' => $model->billing_phone,
                    );
                    //
                    $content = $mailSetting->getMailContent($data);
                    //
                    $subject = $mailSetting->getMailSubject($data);
                    //
                    if ($content && $subject) {
                        Yii::app()->mailer->send('', $model->billing_email, $subject, $content);
                        //$mailer->send($from, $email, $subject, $message);
                    }
                }
            }

            if ($model->order_status == Orders::ORDER_COMPLETE) {
                if ($model->transport_status == Orders::ORDER_TRANSPORT_SUCCESS && $model->payment_status == Orders::ORDER_TRANSPORT_SUCCESS) {
                    if ($model->save()) {
                        if (isset($user) && $user) {
                            $bonusPoint = $model->wait_bonus_point;
                            $donateTotal = $model->donate_total;
                            //Bonus điểm cho khách hàng nếu có config.
                            //DK: Tồn tại config, Lớn hơn đơn hàng tối thiểu, Là user, khác giá trị cũ, Điểm tích lũy khác 0.
                            if ($bonusConfig && isset($user) && $old_order_status != Orders::ORDER_COMPLETE && $bonusPoint > 0) {
                                $options = ['note' => BonusPointLog::BONUS_NOTE_COMPLETE_ORDER];
                                $user->addPoint($bonusPoint, $options, $orderInfo);
                            }
                            // Log and save bonus Point
                            if ($bonusConfig && isset($user) && $old_order_status != Orders::ORDER_COMPLETE && $donateTotal != 0) {
                                $options = ['note' => DonateLog::BONUS_NOTE_DONATE_DEFAULT];
                                $user->addDonate($donateTotal, $options, $orderInfo);
                            }
                        }
                        $this->redirect(Yii::app()->createUrl('economy/order'));
                    }
                } else {
                    $error = 'Trạng thái đơn hàng và trạng thái vận chuyển không đúng';
                    $model->order_status = 0;
                }
                //Nếu hủy đơn hàng. Hoàn điểm cho khách (Trừ điểm đã cộng nếu có.)
            } else if ($model->order_status == 5 && $model->bonus_point_used != 0) {
                if ($model->save()) {
                    //Hoàn tiền đã trừ
                    if ($bonusConfig && isset($user) && $old_order_status == 0 && $model->bonus_point_used != 0) {
                        //Tính điểm được tích lũy
                        $bonusPointRefund = $model->bonus_point_used;
                        $options = ['note' => BonusPointLog::BONUS_NOTE_REFUND];
                        $user->refundPoint($bonusPointRefund, $options, $orderInfo);
                    }
                    $this->redirect(Yii::app()->createUrl('economy/order'));
                }
            } else {
                if ($model->save()) {
                    $this->redirect(Yii::app()->createUrl('economy/order'));
                }
            }
        }
        //
        if ($model->viewed == Orders::ORDER_NOTVIEWED) {
            $model->save();
        }
        //
        $this->render('update', array(
            'error' => $error,
            'model' => $model,
            'products' => $products,
            'paymentmethod' => $paymentmethod,
            'transportmethod' => $transportmethod,
        ));
    }

    /**
     * Chức năng sửa lại hóa đơn yêu cầu riêng cho "Ống nhựa"
     * Edit a order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionEdit($id)
    {
        /* Init */
        $this->breadcrumbs = array(
            //
            Yii::t('shoppingcart', Yii::t('shoppingcart', 'order_manager')) => Yii::app()->createUrl('/economy/order'),
            //
            Yii::t('shoppingcart', Yii::t('shoppingcart', 'order_edit')) => Yii::app()->createUrl('/economy/order/edit', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);
        $modelAttributes = $model->attributes;
        if ($model->site_id != $this->site_id)
            $this->sendResponse(404);
        if ($model->order_status == Orders::ORDER_COMPLETE)
            $this->sendResponse(404);
        //
        if ($model->viewed == Orders::ORDER_NOTVIEWED)
            $model->viewed = Orders::ORDER_VIEWED;
        //
        $products = OrderProducts::getProductsDetailInOrder($id);
        $paymentmethod = Orders::getPaymentMethodInfo($model->payment_method);
        $transportmethod = Orders::getTransportMethodInfo($model->transport_method);
        //
        $error = $model->getErrors();
        if (isset($_POST['Orders']) && $model->order_status != Orders::ORDER_COMPLETE) {
            $model->order_status = $_POST['Orders']['order_status'];
            $model->payment_status = $_POST['Orders']['payment_status'];
            $model->transport_status = $_POST['Orders']['transport_status'];
            $model->transport_freight = $_POST['Orders']['transport_freight'];
            $model->discount_percent = $_POST['Orders']['discount_percent'];
            if ($model->validate()) {
                $model->discount_percent = $_POST['Orders']['discount_percent'];
                $model->discount_for_dealers = $model->old_order_total * ($model->discount_percent) / 100;
                $model->order_total = $model->old_order_total - $model->discount_for_dealers + $model->transport_freight;
            }

            if ($model->save()) {
                //
                $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                    'mail_key' => 'customerordernotice_update_order',
                ));
                //
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
                    $subject = $mailSetting->getMailSubject($data);
                    //
                    if ($content && $subject) {
                        $file = Orders::exportMakeFile($model->order_id);
                        $mailer = Yii::app()->mailer;
                        $mailer->phpmailer->AddAttachment($file, 'baogia' . '.' . 'html');
                        $mailer->send('', $model->billing_email, $subject, $content);
                        Yii::app()->user->setFlash('success', 'Gửi yêu cầu thành công. Hệ thống đã gửi 1 mail về địa chỉ mail "' . $model->billing_email . '" cho bạn.');
                    }
                }
                $this->redirect(Yii::app()->createUrl('economy/order'));
            } else {
                $error = $model->getErrors();
            }
        }

        if ($model->viewed == Orders::ORDER_NOTVIEWED) {
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

        $products = OrderProducts::getProductsDetailInOrder($id);

        $paymentmethod = Orders::getPaymentMethodInfo($model->payment_method);
        $transportmethod = Orders::getTransportMethodInfo($model->transport_method);

        if ($model->viewed == Orders::ORDER_NOTVIEWED)
            $model->save();
        $this->render('printbill', array(
            'model' => $model,
            'products' => $products,
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

        $paymentmethod = Orders::getPaymentMethodInfo($model->payment_method);
        $transportmethod = Orders::getTransportMethodInfo($model->transport_method);

        if ($model->viewed == Orders::ORDER_NOTVIEWED)
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
    public function actionDelete($id)
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
    public function actionIndex()
    {
//breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('shoppingcatr', Yii::t('shoppingcart', 'order_manager')) => Yii::app()->createUrl('/economy/order')
        );
        $model = new Orders('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Orders'])) {
            $model->attributes = $_GET['Orders'];
            $model->from_date = $_GET['Orders']['from_date'];
            $model->to_date = $_GET['Orders']['to_date'];
        }
        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * QuangTS
     * export order to csv
     */
    public function actionExportcsv()
    {
        $arrFields = array('Mã đơn hàng', 'Khách hàng', 'Số điện thoại', 'Email', 'Địa chỉ', 'Giao hàng tới', 'Ngày đặt hàng', 'Trạng thái', 'Hình thức thanh toán', 'Số lượng', 'Tên sản phẩm', 'Mã sản phẩm', 'Thành tiền');
        $string = implode("\t", $arrFields) . "\n";
        $orders = Yii::app()->db->createCommand()
            ->select('r.order_id, t.billing_name, t.billing_phone, t.billing_email, t.billing_address, t.shipping_address, t.created_time, t.order_status, t.payment_method, r.product_qty, p.name, p.code, t.order_total')
            ->from('orders t')
            ->join('order_products r', 'r.order_id = t.order_id')
            ->join('product p', 'p.id = r.product_id')
            ->where('t.site_id=:site_id', array(':site_id' => Yii::app()->controller->site_id))
            ->order('t.order_id DESC')
            ->queryAll();
        $status = Orders::getStatusArr();
        foreach ($orders as $order) {
            $arr = array(
                $order['order_id'],
                $order['billing_name'],
                $order['billing_phone'],
                $order['billing_email'],
                $order['billing_address'],
                $order['shipping_address'],
                date('d-m-Y H:i:s', $order['created_time']),
                isset($status[$order['order_status']]) ? $status[$order['order_status']] : '',
                Orders::getPaymentMethodInfo($order['payment_method']),
                $order['product_qty'],
                $order['name'],
                $order['code'],
                number_format($order['order_total'], 0, ',', '.'),

            );
            $string .= implode("\t", $arr) . "\n";
//            echo '<pre>';
//            print_r($order);
//            echo '</pre>';
//            die;
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


//    function ExportCSVFile($records, $heading = false)
//    {
//        // create a file pointer connected to the output stream
//        $fh = fopen('php://output', 'w');
//        if (!empty($records))
//            foreach ($records as $row) {
//                if ($heading) {
//                    // output the column headings
//                    fputcsv($fh, $heading);
//                    $heading = true;
//                } else {
//                    // output the column headings
//                    fputcsv($fh, array_keys($row));
//                    $heading = true;
//                }
//                // loop over the rows, outputting them
//                fputcsv($fh, array_values($row));
//
//            }
//        fclose($fh);
//    }


    public function actionOrderProduct()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('shoppingcatr', Yii::t('shoppingcart', 'order_manager')) => Yii::app()->createUrl('/economy/order'),
            Yii::t('shoppingcatr', Yii::t('shoppingcart', 'orderProduct')) => Yii::app()->createUrl('/economy/order'),
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
    public function actionUserShoppingCart($id)
    {
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
     * Export order to csv
     */
    public function actionExportDetailCSV($id)
    {
        //
        $model = $this->loadModel($id);

        $string = "Tên khách hàng : \t " . $model->billing_name . "\n";
        $string .= "Phone : \t " . $model->billing_phone . "\n";
        $string .= "Email : \t " . $model->billing_email . "\n";
        $string .= "Thời gian tạo : \t " . date('d-m-Y H:i:s', $model->created_time);
        $string .= "\n";
        $string .= "\n";
        $string .= "Thông tin sản phẩm" . "\n";
        $string .= "\n";
        $arrFields = array('Tên sản phẩm', 'Mã sản phẩm', 'Nhà sản xuất', 'Số lượng', 'Giá sản phẩm', 'Tổng giá sản phẩm', 'Thời gian tạo');
        $string .= implode("\t", $arrFields) . "\n";
        //
        $orders = Yii::app()->db->createCommand()
            ->select('t.billing_name, t.billing_phone, t.billing_email, t.created_time, t.order_status, t.payment_method, r.product_qty, r.product_price, p.name, p.code, p.manufacturer_id')
            ->from('orders t')
            ->join('order_products r', 'r.order_id = t.order_id')
            ->join('product p', 'p.id = r.product_id')
            ->where('t.site_id=:site_id AND r.order_id=:order_id', array(':site_id' => Yii::app()->controller->site_id, ':order_id' => $id))
            ->order('t.order_id DESC')
            ->queryAll();
        $status = Orders::getStatusArr();
        //
        foreach ($orders as $order) {
            $manufacturer = Manufacturer::model()->findByPk($order['manufacturer_id'])->name;
            $arr = array(
                $order['name'],
                $order['code'],
                $manufacturer,
                $order['product_qty'],
                $order['product_price'],
                HtmlFormat::money_format($order['product_qty'] * $order['product_price'])
            );
            $string .= implode("\t", $arr) . "\n";
        }

        $old_order_total = number_format($model->old_order_total, 0, '', '.') . 'đ';
        $transport_freight = number_format($model->transport_freight, 0, '', '.') . 'đ';
        $order_total = number_format($model->order_total, 0, '', '.') . 'đ';
        $discount_percent = $model->discount_percent;
        $discount_price = number_format($model->discount_for_dealers, 0, '', '.') . 'đ';

        $string .= "\n";
        $string .= " \t" . " \t" . " \t" . " \t" . "Tổng giá sản phẩm : \t " . $old_order_total . "\n";
        $string .= " \t" . " \t" . " \t" . " \t" . "Phí vận chuyển : \t " . $transport_freight . "\n";
        $string .= " \t" . " \t" . " \t" . " \t" . "Phần trăm giảm giá (%) : \t " . $discount_percent . "\n";
        $string .= " \t" . " \t" . " \t" . " \t" . "Phí giảm : \t " . $discount_price . "\n";
        $string .= " \t" . " \t" . " \t" . " \t" . "Tổng phí : \t " . $order_total . "\n";
        //
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

    public function exportMakeFile($id)
    {
        //
        $model = $this->loadModel($id);
        $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
            'mail_key' => 'file_export_template',
        ));
        if ($mailSetting) {

            $string = "Tên khách hàng : \t " . $model->billing_name . "\n";
            $string .= "Phone : \t " . $model->billing_phone . "\n";
            $string .= "Email : \t " . $model->billing_email . "\n";
            $string .= "Thời gian tạo : \t " . date('d-m-Y H:i:s', $model->created_time);
            $string .= "\n";
            $string .= "\n";
            $string .= "Thông tin sản phẩm" . "\n";
            $string .= "\n";
            $arrFields = array('Tên sản phẩm', 'Mã sản phẩm', 'Nhà sản xuất', 'Số lượng', 'Giá sản phẩm', 'Tổng giá sản phẩm', 'Thời gian tạo');
            $string .= implode("\t", $arrFields) . "\n";
            //
            $orders = Yii::app()->db->createCommand()
                ->select('t.billing_name, t.billing_phone, t.billing_email, t.created_time, t.order_status, t.payment_method, r.product_qty, r.product_price, p.name, p.code, p.manufacturer_id')
                ->from('orders t')
                ->join('order_products r', 'r.order_id = t.order_id')
                ->join('product p', 'p.id = r.product_id')
                ->where('t.site_id=:site_id AND r.order_id=:order_id', array(':site_id' => Yii::app()->controller->site_id, ':order_id' => $id))
                ->order('t.order_id DESC')
                ->queryAll();
            //
            $status = Orders::getStatusArr();
            //
            foreach ($orders as $order) {
                $manufacturer = Manufacturer::model()->findByPk($order['manufacturer_id'])->name;
                $arr = array(
                    $order['name'],
                    $order['code'],
                    $manufacturer,
                    $order['product_qty'],
                    $order['product_price'],
                    HtmlFormat::money_format($order['product_qty'] * $order['product_price'])
                );
                $string .= implode("\t", $arr) . "\n";
            }

            $old_order_total = number_format($model->old_order_total, 0, '', '.') . 'đ';
            $transport_freight = number_format($model->transport_freight, 0, '', '.') . 'đ';
            $order_total = number_format($model->order_total, 0, '', '.') . 'đ';
            $discount_percent = $model->discount_percent;
            $discount_price = number_format($model->discount_for_dealers, 0, '', '.') . 'đ';

            // Order Info
            $string .= "\n";
            $string .= " \t" . " \t" . " \t" . " \t" . "Tổng giá sản phẩm : \t " . $old_order_total . "\n";
            $string .= " \t" . " \t" . " \t" . " \t" . "Phí vận chuyển : \t " . $transport_freight . "\n";
            $string .= " \t" . " \t" . " \t" . " \t" . "Phần trăm giảm giá (%) : \t " . $discount_percent . "\n";
            $string .= " \t" . " \t" . " \t" . " \t" . "Phí giảm : \t " . $discount_price . "\n";
            $string .= " \t" . " \t" . " \t" . " \t" . " \t" . "Tổng phí : \t " . $order_total . "\n";
            //
            //
            $order_prd = $this->renderPartial('_products_bill_mail', array(
                'products' => $orders
            ), true);

            $data = array(
                'site_title' => Yii::app()->siteinfo['site_title'],
                'contact' => 2,
                'old_order_total' => 3,
                'discount_for_dealers' => 4,
                'transport_freight' => 5,
                'name' => $order['billing_name'],
                'phone' => $order['billing_phone'],
                'address' => $order['billing_phone'],
                'product' => $order_prd,
            );
            //
            $content = $mailSetting->getMailContent($data);

            $file = Yii::getPathOfAlias('common') . '/../' . 'assets' . '/' . time() . '_' . $model->order_id . '_bill.html';

            $hander = fopen($file, "w");
            @chmod($file, 0755);
            fwrite($hander, $content);
            fclose($hander);
            return $file;
            //
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Orders the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Orders::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Orders $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'orders-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
