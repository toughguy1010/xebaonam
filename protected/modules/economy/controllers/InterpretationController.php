<?php

class InterpretationController extends PublicController
{

    public $layout = '//layouts/shopping_translate';
    /*
     * Index order
     */
    public function actionIndex()
    {
        $this->redirect('/economy/interpretation/order');
    }

    /**
     * Step 1 : Select lang
     */
    public function actionOrder()
    {
        $shoppingCart = Yii::app()->customer->getShoppingCartTranslate();
        //
        $this->render('checkout_s3', array());
    }

    /**
     * Step 2 : elect option
     */
    public function actionSelectLang()
    {
        $lang_from = Yii::app()->request->getParam('lang_from');
        //
        if ($lang_from != 'VN') {
            $this->redirect('/economy/interpretation/orderForm');
        }

        $lang_ids = Yii::app()->request->getPost('lang_ids');
        $option = Yii::app()->request->getPost('options');
        $day = Yii::app()->request->getPost('day');
        if($lang_ids && $option && $day){
            $params['lang_ids'] = $lang_ids;
            $params['options'] = $option;
            $params['day'] = $day;
            Yii::app()->user->setState('interpretation', $params);
            $this->redirect('/economy/interpretation/selectOptions');
        }
        if ($lang_from) {
            //
            $langs = TranslateInterpretation::getLanguagePairByCountry($lang_from);
            $this->render('checkout_s4', array('langs' => $langs, 'langFrom' => $lang_from));
        }
        //
    }

    /**
     * Step 6 : elect option
     */
    public function actionSelectOptions()
    {
        $params = Yii::app()->user->getState('interpretation');
        if (!count($params)) {
            $this->redirect(Yii::app()->createURL('/economy/interpretation/selectLang', array()));
        }
        //
        $interpretationOrder = new InterpretationOrder();
        if (Yii::app()->request->isPostRequest) {
            //
            if (isset($params['lang_ids']) && count($params['lang_ids'])) {
                $langs = TranslateInterpretation::model()->findAllByAttributes(
                    array(
                        'id' => $params['lang_ids'],
                        'site_id' => Yii::app()->controller->site_id)
                );
            };
            //
            $totalPrice = 0;
            if ($langs) {
                //
                foreach ($langs as $key => $value) {
                    if ($params['option'] == 1) {
                        $price = $value->escort_negotiation_inter_price;
                    } else if ($params['option'] == 2) {
                        $price = $value->consecutive_inter_price;
                    } else {
                        $price = $value->simultaneous_inter_price;
                    }
                    //
                    $totalPrice += $params['day'] * $price;
                }
                //
                $interpretationOrder->attributes = Yii::app()->request->getPost('InterpretationOrder');
                $interpretationOrder->total_price = $totalPrice;
                $interpretationOrder->isCheck = true;
                $interpretationOrder->status = InterpretationOrder::ORDER_WAITFORPROCESS; //
                $interpretationOrder->currency = 'USD';
                $interpretationOrder->day = $params['day'];
                $interpretationOrder->key = ClaGenerate::getUniqueCode(array('prefix' => 'o'));
                if ($interpretationOrder->save()) {
                    Yii::app()->user->setFlash('success', Yii::t('shoppingcart', 'order_success_notice'));
                    foreach ($langs as $key => $value) {
                        //
                        if ($params['option'] == 1) {
                            $price1 = $value->escort_negotiation_inter_price;
                        } else if ($params['option'] == 2) {
                            $price1 = $value->consecutive_inter_price;
                        } else {
                            $price1 = $value->simultaneous_inter_price;
                        }
                        //
                        $orderItem = new InterpretationOrderItem();
                        $orderItem->order_id = $interpretationOrder->id;
                        $orderItem->interpretation_id = $value->id;
                        $orderItem->price = $params['day'] * $price1;
                        $orderItem->currency = $value->currency;
                        $orderItem->save();
                    }

                    if ($interpretationOrder->payment_method == TranslateOrder::PAYMENT_METHOD_PAYPAL) {
                        $this->requestPaypal($interpretationOrder);
                    }
                    if ($interpretationOrder->payment_method == TranslateOrder::PAYMENT_METHOD_NGANLUONG) {
                        $this->requestNganluong($interpretationOrder);
                    }
                    //
                    $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                        'mail_key' => 'interpretation_notice',
                    ));
                    if ($mailSetting) {
                        // Chi tiết trong thư
                        $detail_order = $data = array(
                            'link' => '<a href="' . Yii::app()->createAbsoluteUrl('/economy/shoppingcartTranslate/vieworder', array('id' => $interpretationOrder->id, 'key' => $interpretationOrder->key)) . '">Link</a>',
                            'customer' =>  $interpretationOrder->name,
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

                    //
                    $mailSettingCustommer = MailSettings::model()->mailScope()->findByAttributes(array(
                        'mail_key' => 'interpretation_customer_notice',
                    ));
                    if ($mailSettingCustommer) {
                        // Chi tiết trong thư
                        $detail_order = $data = array(
                            'link' => '<a href="' . Yii::app()->createAbsoluteUrl('/economy/shoppingcartTranslate/vieworder', array('id' => $interpretationOrder->id, 'key' => $interpretationOrder->key)) . '">Link</a>',
                            'customer' =>  $interpretationOrder->name,
                        );
                        //
                        $content = $mailSettingCustommer->getMailContent($data);
                        //
                        $subject = $mailSettingCustommer->getMailSubject($data);
                        //
                        if ($content && $subject) {
                            Yii::app()->mailer->send('',$interpretationOrder->email, $subject, $content);
                        }
                    }

                    $this->redirect(Yii::app()->createUrl('/economy/interpretation/vieworder', array('id' => $interpretationOrder->id, 'key' => $interpretationOrder->key)));
                }
            }
        }
        //
        if (isset($params['lang_ids']) && count($params['lang_ids'])) {
            $langs = TranslateInterpretation::model()->findAllByAttributes(
                array(
                    'id' => $params['lang_ids'],
                    'site_id' => Yii::app()->controller->site_id)
            );
            //
            $this->render('checkout_s5', array('list_lang' => $langs, 'params' => $params,'model'=> $interpretationOrder));
        }
        //
    }

    /**
     * Xem hoa don
     */
    function actionVieworder()
    {
        $id = Yii::app()->request->getParam('id');
        $key = Yii::app()->request->getParam('key');
        if ($id && $key) {
            $interpretationOrder = InterpretationOrder::model()->findByPk($id);
            if (!$interpretationOrder) {
                $this->sendResponse(404);
            }
            if ($interpretationOrder->key != $key) {
                $this->sendResponse(404);
            }
            $items = InterpretationOrderItem::getItemssDetailInOrder($id);
            //
            $this->render('vieworder', array(
                'interpretationOrder' => $interpretationOrder,
                'items' => $items,
            ));
        }
    }

    //IN hóa đơn
    public function actionPrintBill()
    {
        $id = Yii::app()->request->getParam('id');
        $key = Yii::app()->request->getParam('key');
        $site = Yii::app()->siteinfo;
        $model = InterpretationOrder::model()->findByPk($id);
        if (!$model) {
            $this->sendResponse(404);
        }
        if ($model->key != $key) {
            $this->sendResponse(404);
        }
        $items = InterpretationOrderItem::getItemssDetailInOrder($id);
        //
        $this->renderPartial('printbill', array(
            'model' => $model,
            'items' => $items,
            'site' => $site,
        ));
    }

    /**
     * Xoá khỏi shopping cart
     */
    public function actionDelete()
    {
        $key = Yii::app()->request->getParam('key');
//        $key = (is_numeric($key)) ? $key : (int) $key;
        if ($key) {
            if (!Yii::app()->siteinfo['use_shoppingcart_set']) {
                $shoppingCart = Yii::app()->customer->getShoppingCartTranslate();
                $product = TranslateFiles::model()->findByPk($key);
                if ($product) {
                    $shoppingCart->remove($key);
                    $product->delete();
                    if (Yii::app()->request->isAjaxRequest) {
                        $this->jsonResponse('200', array(
                            'message' => 'success',
                        ));
                    } else
                        $this->redirect(Yii::app()->createUrl('economy/interpretation/order'));
                }
            }
        }
        $this->sendResponse(400);
    }

    public function actionLangTo()
    {
        $langFrom = Yii::app()->request->getParam('langFrom');
        if ($langFrom) {
            $langs = TranslateLanguage::getAllLanguageTranslateTo($langFrom);
            if ($langs) {
                $this->jsonResponse('200', array(
                    'html' => $this->renderPartial('ldistrict', array('langs' => $langs), true),
                ));
            }
        }
    }

    public function actionSelectLanguage()
    {
        $shoppingCart = Yii::app()->customer->getShoppingCartTranslate();
        $langto = Yii::app()->request->getParam('langto');
        $langfrom = Yii::app()->request->getParam('lang_from');
        //
        if (count($langto) && $langfrom) {
            $shoppingCart->addFromLang($langfrom);
            $shoppingCart->removeAllLang();
            foreach ($langto as $lang) {
                $langs = TranslateLanguage::model()->findByAttributes(array(
                    'to_lang' => $lang,
                    'from_lang' => $langfrom
                ));
                if ($langs) {
                    $shoppingCart->addlang($langs->id, $langs->attributes);
                } else {
                    continue;
                }
            }
            $this->redirect(Yii::app()->createUrl("economy/interpretation/selectLang"));
            //
        }
        $this->redirect(Yii::app()->createUrl("economy/interpretation/selectLang"));
    }

    /**
     * Create Form
     */
    public function actionOrderForm()
    {
        $params = Yii::app()->request->getParam('InterpretationForm', 0);
        $model = new InterpretationForm();
        if ($params) {
            $model->attributes = $params;
            $model->to = json_encode($params['to']);
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl('economy/interpretation/checkoutRequest', array('id' => $model->id)));
                Yii::app()->user->setFlash('success', 'Gửi thành công');
                $model->unsetAttributes();  // clear any default values
            }
        }
        //
        $this->render('request_form',
            array('model' => $model)
        );
    }

    /**
     * Create Form
     */
    public function actionCheckoutRequest($id)
    {
        $model = InterpretationForm::model()->findByPk($id);

        $this->render('checkout_request',
            array('model' => $model)
        );
    }

    public function requestPaypal($order)
    {
        // Get Translate
        $translate = InterpretationOrderItem::getItemssDetailInOrder($order->id);
        $currency = 'USD';
        //
        $i = 0;
        $items = [];
        $sub_total = 0;
        //
        foreach ($translate as $product) {
            $items[$i] = new \PayPal\Api\Item();
            $price = number_format($product['price'], 2);
            $name = $product['from'] . ' - ' . $product['to'];
            $items[$i]->setName($name)
                ->setCurrency($currency)
                ->setQuantity(1)
                ->setPrice($product['price']);
            $sub_total += number_format($product['price'], 2);
            $i++;
        }
        // Get Product
        $shipping = 0;
        $total = $sub_total;

        $payer = new PayPal\Api\Payer();
        $payer->setPaymentMethod('paypal');

        $itemList = new PayPal\Api\ItemList();
        $itemList->setItems($items);

        $details = new PayPal\Api\Details();
        $details->setShipping($shipping)
            ->setSubtotal($sub_total);

        $amount = new PayPal\Api\Amount();
        $amount->setCurrency($currency)
            ->setTotal($total)
            ->setDetails($details);

        $transaction = new PayPal\Api\Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription('Pay For Order: ' . $order->id)
            ->setInvoiceNumber($order->id);

        $redirectUrls = new \PayPal\Api\RedirectUrls();
        $returnUrl = Yii::app()->createAbsoluteUrl('economy/shoppingcartTranslate/paypalCallback', [
            'success' => 'true',
            'orderId' => $order->id
        ]);
        $cancelUrl = Yii::app()->createAbsoluteUrl('economy/shoppingcartTranslate/paypalCallback', [
            'success' => 'false',
            'orderId' => $order->id
        ]);
        $redirectUrls->setReturnUrl($returnUrl)
            ->setCancelUrl($cancelUrl);

        $payment = new PayPal\Api\Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);
        //
        $config_paypal = SitePayment::getPaymentType(SitePayment::TYPE_PAYPAL);
        $paypal = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential($config_paypal->client_id, $config_paypal->secret)
        );
        //
        $paypal->setConfig([
            'log.LogEnabled' => true,
            'log.FileName' => 'PayPal.log',
            'log.LogLevel' => 'FINE',
            'mode' => 'live',
        ]);
        //
        try {
            $payment->create($paypal);
        } catch (Exception $e) {
            $data = json_decode($e->getData());
            echo "<pre>";
            print_r($data);
            echo "</pre>";
            die();
        }

        $approvalUrl = $payment->getApprovalLink();
        $this->redirect($approvalUrl);
    }

    public function actionPaypalCallback()
    {
        $success = Yii::app()->request->getParam('success');
        $paymentId = Yii::app()->request->getParam('paymentId');
        $payerId = Yii::app()->request->getParam('PayerID');
        $orderId = Yii::app()->request->getParam('orderId');

        $order = TranslateOrder::model()->findByPk($orderId);
        if (!$order) {
            $this->sendResponse(404);
        }
        $url = Yii::app()->createUrl('/economy/shoppingcartTranslate/vieworder', array(
            'id' => $order->id,
            'key' => $order->key,
        ));
        if (!isset($success, $paymentId, $payerId)) {
            $this->redirect($url);
        }

        if ((bool)$success === false) {
            $this->redirect($url);
        }

        $config_paypal = SitePayment::getPaymentType(SitePayment::TYPE_PAYPAL);
        $paypal = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential($config_paypal->client_id, $config_paypal->secret)
        );
        $paypal->setConfig([
            'log.LogEnabled' => true,
            'log.FileName' => 'PayPal.log',
            'log.LogLevel' => 'FINE',
            'mode' => 'live',
        ]);
        $payment = \PayPal\Api\Payment::get($paymentId, $paypal);

        $execute = new PayPal\Api\PaymentExecution();
        $execute->setPayerId($payerId);

        try {
            $result = $payment->execute($execute, $paypal);
            $order->payment_status = TranslateOrder::ORDER_PAYMENT_STATUS_PAID;
            $order->save();
        } catch (Exception $e) {
            $data = json_decode($e->getData());
            echo "<pre>";
            print_r($data);
            echo "</pre>";
            die();
        }

        $this->redirect(Yii::app()->createUrl('/economy/shoppingcartTranslate/vieworder', array(
            'id' => $order->id,
            'key' => $order->key,
        )));
    }

    /**
     * thanh toán ngân lượng
     * @param type $order
     */
    public function requestNganluong($order)
    {
        $config = SitePayment::model()->getConfigPayment(SitePayment::TYPE_NGANLUONG);
        $nlcheckout = new NganluongHelper($config['merchan_id'], $config['secure_pass'], $config['email_bussiness'], $config['url_request']);
        $nlcheckout->cur_code = 'usd';
        $total_amount = $order->total_price;
        $array_items = array();
        //
        $payment_method = $order->payment_method;
        $bank_code = isset($order->payment_method_child) ? $order->payment_method_child : '';
        $order_code = $order->id; // mã booking
        //
        $payment_type = '';
        $discount_amount = 0;
        $order_description = '';
        $tax_amount = 0;
        $fee_shipping = 0;
        //
        $return_url = urlencode(Yii::app()->createAbsoluteUrl('/economy/shoppingcartTranslate/callbackNganluongSuccess', array(
            'id' => $order->id,
            'key' => $order->key,
        )));
        // $cancel_url = urlencode('http://localhost/nganluong.vn/checkoutv3?orderid=' . $order_code);
        $cancel_url = urlencode(Yii::app()->createAbsoluteUrl('/economy/shoppingcartTranslate/vieworder', array(
            'id' => $order->id,
            'key' => $order->key,
        )));
        //
        $buyer_fullname = $order->name; // Tên người đặt phòng
        $buyer_email = $order->email; // Email người đặt phòng
        $buyer_mobile = $order->tell; // Điện thoại người đặt phòng
        $buyer_address = ''; // Địa chỉ người đặt phòng
        //
        if ($payment_method != '' && $buyer_email != "" && $buyer_mobile != "" && $buyer_fullname != "" && filter_var($buyer_email, FILTER_VALIDATE_EMAIL)) {
            $nl_result = $nlcheckout->VisaCheckout($order_code, $total_amount, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items, $bank_code);
        }
        if ($nl_result->error_code == '00') {
            $url_checkout = (string)$nl_result->checkout_url;
            $this->redirect($url_checkout);
        } else {
            echo $nl_result->error_message;
        }
    }

    /**
     * call back onepay nội địa quốc tế
     * @hungtm
     */
    public function actionCallbackNganluongSuccess()
    {
        $id = Yii::app()->request->getParam('id');
        $key = Yii::app()->request->getParam('key');
        $config = SitePayment::model()->getConfigPayment(SitePayment::TYPE_NGANLUONG);
        $nlcheckout = new NganluongHelper($config['merchan_id'], $config['secure_pass'], $config['email_bussiness'], $config['url_request']);
        $nl_result = $nlcheckout->GetTransactionDetail($token);
        $order = TranslateOrder::model()->findByPk($id);
        if ($nl_result) {
            $nl_errorcode = (string)$nl_result->error_code;
            $nl_transaction_status = (string)$nl_result->transaction_status;
            if ($nl_errorcode == '00') {
                if ($nl_transaction_status == '00') {
                    //log
                    $json = json_encode($nl_result);
                    $arr = json_decode($json, true);
                    $log = LogPaymentNganluong::model()->findByPk($arr['transaction_id']);
                    if ($log === NULL) {
                        $log = new LogPaymentNganluong();
                        $log->transaction_id = $arr['transaction_id'];
                        $log->token = $arr['token'];
                        $log->receiver_email = $arr['receiver_email'];
                        $log->order_code = $arr['order_code'];
                        $log->total_amount = $arr['total_amount'];
                        $log->payment_method = $arr['payment_method'];
                        $log->bank_code = $arr['bank_code'];
                        $log->payment_type = $arr['payment_type'];
                        $log->tax_amount = $arr['tax_amount'];
                        $log->discount_amount = $arr['discount_amount'];
                        $log->fee_shiping = $arr['fee_shiping'];
                        $log->return_url = $arr['return_url'];
                        $log->cancel_url = $arr['cancel_url'];
                        $log->buyer_fullname = $arr['buyer_fullname'];
                        $log->buyer_email = $arr['buyer_email'];
                        $log->buyer_mobile = $arr['buyer_mobile'];
                        $log->buyer_address = $arr['buyer_address'];
                        $log->save();
                        //trạng thái thanh toán thành công
                        $order->payment_status = TranslateOrder::ORDER_PAYMENT_STATUS_PAID;
                        $order->save();
                    }
                }
            } else {
                echo $nlcheckout->GetErrorMessage($nl_errorcode);
                die();
            }
        }
        $this->redirect(Yii::app()->createUrl('/economy/shoppingcart/vieworder', array(
            'id' => $order->id,
            'key' => $order->key,
        )));
    }

}