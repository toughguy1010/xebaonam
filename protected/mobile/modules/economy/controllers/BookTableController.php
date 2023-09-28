<?php

class BookTableController extends PublicController {

    public $layout = '//layouts/page';

    /**
     * lecturer index
     */
    public function actionIndex() {
        //
        $this->breadcrumbs = array(
            'Đặt bàn' => Yii::app()->createUrl('/economy/bookTable'),
        );

        $model = new BookTable;

        $site_id = Yii::app()->controller->site_id;

        $stores = ShopStore::getAllShopstore();
        $option_stores = array('' => 'Chọn chi nhánh');
        $option_stores += array_column($stores, 'name', 'id');
        if (isset($_POST['BookTable']) && $_POST['BookTable']) {
            $model->attributes = $_POST['BookTable'];
            if ($model->save()) {
                //Gửi email cho admin
                $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                    'mail_key' => 'booktable',
                ));
                if ($mailSetting) {
                    $data = array(
                        'name' => $model->name,
                        'email' => $model->email,
                        'phone' => $model->phone,
                        'quantity' => $model->quantity,
                        'book_time' => $model->book_time,
                        'book_date' => $model->book_date,
                        'branch' => ShopStore::model()->findByPk($model->branch)->name,
                        'message' => $model->message,
                        'fr' => (isset($_SESSION['fr']) && $_SESSION['fr']) ? $_SESSION['fr'] : ''
                    );
                    //
                    $content = $mailSetting->getMailContent($data);
                    //
                    $subject = $mailSetting->getMailSubject($data);
                    //
                    if ($content && $subject) {
                        Yii::app()->mailer->send('', Yii::app()->siteinfo['admin_email'], $subject, $content);
                    }
                }
                //End gửi email

                $campaign = BookTableCampaign::model()->findByPk($site_id);
                if ($campaign !== NULL && $campaign->status == ActiveRecord::STATUS_ACTIVED) {
                    $config_apivoucher = SiteApivoucher::checkConfigVoucher();
                    $ws_client = new nusoap_client($config_apivoucher->url, 'wsdl');
                    $order_product_id = $model->id;
                    $payment_type = 2;
                    $payment_status = 2; // chưa thanh toán
                    $result = $ws_client->call($config_apivoucher->function_service, array(
                        'order_id' => $order_product_id,
                        'order_code' => $order_product_id,
                        'type_code' => '',
                        'price' => (int) $campaign['price'],
                        'price_order' => (int) $campaign['price'],
                        'quantity' => 1,
                        'order_des' => 'Đơn hàng ' . $order_product_id,
                        'time_start' => 0,
                        'time_end' => 0,
                        'phone' => $model->phone,
                        'fullname' => $model->name,
                        'address' => '',
                        'email' => $model->email,
                        'payment_type' => $payment_type,
                        'payment_status' => $payment_status,
                        'site_id' => $config_apivoucher->site_id_onapi,
                        'site_pass' => $config_apivoucher->site_pass_onapi
                    ));
                    $log_voucher = 'INSERT INTO orders_log_sms(order_id, phone, type, result, created_time, modified_time, site_id) VALUES (\'' . $model->id . '\',\'' . $model->phone . '\',\'' . OrdersLogSms::TYPE_BOOK_TABLE . '\',\'' . $result . '\',\'' . time() . '\',\'' . time() . '\', \'' . Yii::app()->controller->site_id . '\')';
                    Yii::app()->db->createCommand($log_voucher)->execute();
                }

                Yii::app()->user->setFlash("success", 'Đặt bàn thành công');
                $this->redirect(Yii::app()->createUrl('economy/bookTable'));
            }
        }

        $this->render('index', array(
            'model' => $model,
            'option_stores' => $option_stores
        ));
    }

}

?>