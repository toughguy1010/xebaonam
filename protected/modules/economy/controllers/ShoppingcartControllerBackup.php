<?php

class ShoppingcartController extends PublicController {

    public $layout = '//layouts/shopping';

    public function actionIndex() {
        $shoppingCart = Yii::app()->customer->getShoppingCart();
        $this->render('index', array(
            'shoppingCart' => $shoppingCart
        ));
    }

    public function actionCheckout() {
        //
        $this->layoutForAction = '//layouts/checkout';
        //
        $shoppingCart = Yii::app()->customer->getShoppingCart();
        if (!$shoppingCart->countOnlyProducts()) {
            $this->sendResponse(500);
        }
        if (!$shoppingCart->checkPointUsed() && ($shoppingCart->getTotalPrice(false))) {
            $shoppingCart->addPointUsed(0);
        }
        $step = Yii::app()->request->getParam('step');
        if (!$step) {
            $step = 's1';
        }
        $view = 'checkout_s1';
        $params = array();

        switch ($step) {
            case 's1': {
                    if (Yii::app()->user->isGuest) {
                        break;
                    }
                }
            default: {
                    $view = 'checkout_s2';
                    $billing = new Billing();
                    $billing->billtoship = 1;
                    if (!Yii::app()->user->isGuest) {
                        $userinfo = ClaUser::getUserInfo(Yii::app()->user->id);
                        if ($userinfo) {
                            $billing->name = $userinfo['name'];
                            if ($userinfo['address'])
                                $billing->address = $userinfo['address'];
                            if ($userinfo['email'])
                                $billing->email = $userinfo['email'];
                            if ($userinfo['phone'])
                                $billing->phone = $userinfo['phone'];
                            if ($userinfo['province_id'])
                                $billing->city = $userinfo['province_id'];
                        }
                    }
                    $shipping = new Shipping();
                    $order = new Orders();

                    if (Yii::app()->request->isPostRequest) {
                        $billing->attributes = Yii::app()->request->getPost('Billing');
                        if ($billing->billtoship) {
                            $shipping->attributes = $billing->attributes;
                        } else {
                            $shipping->attributes = Yii::app()->request->getPost('Shipping');
                        }
                        $order->attributes = Yii::app()->request->getPost('Orders');
                        if ($billing->validate() && $shipping->validate()) {
                            //assign billing
                            $order->billing_name = $billing->name;
                            $order->billing_address = $billing->address;
                            $order->billing_email = $billing->email;
                            $order->billing_phone = $billing->phone;
                            $order->billing_city = $billing->city;
                            $order->billing_district = $billing->district;
                            //assign shipping
                            $order->shipping_name = $shipping->name;
                            $order->shipping_phone = $shipping->phone;
                            $order->shipping_address = $shipping->address;
                            $order->shipping_city = $shipping->city;
                            $order->shipping_district = $shipping->district;
                            //


                            $transportMethod = Orders::getTranportMethod();
                            $paymentMethod = Orders::getPaymentMethod();

                            if (!isset($transportMethod[$order->transport_method])) {
                                $order->transport_method = 0;
                            }
                            if (!isset($paymentMethod[$order->payment_method])) {
                                $order->payment_method = null;
                            }
                            //
                            $order->site_id = $this->site_id;
                            if (!Yii::app()->user->isGuest) {
                                $order->user_id = Yii::app()->user->id;
                            }
                            //
                            $order->ip_address = Yii::app()->request->userHostAddress;
                            $order->key = ClaGenerate::getUniqueCode(array('prefix' => 'o'));
                            //
                            $order->coupon_code = $shoppingCart->getCouponCode();

                            //Bonus point kiểm tra
                            $config_bonus = BonusConfig::checkBonusConfig();

                            if (!Yii::app()->user->isGuest) {
                                if (isset($config_bonus) && $config_bonus->status == true) {
                                    $order->bonus_point_used = $shoppingCart->getPointUsed() * $config_bonus['price_per_point'];
                                } else {
                                    $order->bonus_point_used = 0;
                                }
                            }
                            $products_shoppingcart = $shoppingCart->findAllProducts();
                            $total_price_normal = 0;
                            foreach ($products_shoppingcart as $product_item) {
                                if ($product_item['type_product'] == ActiveRecord::TYPE_PRODUCT_NORMAL) {
                                    $total_price_normal += $product_item['price'];
                                }
                            }


                            // check hình thức thanh toán không phải tại cửa hàng
                            if ($order->payment_method != 1 && $total_price_normal > 0) {
                                $order->transport_freight = Orders::getShipfee($order->shipping_city, $order->shipping_district);
                            }

                            $total_price_discount = $shoppingCart->getTotalPriceDiscount();

                            $percent_vat = Yii::app()->siteinfo['percent_vat'];
                            $vat = 0;
                            if ($percent_vat > 0 && $total_price_normal > 0) {
                                $vat = $total_price_discount - (((100 - $percent_vat) / 100) * $total_price_discount);
                                $order->vat = $vat;
                            }

                            // check hình thức thanh toán không phải tại cửa hàng
                            if ($order->payment_method != 1) {
                                $order->order_total = $total_price_discount + $order->transport_freight + $vat;
                            } else {
                                $order->order_total = $total_price_discount + $vat;
                            }
                            //

                            if ($order->save()) {
                                // Luu log va tru bonus
                                if (!Yii::app()->user->isGuest && $order->bonus_point_used != 0) {
                                    $bonus_log_use = new BonusPoint();
                                    $bonus_log_use->user_id = Yii::app()->user->id;
                                    $bonus_log_use->site_id = Yii::app()->controller->site_id;
                                    $bonus_log_use->order_id = $order->order_id;
                                    $bonus_log_use->point = $shoppingCart->getPointUsed();
                                    $bonus_log_use->type = ClaShoppingCart::BONUS_TYPE_1; //type điểm trừ
                                    $bonus_log_use->created_time = time();
                                    $bonus_log_use->note = 'Mua hàng sử dụng điểm';
                                    if ($bonus_log_use->save()) {
                                        $user = Users::model()->findByPk(Yii::app()->user->id);
                                        $user->bonus_point = $user->bonus_point - $bonus_log_use->point;
                                        $user->save();
                                    }
                                }
                                Yii::app()->user->setFlash('success', Yii::t('shoppingcart', 'order_success_notice'));
                                $products = $shoppingCart->findAllProducts();
                                foreach ($products as $key => $product) {
                                    $orderProduct = new OrderProducts();
                                    $orderProduct->product_id = $product['id'];
                                    $orderProduct->order_id = $order->order_id;
                                    $orderProduct->product_qty = $shoppingCart->getQuantity($key);
                                    $orderProduct->product_price = $product['price'];
                                    $atts = $shoppingCart->getAttributesByKey($key);
                                    if ($atts)
                                        $orderProduct->product_attributes = json_encode($atts);
                                    $orderProduct->save();
                                }
                                // send mail 
                                $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                                    'mail_key' => 'ordernotice',
                                ));
                                if ($mailSetting) {
                                    //Hiện ra danh sách sản phẩm được chọn.
                                    $order_prd = $this->renderPartial('_product_mail_settings', array(
                                        'products' => $products,
                                        'shoppingCart' => $shoppingCart,), true);
                                    // Chi tiết trong thư
                                    $detail_order = $data = array(
                                        'link' => '<a href="' . Yii::app()->createAbsoluteUrl('/economy/shoppingcart/order', array('id' => $order->order_id, 'key' => $order->key)) . '">Link</a>',
                                        'customer_name' => $billing->name,
                                        'customer_email' => $billing->email,
                                        'customer_address' => $billing->address,
                                        'customer_phone' => $billing->phone,
                                        'order_detail' => $order_prd,
                                        'coupon_code' => $order->coupon_code,
                                        'order_total' => $order->order_total,
                                    );
                                    //
                                    $content = $mailSetting->getMailContent($data);
                                    //
                                    $subject = $mailSetting->getMailSubject($data);
                                    //
                                    if ($content && $subject) {
                                        Yii::app()->mailer->send('', Yii::app()->siteinfo['admin_email'], $subject, $content);
                                        //$mailer->send($from, $email, $subject, $message);
                                    }
                                }
                                // send mail for customer 
                                $mailSetting1 = MailSettings::model()->mailScope()->findByAttributes(array(
                                    'mail_key' => 'customerordernotice',
                                ));
                                if ($mailSetting1) {
                                    //Hiện ra danh sách sản phẩm được chọn.
                                    $order_prd = $this->renderPartial('_product_mail_settings', array(
                                        'products' => $products,
                                        'shoppingCart' => $shoppingCart,), true);
                                    // Chi tiết trong thư
                                    $detail_order = $data = array(
                                        'link' => '<a href="' . Yii::app()->createAbsoluteUrl('/economy/shoppingcart/order', array('id' => $order->order_id, 'key' => $order->key)) . '">Link</a>',
                                        'customer_name' => $billing->name,
                                        'customer_email' => $billing->email,
                                        'customer_address' => $billing->address,
                                        'customer_phone' => $billing->phone,
                                        'order_detail' => $order_prd,
                                        'coupon_code' => $order->coupon_code,
                                        'order_total' => $order->order_total,
                                    );
                                    //
                                    $content = $mailSetting1->getMailContent($data);
                                    //
                                    $subject = $mailSetting1->getMailSubject($data);
                                    //
                                    if ($content && $subject) {
                                        if (Yii::app()->controller->site_id == 912) {
                                            // Fix gửi mail của gia viên (fix tạm)
                                            Yii::app()->mailer->send("cskh@nhahanggiavien.vn", $billing->email, $subject, $content);
                                            //$mailer->send($from, $email, $subject, $message);
                                        } else {
                                            Yii::app()->mailer->send("", $billing->email, $subject, $content);
                                            //$mailer->send($from, $email, $subject, $message);
                                        }
                                    }
                                }
                                // delete cart
                                Yii::app()->customer->deleteShoppingCart();
                                /**
                                 * @hungtm
                                 * nếu user chọn phương thức thanh toán onepay
                                 * thì sẽ request đến trang thanh toán của one pay
                                 */
                                if ($order->payment_method == Orders::PAYMENT_METHOD_ONEPAY) {
                                    $this->requestOnepay($order);
                                }

                                /**
                                 * @hungtm
                                 * nếu user chọn phương thức thanh toán onepay quốc tế
                                 * thì sẽ request đến trang thanh toán của one pay quốc tế
                                 */
                                if ($order->payment_method == Orders::PAYMENT_METHOD_ONEPAY_QUOCTE) {
                                    $this->requestOnepayQuocte($order);
                                }

                                //payment online
                                if ($order->payment_method == Orders::PAYMENT_METHOD_ONLINE) {
                                    $config = SitePayment::model()->getConfigPayment('baokim');
                                    $payonline = BaokimHelper::helper()->mergeConfig($config)->paymentOnline($order);
                                    if (isset($payonline['guide']) && $payonline['guide']) {
                                        $this->redirect(Yii::app()->createUrl('/economy/shoppingcart/guide', array(
                                                    'id' => $order->order_id,
                                                    'key' => $order->key,
                                                    'guide' => base64_encode($payonline['guide']),
                                        )));
                                    }
                                    if (isset($payonline['pmbk_error'])) {
                                        Yii::app()->user->setFlash('error', "Bảo Kim lỗi : " . $payonline['pmbk_error'] . ". Chúng tôi đã lưu đơn hàng của bạn vào hệ thống. Rất xin lỗi vì sự cố này.");
                                    }
                                }
                                /**
                                 * hungtm
                                 * kiểm tra xem đơn hàng có sản phẩm voucher hay không
                                 * nếu có sẽ call api bắn mã voucher cho khách hàng qua số điện thoại
                                 */
                                $config_apivoucher = SiteApivoucher::checkConfigVoucher();
                                if ($config_apivoucher) {
                                    $this->sendVoucher($order, $config_apivoucher);
                                }

                                /**
                                 * hungtm
                                 * kiểm tra xem site có được cấu hình api sms hay không
                                 * nếu có sẽ call api bắn tin nhắn cho khách hàng qua số điện thoại
                                 */
                                $config_apisms = SiteApisms::checkConfigApisms();
                                if ($config_apisms) {
                                    $this->sendOrderSms($order, $config_apisms);
                                }
                                //
                                $this->redirect(Yii::app()->createUrl('/economy/shoppingcart/order', array(
                                            'id' => $order->order_id,
                                            'key' => $order->key,
                                )));
                            }
                        }
                    }

                    // hungtm add array province
//                    $listprovince = LibProvinces::getListProvinceArr();
//                    if (!$order->billing_city) {
//                        $first = array_keys($listprovince);
//                        $firstpro = isset($first[0]) ? $first[0] : null;
//                        $order->billing_city = $firstpro;
//                    }
//                    $listdistrict = false;
//                    if (!$listdistrict) {
//                        $listdistrict = LibDistricts::getListDistrictArrFollowProvince($order->billing_city);
//                    }
//
//                    if (!$order->billing_district) {
//                        $first = array_keys($listdistrict);
//                        $firstdis = isset($first[0]) ? $first[0] : null;
//                        $order->billing_district = $firstdis;
//                    }

                    $params = array(
                        'billing' => $billing,
                        'shipping' => $shipping,
                        'order' => $order,
                    );
                }break;
        }

        $arr = array('shoppingCart' => $shoppingCart) + $params;
        $this->render($view, $arr);
    }

    /**
     * @hungtm
     * function send sms to customer and admin website via sms
     * @param type $order
     * @param type $config_apisms
     */
    public function sendOrderSms($order, $config_apisms) {
        $client = new nusoap_client($config_apisms->url, 'wsdl');
        $sms_to_customer = 'Dat mon / Voucher - Ten: ' . HtmlFormat::stripUnicode(trim(mb_strtoupper($order->billing_name, 'UTF-8')), 1) . '. Sdt: ' . $order->billing_phone . ' Tien:' . number_format($order->order_total, 0, '', '.') . ' VND . Ghi chu:' . HtmlFormat::stripUnicode(trim(mb_strtoupper($order->note, 'UTF-8')), 1);
//        $sms_to_admin = 'Khach hang: ' . HtmlFormat::stripUnicode(trim(mb_strtoupper($order->billing_name, 'UTF-8')), 1) . ' vua tao don hang tren website cua ban. Ma don hang: ' . $order->order_id;
        $sms_to_admin = 'Dat mon / Voucher - ten: ' . HtmlFormat::stripUnicode(trim(mb_strtoupper($order->billing_name, 'UTF-8')), 1) . '. SDT: ' . $order->billing_phone . ' Tien: ' . number_format($order->order_total, 0, '', '.') . '. Ghi chu:' . HtmlFormat::stripUnicode(trim(mb_strtoupper($order->note, 'UTF-8')), 1);
        $phone_customer = '84' . ltrim($order->billing_phone, '0');
        $phone_admin_str = Yii::app()->siteinfo['phone'];
        $phone_admin_array = explode(',', $phone_admin_str);

        $input_common = array(
            'user' => $config_apisms->user,
            'pass' => $config_apisms->pass,
            'senderName' => $config_apisms->sender_name,
            'isFlash' => False,
            'isUnicode' => False,
        );
        $input_customer = $input_common;
// thêm các thông số gửi tin cho khách hàng
        $input_customer['sms'] = $sms_to_customer;
        $input_customer['phone'] = $phone_customer;
        $input_customer['cid'] = $order->order_id;
        $response_customer = $client->call($config_apisms->function_service, $input_customer);
        $log_customer = 'INSERT INTO orders_log_sms(order_id, phone, type, result, created_time, modified_time, site_id) VALUES (\'' . $order->order_id . '\',\'' . $phone_customer . '\',\'' . OrdersLogSms::TYPE_CUSTOMER . '\',\'' . $response_customer['SendMTSResult'] . '\',\'' . time() . '\',\'' . time() . '\', \'' . Yii::app()->controller->site_id . '\')';
        Yii::app()->db->createCommand($log_customer)->execute();
        $input_admin = $input_common;
// thêm các thông số gửi tin cho admin
        if (count($phone_admin_array) > 0) {
            $input_admin['sms'] = $sms_to_admin;
            foreach ($phone_admin_array as $phone_admin) {
                $phone_admin = '84' . ltrim(trim($phone_admin), '0');
                $input_admin['phone'] = $phone_admin;
                $input_admin['cid'] = $order->order_id . '-admin-' . $phone_admin;
                $response_admin = $client->call($config_apisms->function_service, $input_admin);
                $log_admin = 'INSERT INTO orders_log_sms(order_id, phone, type, result, created_time, modified_time, site_id) VALUES (\'' . $order->order_id . '\',\'' . $phone_admin . '\',\'' . OrdersLogSms::TYPE_ADMIN . '\',\'' . $response_admin['SendMTSResult'] . '\',\'' . time() . '\',\'' . time() . '\', \'' . Yii::app()->controller->site_id . '\')';
                Yii::app()->db->createCommand($log_admin)->execute();
            }
        }
    }

    /**
     * @hungtm
     * function send voucher to customer via sms
     * @param type $order
     * @param type $config_apivoucher
     */
    public function sendVoucher($order, $config_apivoucher) {
        $products_voucher = OrderProducts::getProductVoucherInOrder($order->order_id);
        if (isset($products_voucher) && count($products_voucher)) {
            $ws_client = new nusoap_client($config_apivoucher->url, 'wsdl');
            $i = 0;
            $payment_type = 2;
            if ($order->payment_method == Orders::PAYMENT_METHOD_ONEPAY || $order->payment_method == Orders::PAYMENT_METHOD_ONEPAY) {
                $payment_type = 1;
            }
            $payment_status = 2; // chưa thanh toán
            if ($order->payment_status == Orders::ORDER_PAYMENT_STATUS_PAID) {
                $payment_status = 1;
            }
            foreach ($products_voucher as $p_voucher) {
                $i++;
                $order_product_id = $order->order_id . $i;
                $result = $ws_client->call($config_apivoucher->function_service, array(
                    'order_id' => $order_product_id,
                    'order_code' => $order_product_id,
                    'type_code' => '',
                    'price' => (int) $p_voucher['product_price'],
                    'price_order' => (int) $p_voucher['price_market'],
                    'quantity' => (int) $p_voucher['product_qty'],
                    'order_des' => 'Đơn hàng ' . $order_product_id,
                    'time_start' => 0,
                    'time_end' => 0,
                    'phone' => $order->billing_phone,
                    'fullname' => $order->billing_name,
                    'address' => $order->billing_address,
                    'email' => $order->billing_email,
                    'payment_type' => $payment_type,
                    'payment_status' => $payment_status,
                    'site_id' => $config_apivoucher->site_id_onapi,
                    'site_pass' => $config_apivoucher->site_pass_onapi
                ));
                $log_voucher = 'INSERT INTO orders_log_sms(order_id, phone, type, result, created_time, modified_time, site_id) VALUES (\'' . $order->order_id . '\',\'' . $order->billing_phone . '\',\'' . OrdersLogSms::TYPE_VOUCHER . '\',\'' . $result . '\',\'' . time() . '\',\'' . time() . '\', \'' . Yii::app()->controller->site_id . '\')';
                Yii::app()->db->createCommand($log_voucher)->execute();
            }
        }
    }

    /**
     * @hungtm
     * thanh toán onepay quốc tế
     * @param type $order
     */
    public function requestOnepayQuocte($order) {
        $stringHashData = "";
        $config_onepay = SitePayment::getPaymentType(SitePayment::TYPE_ONEPAY_QUOCTE);
        $vpcURL = $config_onepay->url_request . '?';
// Khóa bí mật - được cấp bởi OnePAY
        $SECURE_SECRET = $config_onepay->secure_pass;

        $params = array();
// Các tham số default
        $params['vpc_Version'] = 2; // version module cổng thanh toán
        $params['vpc_Command'] = 'pay'; // Chức năng thanh toán
        $params['vpc_AccessCode'] = $config_onepay->access_code; // OnePAY provider
        $params['vpc_Merchant'] = $config_onepay->merchan_id; // OnePAY provider
        $params['vpc_Locale'] = 'vn'; // ngôn chữ hiển thị trên website
        $params['vpc_ReturnURL'] = Yii::app()->createAbsoluteUrl('economy/shoppingcart/callbackOnepayQuocte', array('id' => $order->order_id, 'key' => $order->key)); // url call back
// Các tham số động
        $params['vpc_MerchTxnRef'] = $order->created_time; // Mã giao dịch, required unique
        $params['vpc_OrderInfo'] = $order->order_id; // Mã đơn hàng
        $params['vpc_Amount'] = $order->order_total * 100; // Khoản tiền thanh toán
        $params['vpc_TicketNo'] = $_SERVER['REMOTE_ADDR']; // Địa chỉ IP khách hàng thực hiện thanh toán
        $params['AgainLink'] = Yii::app()->request->hostInfo . Yii::app()->request->url; // Link trang thanh toán của website trước khi chuyển sang OnePAY
        $params['Title'] = 'Thanh toán trực tuyến bằng thẻ Visa, Credits, Master'; // Tiêu đề cổng thanh toán trên trình duyệt

        ksort($params);
// đặt tham số đếm = 0
        $appendAmp = 0;
        foreach ($params as $key => $value) {
            if (strlen($value) > 0) {
// this ensures the first paramter of the URL is preceded by the '?' char
                if ($appendAmp == 0) {
                    $vpcURL .= urlencode($key) . '=' . urlencode($value);
                    $appendAmp = 1;
                } else {
                    $vpcURL .= '&' . urlencode($key) . "=" . urlencode($value);
                }
//$stringHashData .= $value; *****************************sử dụng cả tên và giá trị tham số để mã hóa*****************************
                if ((strlen($value) > 0) && ((substr($key, 0, 4) == "vpc_") || (substr($key, 0, 5) == "user_"))) {
                    $stringHashData .= $key . "=" . $value . "&";
                }
            }
        }
        $stringHashData = rtrim($stringHashData, "&");
        if (strlen($SECURE_SECRET) > 0) {
// Mã hóa dữ liệu
            $vpcURL .= "&vpc_SecureHash=" . strtoupper(hash_hmac('SHA256', $stringHashData, pack('H*', $SECURE_SECRET)));
        }
        $this->redirect($vpcURL);
    }

    /**
     * @hungtm
     * call back onepay nội địa quốc tế
     */
    public function actionCallbackOnepayQuocte() {
        $id = Yii::app()->request->getParam('id');
        $key = Yii::app()->request->getParam('key');

        $config_onepay = SitePayment::getPaymentType(SitePayment::TYPE_ONEPAY_QUOCTE);
        $SECURE_SECRET = $config_onepay->secure_pass;
// get and remove the vpc_TxnResponseCode code from the response fields as we
// do not want to include this field in the hash calculation
        $vpc_Txn_Secure_Hash = $_GET["vpc_SecureHash"];
        $vpc_MerchTxnRef = $_GET["vpc_MerchTxnRef"];
        $vpc_AcqResponseCode = $_GET["vpc_AcqResponseCode"];
        unset($_GET["vpc_SecureHash"]);
// set a flag to indicate if hash has been validated
        $errorExists = false;

        if (strlen($SECURE_SECRET) > 0 && $_GET["vpc_TxnResponseCode"] != "7" && $_GET["vpc_TxnResponseCode"] != "No Value Returned") {

            ksort($_GET);
//$md5HashData = $SECURE_SECRET;
//khởi tạo chuỗi mã hóa rỗng
            $md5HashData = "";
// sort all the incoming vpc response fields and leave out any with no value
            foreach ($_GET as $key_r => $value) {
//        if ($key != "vpc_SecureHash" or strlen($value) > 0) {
//            $md5HashData .= $value;
//        }
//      chỉ lấy các tham số bắt đầu bằng "vpc_" hoặc "user_" và khác trống và không phải chuỗi hash code trả về
                if ($key_r != "vpc_SecureHash" && (strlen($value) > 0) && ((substr($key_r, 0, 4) == "vpc_") || (substr($key_r, 0, 5) == "user_"))) {
                    $md5HashData .= $key_r . "=" . $value . "&";
                }
            }
//  Xóa dấu & thừa cuối chuỗi dữ liệu
            $md5HashData = rtrim($md5HashData, "&");

//    if (strtoupper ( $vpc_Txn_Secure_Hash ) == strtoupper ( md5 ( $md5HashData ) )) {
//    Thay hàm tạo chuỗi mã hóa
            if (strtoupper($vpc_Txn_Secure_Hash) == strtoupper(hash_hmac('SHA256', $md5HashData, pack('H*', $SECURE_SECRET)))) {
// Secure Hash validation succeeded, add a data field to be displayed
// later.
                $hashValidated = "CORRECT";
            } else {
// Secure Hash validation failed, add a data field to be displayed
// later.
                $hashValidated = "INVALID HASH";
            }
        } else {
// Secure Hash was not validated, add a data field to be displayed later.
            $hashValidated = "INVALID HASH";
        }

        $amount = self::null2unknown($_GET["vpc_Amount"]);
//        $locale = self::null2unknown($_GET["vpc_Locale"]);
//        $batchNo = self::null2unknown($_GET["vpc_BatchNo"]);
//        $command = self::null2unknown($_GET["vpc_Command"]);
        $message = self::null2unknown($_GET["vpc_Message"]);
//        $version = self::null2unknown($_GET["vpc_Version"]);
//        $cardType = self::null2unknown($_GET["vpc_Card"]);
        $orderInfo = self::null2unknown($_GET["vpc_OrderInfo"]);
//        $receiptNo = self::null2unknown($_GET["vpc_ReceiptNo"]);
        $merchantID = self::null2unknown($_GET["vpc_Merchant"]);
//$authorizeID = self::null2unknown($_GET["vpc_AuthorizeId"]);
        $merchTxnRef = self::null2unknown($_GET["vpc_MerchTxnRef"]);
        $transactionNo = self::null2unknown($_GET["vpc_TransactionNo"]);
//        $acqResponseCode = self::null2unknown($_GET["vpc_AcqResponseCode"]);
        $txnResponseCode = self::null2unknown($_GET["vpc_TxnResponseCode"]);
// 3-D Secure Data
//        $verType = array_key_exists("vpc_VerType", $_GET) ? $_GET["vpc_VerType"] : "No Value Returned";
//        $verStatus = array_key_exists("vpc_VerStatus", $_GET) ? $_GET["vpc_VerStatus"] : "No Value Returned";
//        $token = array_key_exists("vpc_VerToken", $_GET) ? $_GET["vpc_VerToken"] : "No Value Returned";
//        $verSecurLevel = array_key_exists("vpc_VerSecurityLevel", $_GET) ? $_GET["vpc_VerSecurityLevel"] : "No Value Returned";
//        $enrolled = array_key_exists("vpc_3DSenrolled", $_GET) ? $_GET["vpc_3DSenrolled"] : "No Value Returned";
//        $xid = array_key_exists("vpc_3DSXID", $_GET) ? $_GET["vpc_3DSXID"] : "No Value Returned";
//        $acqECI = array_key_exists("vpc_3DSECI", $_GET) ? $_GET["vpc_3DSECI"] : "No Value Returned";
//        $authStatus = array_key_exists("vpc_3DSstatus", $_GET) ? $_GET["vpc_3DSstatus"] : "No Value Returned";

        $errorTxt = "";

// Show this page as an error page if vpc_TxnResponseCode equals '7'
        if ($txnResponseCode == "7" || $txnResponseCode == "No Value Returned" || $errorExists) {
            $errorTxt = "Error ";
        }

// This is the display title for 'Receipt' page 
        $title = $_GET["Title"];
        $order = Orders::model()->findByPk($id);
        if (!$order) {
            $this->sendResponse(404);
        }
        if ($order->key != $key) {
            $this->sendResponse(404);
        }
        $transStatus = "";
        if ($hashValidated == "CORRECT" && $txnResponseCode == "0") {
            $transStatus = "Giao dịch thành công";
            $order->payment_status = Orders::ORDER_PAYMENT_STATUS_PAID;
            $order->order_total_paid = $amount / 100;
            $order->save();
        } elseif ($hashValidated == "INVALID HASH" && $txnResponseCode == "0") {
            $transStatus = "Giao dịch Pendding";
            $order->payment_status = Orders::ORDER_PAYMENT_STATUS_PROCESSING;
            $order->save();
        } else {
            $transStatus = "Giao dịch thất bại";
        }
// log thanh toán onepay
        $log_payment = new OrdersLogPayment();
        $log_payment->order_id = $id;
        $log_payment->trans_status = $transStatus;
        $log_payment->merchant_id = $merchantID;
        $log_payment->merch_txn_ref = $merchTxnRef;
        $log_payment->order_info = $orderInfo;
        $log_payment->response_code = $txnResponseCode;
        $log_payment->message = $message;
        $log_payment->transaction_no = $transactionNo;
        $log_payment->amount = $amount;
        $log_payment->created_time = time();
        $log_payment->modified_time = time();
        $log_payment->type = Orders::PAYMENT_METHOD_ONEPAY_QUOCTE;
        $log_payment->site_id = Yii::app()->controller->site_id;
        $log_payment->save();

        /**
         * hungtm
         * kiểm tra xem đơn hàng có sản phẩm voucher hay không
         * nếu có sẽ call api bắn mã voucher cho khách hàng qua số điện thoại
         */
        $config_apivoucher = SiteApivoucher::checkConfigVoucher();
        if ($config_apivoucher) {
            $this->sendVoucher($order, $config_apivoucher);
        }

        /**
         * hungtm
         * kiểm tra xem site có được cấu hình api sms hay không
         * nếu có sẽ call api bắn tin nhắn cho khách hàng qua số điện thoại
         */
        $config_apisms = SiteApisms::checkConfigApisms();
        if ($config_apisms) {
            $this->sendOrderSms($order, $config_apisms);
        }
//
        $this->redirect(Yii::app()->createUrl('/economy/shoppingcart/order', array(
                    'id' => $order->order_id,
                    'key' => $order->key,
        )));
    }

    /**
     * @hungtm
     * thanh toán onepay nội địa
     * @param type $order
     */
    public function requestOnepay($order) {
// Khởi tạo chuỗi dữ liệu mã hóa trống 
        $stringHashData = "";
        $config_onepay = SitePayment::getPaymentType(SitePayment::TYPE_ONEPAY);
        $vpcURL = $config_onepay->url_request . '?';
// Khóa bí mật - được cấp bởi OnePAY
        $SECURE_SECRET = $config_onepay->secure_pass;

// Các tham số default
        $params = array();
        $params['vpc_Version'] = 2; // version module cổng thanh toán
        $params['vpc_Currency'] = 'VND'; // loại tiền thanh toán
        $params['vpc_Command'] = 'pay'; // chức năng thanh toán
        $params['vpc_AccessCode'] = $config_onepay->access_code; // OnePAY provider
        $params['vpc_Merchant'] = $config_onepay->merchan_id; // OnePAY provider
        $params['vpc_Locale'] = 'vn'; // ngôn chữ hiển thị trên website
        $params['vpc_ReturnURL'] = Yii::app()->createAbsoluteUrl('economy/shoppingcart/callbackOnepay', array('id' => $order->order_id, 'key' => $order->key)); // url call back
// Các tham số động
        $params['vpc_MerchTxnRef'] = $order->created_time; // Mã giao dịch, required unique
        $params['vpc_OrderInfo'] = $order->order_id; // Mã đơn hàng
        $params['vpc_Amount'] = $order->order_total * 100; // Khoản tiền thanh toán
        $params['vpc_TicketNo'] = $_SERVER['REMOTE_ADDR']; // Địa chỉ IP khách hàng thực hiện thanh toán
        $params['AgainLink'] = Yii::app()->request->hostInfo . Yii::app()->request->url; // Link trang thanh toán của website trước khi chuyển sang OnePAY
        $params['Title'] = 'Thanh toán trực tuyến bằng thẻ ATM nội địa'; // Tiêu đề cổng thanh toán trên trình duyệt
// Thông tin khách hàng - không bắt buộc
// $params['vpc_SHIP_Street01'] = ''; // Địa chỉ gửi hàng
// $params['vpc_SHIP_Provice'] = ''; // Quận huyện - Địa chỉ gửi hàng
// $params['vpc_SHIP_City'] = ''; // Thành phố - Địa chỉ gửi hàng
// $params['vpc_SHIP_Country'] = ''; // Mã nước - Địa chỉ gửi hàng
// $params['vpc_Customer_Phone'] = ''; // Số điện thoại khách hàng
// $params['vpc_Customer_Email'] = ''; // Email khách hàng
// $params['vpc_Customer_Id'] = ''; // Mã khách hàng
        ksort($params);
        $appendAmp = 0;
        foreach ($params as $key => $value) {

// create the md5 input and URL leaving out any fields that have no value
// tạo chuỗi đầu dữ liệu những tham số có dữ liệu
            if (strlen($value) > 0) {
// this ensures the first paramter of the URL is preceded by the '?' char
                if ($appendAmp == 0) {
                    $vpcURL .= urlencode($key) . '=' . urlencode($value);
                    $appendAmp = 1;
                } else {
                    $vpcURL .= '&' . urlencode($key) . "=" . urlencode($value);
                }
// sử dụng cả tên và giá trị tham số để mã hóa
                if ((strlen($value) > 0) && ((substr($key, 0, 4) == "vpc_") || (substr($key, 0, 5) == "user_"))) {
                    $stringHashData .= $key . "=" . $value . "&";
                }
            }
        }
        $stringHashData = rtrim($stringHashData, "&");

        if (strlen($SECURE_SECRET) > 0) {
// Mã hóa dữ liệu
            $vpcURL .= "&vpc_SecureHash=" . strtoupper(hash_hmac('SHA256', $stringHashData, pack('H*', $SECURE_SECRET)));
        }

        $this->redirect($vpcURL);
    }

    /**
     * @hungtm
     * call back onepay nội địa
     */
    public function actionCallbackOnepay() {
        $id = Yii::app()->request->getParam('id');
        $key = Yii::app()->request->getParam('key');

        $config_onepay = SitePayment::getPaymentType(SitePayment::TYPE_ONEPAY);
        $SECURE_SECRET = $config_onepay->secure_pass;
        $vpc_Txn_Secure_Hash = $_GET["vpc_SecureHash"];

// set a flag to indicate if hash has been validated
        $errorExists = false;
        ksort($_GET);

        if (strlen($SECURE_SECRET) > 0 && $_GET["vpc_TxnResponseCode"] != "7" && $_GET["vpc_TxnResponseCode"] != "No Value Returned") {
            $stringHashData = "";

            foreach ($_GET as $key_r => $value) {
// chỉ lấy các tham số bắt đầu bằng "vpc_" hoặc "user_" và khác trống và không phải chuỗi hash code trả về
                if ($key_r != "vpc_SecureHash" && (strlen($value) > 0) && ((substr($key_r, 0, 4) == "vpc_") || (substr($key_r, 0, 5) == "user_"))) {
                    $stringHashData .= $key_r . "=" . $value . "&";
                }
            }

            $stringHashData = rtrim($stringHashData, "&");

// Thay hàm tạo chuỗi mã hóa
            if (strtoupper($vpc_Txn_Secure_Hash) == strtoupper(hash_hmac('SHA256', $stringHashData, pack('H*', $SECURE_SECRET)))) {
// Secure Hash validation succeeded, add a data field to be displayed
// later.
                $hashValidated = "CORRECT";
            } else {
// Secure Hash validation failed, add a data field to be displayed
// later.
                $hashValidated = "INVALID HASH";
            }
        } else {
// Secure Hash was not validated, add a data field to be displayed later.
            $hashValidated = "INVALID HASH";
        }

// Standard Receipt Data
        $amount = self::null2unknown($_GET["vpc_Amount"]);
        $locale = self::null2unknown($_GET["vpc_Locale"]);
// $batchNo = null2unknown ( $_GET ["vpc_BatchNo"] );
        $command = self::null2unknown($_GET["vpc_Command"]);
        $message = self::null2unknown($_GET["vpc_Message"]);
        $version = self::null2unknown($_GET["vpc_Version"]);
// $cardType = null2unknown ( $_GET ["vpc_Card"] );
        $orderInfo = self::null2unknown($_GET["vpc_OrderInfo"]);
// $receiptNo = null2unknown ( $_GET ["vpc_ReceiptNo"] );
        $merchantID = self::null2unknown($_GET["vpc_Merchant"]);
// $authorizeID = null2unknown ( $_GET ["vpc_AuthorizeId"] );
        $merchTxnRef = self::null2unknown($_GET["vpc_MerchTxnRef"]);
        $transactionNo = self::null2unknown($_GET["vpc_TransactionNo"]);
// $acqResponseCode = null2unknown ( $_GET ["vpc_AcqResponseCode"] );
        $txnResponseCode = self::null2unknown($_GET["vpc_TxnResponseCode"]);
        $transStatus = "";
        $order = Orders::model()->findByPk($id);
        if (!$order) {
            $this->sendResponse(404);
        }
        if ($order->key != $key) {
            $this->sendResponse(404);
        }
        if ($hashValidated == "CORRECT" && $txnResponseCode == "0") {
            $transStatus = "Giao dịch thành công";
            $order->payment_status = Orders::ORDER_PAYMENT_STATUS_PAID;
            $order->order_total_paid = $amount / 100;
            $order->save();
        } elseif ($hashValidated == "INVALID HASH" && $txnResponseCode == "0") {
            $transStatus = "Giao dịch Pendding";
            $order->payment_status = Orders::ORDER_PAYMENT_STATUS_PROCESSING;
            $order->save();
        } else {
            $transStatus = "Giao dịch thất bại";
        }

// log thanh toán onepay
        $log_payment = new OrdersLogPayment();
        $log_payment->order_id = $id;
        $log_payment->trans_status = $transStatus;
        $log_payment->merchant_id = $merchantID;
        $log_payment->merch_txn_ref = $merchTxnRef;
        $log_payment->order_info = $orderInfo;
        $log_payment->response_code = $txnResponseCode;
        $log_payment->message = $message;
        $log_payment->transaction_no = $transactionNo;
        $log_payment->amount = $amount;
        $log_payment->created_time = time();
        $log_payment->modified_time = time();
        $log_payment->type = Orders::PAYMENT_METHOD_ONEPAY;
        $log_payment->site_id = Yii::app()->controller->site_id;
        $log_payment->save();

        /**
         * hungtm
         * kiểm tra xem đơn hàng có sản phẩm voucher hay không
         * nếu có sẽ call api bắn mã voucher cho khách hàng qua số điện thoại
         */
        $config_apivoucher = SiteApivoucher::checkConfigVoucher();
        if ($config_apivoucher) {
            $this->sendVoucher($order, $config_apivoucher);
        }

        /**
         * hungtm
         * kiểm tra xem site có được cấu hình api sms hay không
         * nếu có sẽ call api bắn tin nhắn cho khách hàng qua số điện thoại
         */
        $config_apisms = SiteApisms::checkConfigApisms();
        if ($config_apisms) {
            $this->sendOrderSms($order, $config_apisms);
        }
//
        $this->redirect(Yii::app()->createUrl('/economy/shoppingcart/order', array(
                    'id' => $order->order_id,
                    'key' => $order->key,
        )));
    }

    public static function null2unknown($data) {
        if ($data == "") {
            return "No Value Returned";
        } else {
            return $data;
        }
    }

    /**
     * Thêm sp vào giỏ hàng
     */
    public function actionAdd() {
        $product_id = (int) Yii::app()->request->getParam('pid');
        $quantity = (int) Yii::app()->request->getParam('qty');
        $attributes = Yii::app()->request->getParam(ClaShoppingCart::PRODUCT_ATTRIBUTE_CONFIGURABLE_KEY);

        if (!$quantity || $quantity < 0)
            $quantity = 1;
        if ($product_id) {
            $product = Product::model()->findByPk($product_id);
            if ($product && $product->site_id == $this->site_id) {
                $saveAttributes = array();
                $key = $product_id;
                if ($attributes && count($attributes)) {
                    foreach ($attributes as $attribute_id => $configurable_value) {
                        $attr = ProductAttribute::model()->findByPk($attribute_id);
                        if ($attr->site_id != $this->site_id)
                            continue;
                        $attrOption = AttributeHelper::helper()->getSingleAttributeOption($attribute_id, $configurable_value);
                        if (!$attrOption)
                            continue;
                        $saveAttributes['attributes'][$attribute_id]['name'] = $attr['name'];
                        $saveAttributes['attributes'][$attribute_id]['value'] = $attrOption['value'];
                        $saveAttributes['attributes'][$attribute_id]['type_option'] = $attr['type_option'];
                        $saveAttributes['attributes'][$attribute_id]['ext'] = $attrOption['ext'];
                        $saveAttributes['attributes'][$attribute_id]['field_configurable'] = 'attribute' . $attr['field_configurable'] . '_value';
                        $saveAttributes['attributes'][$attribute_id]['field_configurable_value'] = $configurable_value;
                        $key.= $configurable_value;
                    }
//
                }
//
                $shoppingCart = Yii::app()->customer->getShoppingCart();
                $shoppingCart->add($key, array('product_id' => $product_id, 'qty' => intval($quantity), 'price' => $product->price, ClaShoppingCart::MORE_INFO => $saveAttributes));
                if (Yii::app()->request->isAjaxRequest) {
                    $this->jsonResponse('200', array(
                        'message' => 'success',
                        'total' => Yii::app()->customer->getShoppingCart()->countProducts(),
                        'products' => Yii::app()->customer->getShoppingCart()->countOnlyProducts(),
                        'redirect' => Yii::app()->createUrl('/economy/shoppingcart'),
                        'cartTitle' => Yii::t('shoppingcart', 'shoppingcart') . ' (' . Yii::app()->customer->getShoppingCart()->countOnlyProducts() . ')',
                        'cart' => $this->renderPartial('cart_ajax', array(
                            'shoppingCart' => $shoppingCart,
                                ), true),
                    ));
                } else
                    $this->redirect(Yii::app()->createUrl('/economy/shoppingcart'));
            }
        }
    }

    /**
     * Hatv
     * Thêm thay đổi số lượng sản phẩm trong giỏ hàng
     */
    public function actionChangeQty() {
        $product_id = (int) Yii::app()->request->getParam('pid');
        $quantity = (int) Yii::app()->request->getParam('qty');
        $attributes = Yii::app()->request->getParam(ClaShoppingCart::PRODUCT_ATTRIBUTE_CONFIGURABLE_KEY);

        if (!$quantity || $quantity < 0)
            $quantity = 1;
        if ($product_id) {
            $product = Product::model()->findByPk($product_id);
            if ($product && $product->site_id == $this->site_id) {
                $saveAttributes = array();
                $key = $product_id;
                if ($attributes && count($attributes)) {
                    foreach ($attributes as $attribute_id => $configurable_value) {
                        $attr = ProductAttribute::model()->findByPk($attribute_id);
                        if ($attr->site_id != $this->site_id)
                            continue;
                        $attrOption = AttributeHelper::helper()->getSingleAttributeOption($attribute_id, $configurable_value);
                        if (!$attrOption)
                            continue;
                        $saveAttributes['attributes'][$attribute_id]['name'] = $attr['name'];
                        $saveAttributes['attributes'][$attribute_id]['value'] = $attrOption['value'];
                        $saveAttributes['attributes'][$attribute_id]['type_option'] = $attr['type_option'];
                        $saveAttributes['attributes'][$attribute_id]['ext'] = $attrOption['ext'];
                        $saveAttributes['attributes'][$attribute_id]['field_configurable'] = 'attribute' . $attr['field_configurable'] . '_value';
                        $saveAttributes['attributes'][$attribute_id]['field_configurable_value'] = $configurable_value;
                        $key.= $configurable_value;
                    }
//
                }
//
                $shoppingCart = Yii::app()->customer->getShoppingCart();
                $shoppingCart->changeQty($key, array('product_id' => $product_id, 'qty' => intval($quantity), 'price' => $product->price, ClaShoppingCart::MORE_INFO => $saveAttributes));
                if (Yii::app()->request->isAjaxRequest) {
                    $this->jsonResponse('200', array(
                        'message' => 'success',
                        'total' => Yii::app()->customer->getShoppingCart()->countProducts(),
                        'products' => Yii::app()->customer->getShoppingCart()->countOnlyProducts(),
                        'redirect' => Yii::app()->createUrl('/economy/shoppingcart'),
                        'cartTitle' => Yii::t('shoppingcart', 'shoppingcart') . ' (' . Yii::app()->customer->getShoppingCart()->countOnlyProducts() . ')',
                        'cart' => $this->renderPartial('cart_ajax', array(
                            'shoppingCart' => $shoppingCart,
                                ), true),
                    ));
                } else
                    $this->redirect(Yii::app()->createUrl('/economy/shoppingcart'));
            }
        }
    }

    /**
     * Cập nhật giỏ hàng
     */
    public function actionUpdate() {
        $key = (int) Yii::app()->request->getParam('key');
        $quantity = (int) Yii::app()->request->getParam('qty');
        if ($quantity <= 0)
            $quantity = 1;
        if ($key && $quantity) {
            $shoppingCart = Yii::app()->customer->getShoppingCart();
            $cartInfo = $shoppingCart->getInfoByKey($key);
            $product = Product::model()->findByPk($cartInfo['product_id']);
            if ($product && $product->site_id == $this->site_id) {
                $shoppingCart->update($key, array('qty' => $quantity, 'price' => $product->price, 'product_id' => $product['id']));
//
                if (Yii::app()->request->isAjaxRequest) {
                    $this->jsonResponse('200', array(
                        'message' => 'success',
                        'total' => Yii::app()->customer->getShoppingCart()->countProducts(),
                    ));
                } else
                    $this->redirect(Yii::app()->createUrl('/economy/shoppingcart'));
            }
        }
    }

    /**
     * xóa product khỏi shopping cart
     */
    public function actionDelete() {
        $key = (int) Yii::app()->request->getParam('key');
        if ($key) {
            $shoppingCart = Yii::app()->customer->getShoppingCart();
            $cartInfo = $shoppingCart->getInfoByKey($key);
            $product = Product::model()->findByPk($cartInfo['product_id']);
//
            if ($product && $product->site_id == $this->site_id) {
                $shoppingCart->remove($key);
//
                if (Yii::app()->request->isAjaxRequest) {
                    $this->jsonResponse('200', array(
                        'message' => 'success',
                        'total' => Yii::app()->customer->getShoppingCart()->countProducts(),
                    ));
                } else
                    $this->redirect(Yii::app()->createUrl('/economy/shoppingcart'));
            }
        }
    }

    public function actionOrder() {
        $id = Yii::app()->request->getParam('id');
        $key = Yii::app()->request->getParam('key');
        if ($id && $key) {
            $order = Orders::model()->findByPk($id);
            if (!$order)
                $this->sendResponse(404);
            if ($order->key != $key)
                $this->sendResponse(404);
            $products = OrderProducts::getProductsDetailInOrder($id);
//
            $paymentmethod = Orders::getPaymentMethodInfo($order->payment_method);
            $transportmethod = Orders::getTransportMethodInfo($order->transport_method);
//
            $this->render('order', array(
                'order' => $order->attributes,
                'products' => $products,
                'paymentmethod' => $paymentmethod,
                'transportmethod' => $transportmethod,
            ));
//
        }
    }

    public function actionGuide() {
        $id = Yii::app()->request->getParam('id');
        $key = Yii::app()->request->getParam('key');
        $guide = Yii::app()->request->getParam('guide');
        if ($id && $key && $guide) {
            $link_order = Yii::app()->createUrl('/economy/shoppingcart/order', array(
                'id' => $id,
                'key' => $key,
            ));
            $guide = base64_decode($guide);
            $this->render('guide', array(
                'link_order' => $link_order,
                'guide' => $guide,
            ));
        }
    }

    /**
     * for template chọn món ăn
     */
    public function actionUpdateAjax() {
        $product_id = (int) Yii::app()->request->getParam('pid');
        $quantity = (int) Yii::app()->request->getParam('qty');
        $type = Yii::app()->request->getParam('type');
        if (!$quantity || $quantity < 0) {
            $quantity = 1;
        }
        if ($product_id) {
            $product = Product::model()->findByPk($product_id);
            if ($product && $product->site_id == $this->site_id) {
                $saveAttributes = array();
                $key = $product_id;
                $shoppingCart = Yii::app()->customer->getShoppingCart();
                if ($type == 'delete') {
                    $shoppingCart->remove($product_id);
                } else if ($type == 'update') {
                    $shoppingCart->update($key, array('qty' => $quantity, 'price' => $product->price, 'product_id' => $product_id));
                } else {
                    $shoppingCart->add($key, array('product_id' => $product_id, 'qty' => intval($quantity), 'price' => $product->price, ClaShoppingCart::MORE_INFO => $saveAttributes));
                }
                if (Yii::app()->request->isAjaxRequest) {
                    $count_products = count($shoppingCart->findAllProducts());
                    $html = $this->renderPartial('pack', array(
                        'shoppingCart' => $shoppingCart,
                        'count_product' => $count_products,
                            ), true);
                    $this->jsonResponse('200', array(
                        'html' => $html,
                        'type' => $type,
                        'count_product' => $count_products,
                    ));
                }
            }
        }
    }

    /**
     * action add multi product for Navesi
     */
    public function actionAddMulti() {
        $ary_product = Yii::app()->request->getParam('ary_data');

        foreach ($ary_product as $product_id_qty) {
            foreach ($product_id_qty as $product_id => $quantity) {
                $product = Product::model()->findByPk($product_id);
                if ($product && $product->site_id == $this->site_id) {
                    $saveAttributes = array();
                    $key = $product_id;
                    $shoppingCart = Yii::app()->customer->getShoppingCart();
                    if ($quantity == 0) {
                        $shoppingCart->remove($product_id);
                    } else {
                        $shoppingCart->add($key, array('product_id' => $product_id, 'qty' => intval($quantity), 'price' => $product->price, ClaShoppingCart::MORE_INFO => $saveAttributes));
                    }
                }
            }
        }
        $this->jsonResponse(200, array(
            'ary_product' => $ary_product
        ));
    }

    public function actionOtp() {
        $transaction_id = 1;
        Yii::app()->user->getState('pmbk_transaction_id');
        $order_id = 1;
        Yii::app()->user->getState('pmbk_otp_order_id');
        $order_key = 1;
        Yii::app()->user->getState('order_key');
        if ($transaction_id) {
            if (isset($_POST['otp'])) {
                $otp = $_POST['otp'];
                $resultVerify = BaokimHelper::helper()->verifyOTP($transaction_id, $otp);
                if ($resultVerify['success']) {
                    Yii::app()->user->setState('pmbk_transaction_id', null);
                    Yii::app()->user->setState('pmbk_otp_order_id', null);
                    Yii::app()->user->setState('pmbk_order_key', null);
                    Yii::app()->user->setFlash('otp_successs', true);
                    $this->redirect(array('/economy/shoppingcart/order', 'id' => $order_id, 'key' => $order_key));
                } else {
                    Yii::app()->user->setFlash('otp_error', $resultVerify['error']);
                }
            }
            $this->render('confirmOTP', array());
        } else {
            Yii::app()->user->setFlash('error', "Không tồn tại mã giao dịch với bảo kim");
            $this->redirect(array('/economy/shoppingcart/order', 'id' => $order_id, 'key' => $order_key));
        }
    }

    public function actionGetdiscount() {
        $code = Yii::app()->request->getParam('code');
        if (isset($code) && $code != '') {
            $coupon_code = CouponCode::model()->findByAttributes(array('code' => $code));
            if ($coupon_code === NULL) {
                $this->jsonResponse(404);
            }
            if ($coupon_code->site_id != Yii::app()->controller->site_id) {
                $this->jsonResponse(404);
            }
            $coupon_campaign = CouponCampaign::model()->findByPk($coupon_code->campaign_id);
            $shoppingCart = Yii::app()->customer->getShoppingCart();
            $shoppingCart->addCouponCode($code);
            $this->jsonResponse(200, $coupon_campaign->attributes);
        }
        $this->jsonResponse(404);
    }

    public function actionGetshipfee() {
        $pid = Yii::app()->request->getParam('pid');
        $did = Yii::app()->request->getParam('did');
        $shipfeeweight = $this->getShipfeeWithWeight();
        $shipfee = 0;
        if ($pid && $did) {
            $data_shipfee = SiteConfigShipfee::getAllConfigShipfee();
            $data_compare = array();
            foreach ($data_shipfee as $shipfee_item) {
                $key = $shipfee_item['province_id'] . $shipfee_item['district_id'];
                $data_compare[$key] = $shipfee_item;
            }
            $key_compare1 = $pid . $did;
            $key_compare2 = $pid . 'all';
            $key_compare3 = 'allall';
            if (isset($data_compare[$key_compare1]) && !empty($data_compare[$key_compare1])) {
                $shipfee += $data_compare[$key_compare1]['price'];
            } else if (isset($data_compare[$key_compare2]) && !empty($data_compare[$key_compare2])) {
                $shipfee += $data_compare[$key_compare2]['price'];
            } else if (isset($data_compare[$key_compare3]) && !empty($data_compare[$key_compare3])) {
                $shipfee += $data_compare[$key_compare3]['price'];
            }
            $this->jsonResponse(200, array(
                'shipfee' => $shipfee,
                'shipfeeweight' => $shipfeeweight,
            ));
        }
        $this->jsonResponse(404);
    }

    public function actionGetdistrictAndshipfee() {
        $province_id = Yii::app()->request->getParam('pid');
        $shipfeeweight = $this->getShipfeeWithWeight();
        $shipfee = 0;
        if ($province_id) {
            $data_shipfee = SiteConfigShipfee::getAllConfigShipfee();
            $data_compare = array();
            foreach ($data_shipfee as $shipfee_item) {
                $key = $shipfee_item['province_id'] . $shipfee_item['district_id'];
                $data_compare[$key] = $shipfee_item;
            }
            $key_compare1 = $province_id . 'all';
            $key_compare2 = 'allall';
            if (isset($data_compare[$key_compare1]) && !empty($data_compare[$key_compare1])) {
                $temp = $data_compare[$key_compare1]['price'];
                $shipfee += $temp;
            } else if (isset($data_compare[$key_compare2]) && !empty($data_compare[$key_compare2])) {
                $shipfee += $data_compare[$key_compare2]['price'];
            }
            $listdistrict = LibDistricts::getListDistrictFollowProvince($province_id);
            if ($listdistrict) {
                $this->jsonResponse('200', array(
                    'shipfee' => $shipfee,
                    'shipfeeweight' => $shipfeeweight,
                    'html' => $this->renderPartial('ldistrict', array('listdistrict' => $listdistrict), true),
                ));
            }
        } else {
            $listdistrict = array();
            $this->jsonResponse('200', array(
                'html' => $this->renderPartial('ldistrict', array(
                    'shipfee' => $shipfee,
                    'shipfeeweight' => $shipfeeweight,
                    'listdistrict' => $listdistrict), true),
            ));
        }
    }

    public function getShipfeeWithWeight() {
        $shoppingCart = Yii::app()->customer->getShoppingCart();
        $products = $shoppingCart->findAllProducts();
        $weight = (float) 0;
        $shipfee = (float) 0;
        foreach ($products as $product) {
            $weight += $product['weight'];
        }
        $data_config = SiteConfigShipfeeWeight::getAllConfigShipfeeWeight();
        if (isset($data_config) && count($data_config)) {
            foreach ($data_config as $config) {
                if ($weight == 0) {
                    if ((int) $config['from'] == 0) {
                        $shipfee += $config['price'];
                    }
                } else {
                    if ($weight > $config['from'] && $weight <= $config['to']) {
                        $shipfee += $config['price'];
                    }
                }
            }
        }
        return $shipfee;
    }

    public function actionGetdiscountCoupon() {
        $code = Yii::app()->request->getParam('code');
        if (isset($code) && $code != '') {
            $coupon_code = CouponCode::model()->findByAttributes(array('code' => $code));
            if ($coupon_code === NULL) {
                $this->jsonResponse(404);
            }
            if ($coupon_code->site_id != Yii::app()->controller->site_id) {
                $this->jsonResponse(404);
            }
            $coupon_campaign = CouponCampaign::model()->findByPk($coupon_code->campaign_id);
            $shoppingCart = Yii::app()->customer->getShoppingCart();
            $shoppingCart->addCouponCode($code);
            $this->jsonResponse(200, $coupon_campaign->attributes);
        }
        $this->jsonResponse(404);
    }

    // Kiểm tra và lưu số tạm số điểm user dùng trong bảng tích điểm.
    public function actionGetdiscountPoint() {
        $point_used = Yii::app()->request->getParam('point_used');
        if (isset($point_used) && $point_used != '') {
            //check point
            $user_point = ClaUser::getUserInfo(Yii::app()->user->id)['bonus_point'];
            $config_bonus = BonusConfig::checkBonusConfig();
            if ($config_bonus === NULL || $config_bonus->status == false || $point_used > $user_point) {
                $this->jsonResponse(404);
            }
            $shoppingCart = Yii::app()->customer->getShoppingCart();
            $shoppingCart->addPointUsed($point_used);
            $this->jsonResponse(200, array('point_bonus' => $point_used));
        }
        $this->jsonResponse(404);
    }

    // Trừ điểm sau khi đã thanh toán.
    public function actionDemerit_discount_points() {
        
    }

}
