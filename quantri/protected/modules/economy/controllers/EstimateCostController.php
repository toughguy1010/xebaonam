<?php

class EstimateCostController extends BackController
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
            Yii::t('shoppingcart', Yii::t('shoppingcart', 'Quản lý yêu cầu dự toán')) => Yii::app()->createUrl('/economy/estimateCost'),
            Yii::t('shoppingcart', Yii::t('shoppingcart', 'Chi tiết #' . $id)) => Yii::app()->createUrl('/economy/estimateCost/update', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);

        if ($model->site_id != $this->site_id)
            $this->sendResponse(404);
        //
        if ($model->viewed == OfficeEstimateCost::ORDER_NOTVIEWED) {
            $model->viewed = OfficeEstimateCost::ORDER_VIEWED;
            $model->save();
        }
        //
        $aryCost = json_decode($model->result, true);

        $categories = OfficeEstimateCost::optionCategories();
        //
        $floors = OfficeEstimateCost::optionFloor();
        //
        $ceilings = OfficeEstimateCost::optionCeiling();
        //
        $qualities = OfficeEstimateCost::optionQuality();

        $this->render('update', array(
            'model' => $model,
            'categories' => $categories,
            'floors' => $floors,
            'ceilings' => $ceilings,
            'qualities' => $qualities,
            'aryCost' => $aryCost
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
            Yii::t('shoppingcatr', Yii::t('shoppingcart', 'order_manager')) => Yii::app()->createUrl('/economy/estimateCost')
        );
        $model = new OfficeEstimateCost('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['OfficeEstimateCost'])) {
            $model->attributes = $_GET['OfficeEstimateCost'];
            $model->from_date = $_GET['OfficeEstimateCost']['from_date'];
            $model->to_date = $_GET['OfficeEstimateCost']['to_date'];
        }
        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * hungtm
     * export order to csv
     */
    public function actionExportcsv()
    {
        $arrFields = array('Khách hàng', 'Số điện thoại', 'Email', 'Tên sản phẩm', 'Mã sản phẩm', 'Số lượng', 'Giá sản phẩm', 'Thời gian tạo', 'Trạng thái đơn hàng', 'Hình thức thanh toán');
        $string = implode("\t", $arrFields) . "\n";

        $orders = Yii::app()->db->createCommand()
            ->select('t.billing_name, t.billing_phone, t.billing_email, t.created_time, t.order_status, t.payment_method, r.product_qty, r.product_price, p.name, p.code')
            ->from('orders t')
            ->join('order_products r', 'r.order_id = t.order_id')
            ->join('product p', 'p.id = r.product_id')
            ->where('t.site_id=:site_id', array(':site_id' => Yii::app()->controller->site_id))
            ->order('t.order_id DESC')
            ->queryAll();
        $status = OfficeEstimateCost::getStatusArr();
        foreach ($orders as $order) {
            $arr = array(
                $order['billing_name'],
                $order['billing_phone'],
                $order['billing_email'],
                $order['name'],
                $order['code'],
                $order['product_qty'],
                $order['product_price'],
                date('d-m-Y H:i:s', $order['created_time']),
                isset($status[$order['order_status']]) ? $status[$order['order_status']] : '',
                OfficeEstimateCost::getPaymentMethodInfo($order['payment_method']),
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

    public function actionOrderProduct()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('shoppingcatr', Yii::t('shoppingcart', 'order_manager')) => Yii::app()->createUrl('/economy/estimateCost'),
            Yii::t('shoppingcatr', Yii::t('shoppingcart', 'orderProduct')) => Yii::app()->createUrl('/economy/estimateCost'),
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
            Yii::t('shoppingcart', Yii::t('shoppingcart', 'order_manager')) => Yii::app()->createUrl('/economy/estimateCost'),
            Yii::t('shoppingcart', Yii::t('shoppingcart', 'order_manager')) => Yii::app()->createUrl('/economy/estimateCost'),
        );
//
        $model = new OfficeEstimateCost('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['OfficeEstimateCost']))
            $model->attributes = $_GET['OfficeEstimateCost'];
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
        $status = OfficeEstimateCost::getStatusArr();
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
            $status = OfficeEstimateCost::getStatusArr();
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
     * @return OfficeEstimateCost the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = OfficeEstimateCost::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param OfficeEstimateCost $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'orders-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
