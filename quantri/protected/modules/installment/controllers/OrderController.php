<?php

class OrderController extends BackController
{

    /**
     * Updates a order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        /*Init*/
        $this->breadcrumbs = array(
            Yii::t('shoppingcart', Yii::t('shoppingcart', 'order_manager')) => Yii::app()->createUrl('/installment/order'),
            Yii::t('shoppingcart', Yii::t('shoppingcart', 'order_update')) => Yii::app()->createUrl('/installment/order/update', array('id' => $id)),
        );

        //
        $model = $this->loadModel($id);

        if ($model->site_id != $this->site_id)
            $this->sendResponse(404);
        //
        if ($model->viewed == Orders::ORDER_NOTVIEWED)
            $model->viewed = Orders::ORDER_VIEWED;
        //
        $product = Product::model()->findByPk($model->product_id);
        if (isset($_POST['InstallmentOrder'])) {
            $model->status_confirm = $_POST['InstallmentOrder']['status_confirm'];
            //
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl('installment/order'));
            }
        }
        $view = 'update';
        if ($model->payonline) {
            $view = "online/update";
        }
        //
        $this->render($view, array(
            'model' => $model,
            'product' => $product,
        ));
    }

    /**
     * Chức năng sửa lại hóa đơn yêu cầu riêng cho "Ống nhựa"
     * Edit a order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */

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
            Yii::t('installment', 'installment_order') => Yii::app()->createUrl('/installment/order')
        );
        $model = new InstallmentOrder('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['InstallmentOrder'])) {
            $model->attributes = $_GET['InstallmentOrder'];
            $model->from_date = $_GET['InstallmentOrder']['from_date'];
            $model->to_date = $_GET['InstallmentOrder']['to_date'];
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
        $orders = Yii::app()->db->createCommand()
            ->select('r.order_id, t.billing_name, t.billing_phone, t.billing_email, t.billing_address, t.shipping_address, t.created_time, t.status, t.payment_method, r.product_qty, p.name, p.code, t.order_total')
            ->from('orders t')
            ->join('order_products r', 'r.order_id = t.order_id')
            ->join('product p', 'p.id = r.product_id')
            ->where('t.site_id=:site_id', array(':site_id' => Yii::app()->controller->site_id))
            ->order('t.order_id DESC')
            ->queryAll();
        $status = Orders::getStatusArr();
        foreach ($orders as $order) {
            $results[$order['order_id']] = $order;
            $results[$order['order_id']]['created_time'] = date('d/m/Y', $order['created_time']);
            $results[$order['order_id']]['billing_phone'] = (string)$order['billing_phone'];
            $results[$order['order_id']]['status'] = isset($status[$order['status']]) ? $status[$order['status']] : '';
            $results[$order['order_id']]['payment_method'] = Orders::getPaymentMethodInfo($order['payment_method']);
            $results[$order['order_id']]['order_total'] = number_format($order['order_total'], 0, ',', '.');
        }
        $filename = Yii::app()->siteinfo['domain_default'] . "_" . Date('dmY_hsi') . ".csv";
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Expires: 0");
        $this->ExportCSVFile($results, $arrFields);
        //$_POST["ExportType"] = '';
        exit();


    }

    function ExportCSVFile($records, $heading = false)
    {
        // create a file pointer connected to the output stream
        $fh = fopen('php://output', 'w');
        if (!empty($records))
            foreach ($records as $row) {
                if ($heading) {
                    // output the column headings
                    fputcsv($fh, $heading);
                    $heading = true;
                } else {
                    // output the column headings
                    fputcsv($fh, array_keys($row));
                    $heading = true;
                }
                // loop over the rows, outputting them
                fputcsv($fh, array_values($row));

            }
        fclose($fh);
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
            ->select('t.billing_name, t.billing_phone, t.billing_email, t.created_time, t.status, t.payment_method, r.product_qty, r.product_price, p.name, p.code, p.manufacturer_id')
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

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Orders the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = InstallmentOrder::model()->findByPk($id);
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
