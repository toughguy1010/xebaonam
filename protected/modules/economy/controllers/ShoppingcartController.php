<?php

class ShoppingcartController extends PublicController
{

    public $layout = '//layouts/shopping';

    public function actionIndex()
    {
        $shoppingCart = Yii::app()->customer->getShoppingCart();
        $this->redirect('thanh-toan.html?step=s2&user=guest');
        $this->pageTitle = $this->metakeywords = Yii::t('shoppingcart', 'shoppingcart');
        if (!Yii::app()->siteinfo['use_shoppingcart_set']) {
            $this->render('index', array(
                'shoppingCart' => $shoppingCart
            ));
        } else {
            $this->render('index_set', array(
                'shoppingCart' => $shoppingCart
            ));
        }
    }

    public function actionCheckout()
    {
        //
        $this->layoutForAction = '//layouts/checkout';
        //
        $shoppingCart = Yii::app()->customer->getShoppingCart();
        // Luồng Defaut
        if (!Yii::app()->siteinfo['use_shoppingcart_set']) {
            if (!$shoppingCart->countOnlyProducts()) {
                $this->redirect(Yii::app()->homeUrl);
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
            $user_address = array();

            switch ($step) {
                case 's1':
                    {
                        if (Yii::app()->user->isGuest) {
                            break;
                        }
                    }
                default:
                    {
                        $view = 'checkout_s2';
                        $billing = new Billing();
                        $billing->billtoship = 1;
                        if (!Yii::app()->user->isGuest) {
                            $userinfo = ClaUser::getUserInfo(Yii::app()->user->id);
                            $user_address = Users::getUserAddress(Yii::app()->user->id);
                            $user_address['0'] = $userinfo;
                            if ($userinfo) {
                                $billing->name = $userinfo['name'];
                                if ($userinfo['address'])
                                    $billing->address = $userinfo['address'];
                                if ($userinfo['email'])
                                    $billing->email = $userinfo['email'];
                                if ($userinfo['phone'])
                                    $billing->phone = $userinfo['phone'];
                                if ($userinfo['zipcode'])
                                    $billing->zipcode = $userinfo['zipcode'];
                                if ($userinfo['province_id'])
                                    $billing->city = $userinfo['province_id'];
                                if ($userinfo['district_id'])
                                    $billing->district = $userinfo['district_id'];
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
                                $order->billing_zipcode = $billing->zipcode;
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
                                if (!$order->isPaymentNganluong()) {
                                    if (!isset($paymentMethod[$order->payment_method])) {
                                        $order->payment_method = null;
                                    }
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
                                if (isset($_COOKIE['shop_id']) && $_COOKIE['shop_id']) {
                                    $order->shop_id = $_COOKIE['shop_id'];
                                }
                                $order->coupon_code = $shoppingCart->getCouponCode();

                                //Bonus point kiểm tra
                                $configBonus = BonusConfig::checkBonusConfig();
                                if (!Yii::app()->user->isGuest) {
                                    if (isset($configBonus) && $configBonus->status == true) {
                                        $order->bonus_point_used = $shoppingCart->getPointUsed();
                                    } else {
                                        $order->bonus_point_used = 0;
                                    }
                                }
                                //Note Shoppingcart Set

                                // check hình thức thanh toán không phải tại cửa hàng
                                if ($order->payment_method != 1) {
                                    $order->transport_freight = Orders::getShipfee($order->shipping_city, $order->shipping_district);
                                }
                                $total_price_discount = $shoppingCart->getTotalPriceDiscount();
                                $percent_vat = Yii::app()->siteinfo['percent_vat'];
                                $vat = 0;
                                if ($percent_vat > 0) {
                                    $vat = $total_price_discount - (((100 - $percent_vat) / 100) * $total_price_discount);
                                    $order->vat = $vat;
                                }

                                $discount_for_dealers = 0;
                                if (!Yii::app()->user->isGuest && $userinfo['type'] == 4) {
                                    //Giảm giá cho đại lý @authot: hatv
                                    $percent_discount = Yii::app()->siteinfo['dealers_discount'];
                                    if ($percent_discount > 0 && $total_price_discount > 0) {
                                        $discount_for_dealers = $total_price_discount - (((100 - $percent_discount) / 100) * $total_price_discount);
                                        $order->discount_for_dealers = $discount_for_dealers;
                                    }
                                }

                                $order->old_order_total = $shoppingCart->getTotalPrice(false);
                                $order->order_total = $total_price_discount + $vat - $discount_for_dealers;
                                // Check payment method to add $order->transport_freight
                                if ($order->payment_method != 1) {
                                    $order->order_total += $order->transport_freight;
                                }

                                /* Section bonus point */
                                // Calculate number bonus point after complete Order Request
                                $bonusPointFromOrderTotal = ($configBonus->plus_point > 0) ? round(($order->order_total / $configBonus->plus_point)) : 0;

                                // Add wait_bonus_point and donate_total to Order Model
                                $order->wait_bonus_point = $shoppingCart->getTotalBonusPoint() + $bonusPointFromOrderTotal;
                                $order->donate_total = $shoppingCart->getTotalDonate();
                                $order->currency = $shoppingCart->getProductCurrency();

                                if ($order->save()) {
                                    // Update coupon used-number
                                    if ($order->coupon_code) {
                                        $coupon_code = CouponCode::model()->findByAttributes(array(
                                            'code' => $order->coupon_code
                                        ));
                                        $coupon_code->used++;
                                        $coupon_code->save();
                                    }

                                    /**
                                     * Write log to db and use point.
                                     * */
                                    $bonusConfig = BonusConfig::checkBonusConfig();
                                    if (!Yii::app()->user->isGuest && $order->bonus_point_used != 0 && $bonusConfig) {
                                        $user = Users::model()->findByPk(Yii::app()->user->id);
                                        $options = ['note' => BonusPointLog::BONUS_NOTE_USE_POINT_IN_ORDER];
                                        $user->usePoint($shoppingCart->getPointUsed(), $options, $order->attributes);
                                    }
                                    /* -- End use point -- */

                                    Yii::app()->user->setFlash('success', Yii::t('shoppingcart', 'order_success_notice'));
                                    $products = $shoppingCart->findAllProducts();
                                    foreach ($products as $key => $product) {
                                        $orderProduct = new OrderProducts();
                                        $orderProduct->product_id = $product['id'];
                                        $orderProduct->is_configurable = $product['is_configurable'];
                                        $orderProduct->id_product_link = $key;
                                        $orderProduct->order_id = $order->order_id;
                                        $orderProduct->product_qty = $shoppingCart->getQuantity($key);
                                        $orderProduct->product_price = $product['price'];
                                        $atts = $shoppingCart->getAttributesByKey($key);
                                        if ($atts) {
                                            $orderProduct->product_attributes = json_encode($atts);
                                        }
                                        $orderProduct->save();
                                    }

                                    // AFFILIATE
                                    $affiliate_id_cookie = Yii::app()->request->cookies[AffiliateLink::AFFILIATE_NAME]->value;
                                    if (isset($affiliate_id_cookie) && $affiliate_id_cookie) {
                                        $affiliate = AffiliateLink::model()->findByPk($affiliate_id_cookie);
                                        // get cookie click
                                        $aff_click_id = Yii::app()->request->cookies[AffiliateClick::AFFILIATE_CLICK]->value;
                                        //
                                        $aff_config = AffiliateConfig::model()->findByPk(Yii::app()->controller->site_id);
                                        if ($affiliate->type == AffiliateLink::TYPE_CATEGORY) {
                                            $check = false;
                                            $aff_product_id = [];
                                            foreach ($products as $product_id => $product) {
                                                $track = explode(' ', $product['category_track']);
                                                if (in_array($affiliate->object_id, $track)) {
                                                    $check = true;
                                                    $aff_product_id[] = $product_id;
                                                }
                                            }
                                            if ($check) {
                                                $affiliate_order = new AffiliateOrder();
                                                $affiliate_order->user_id = $affiliate->user_id;
                                                $affiliate_order->affiliate_id = $affiliate_id_cookie;
                                                $affiliate_order->affiliate_click_id = $aff_click_id;
                                                $affiliate_order->order_id = $order->order_id;
                                                $affiliate_order->product_ids = implode(',', $aff_product_id);
                                                if ($affiliate_order->save()) {
                                                    foreach ($aff_product_id as $key => $pid) {
                                                        $prd = $products[$pid];
                                                        $aff_order_item = new AffiliateOrderItems();
                                                        $aff_order_item->user_id = $affiliate->user_id;
                                                        $aff_order_item->affiliate_id = $affiliate_id_cookie;
                                                        $aff_order_item->affiliate_click_id = $aff_click_id;
                                                        $aff_order_item->affiliate_order_id = $affiliate_order->id;
                                                        $aff_order_item->order_id = $order->order_id;
                                                        $aff_order_item->product_id = $pid;
                                                        $aff_order_item->product_price = $prd['price'];
                                                        $qty = $shoppingCart->getQuantity($pid);
                                                        $aff_order_item->product_qty = $qty;
                                                        $aff_order_item->track_commission_percent = $aff_config->commission_order;
                                                        $aff_order_item->commission = ($prd['price'] * $qty * $aff_config->commission_order) / 100;
                                                        $aff_order_item->save();
                                                    }
                                                }
                                                unset(Yii::app()->request->cookies[AffiliateLink::AFFILIATE_NAME]);
                                                unset(Yii::app()->request->cookies[AffiliateClick::AFFILIATE_CLICK]);
                                            }
                                        } else if ($affiliate->type == AffiliateLink::TYPE_PRODUCT) {
                                            $check = false;
                                            $aff_product_id = 0;
                                            foreach ($products as $product_id => $product) {
                                                if ($affiliate->object_id == $product_id) {
                                                    $check = true;
                                                    $aff_product_id = $product_id;
                                                    break;
                                                }
                                            }
                                            if ($check) {
                                                $affiliate_order = new AffiliateOrder();
                                                $affiliate_order->user_id = $affiliate->user_id;
                                                $affiliate_order->affiliate_id = $affiliate_id_cookie;
                                                $affiliate_order->affiliate_click_id = $aff_click_id;
                                                $affiliate_order->order_id = $order->order_id;
                                                $affiliate_order->product_ids = $aff_product_id;
                                                if ($affiliate_order->save()) {
                                                    $prd = $products[$aff_product_id];
                                                    $aff_order_item = new AffiliateOrderItems();
                                                    $aff_order_item->user_id = $affiliate->user_id;
                                                    $aff_order_item->affiliate_id = $affiliate_id_cookie;
                                                    $aff_order_item->affiliate_click_id = $aff_click_id;
                                                    $aff_order_item->affiliate_order_id = $affiliate_order->id;
                                                    $aff_order_item->order_id = $order->order_id;
                                                    $aff_order_item->product_id = $aff_product_id;
                                                    $aff_order_item->product_price = $prd['price'];
                                                    $qty = $shoppingCart->getQuantity($aff_product_id);
                                                    $aff_order_item->product_qty = $qty;
                                                    $aff_order_item->track_commission_percent = $aff_config->commission_order;
                                                    $aff_order_item->commission = ($prd['price'] * $qty * $aff_config->commission_order) / 100;
                                                    $aff_order_item->save();
                                                }
                                                unset(Yii::app()->request->cookies[AffiliateLink::AFFILIATE_NAME]);
                                                unset(Yii::app()->request->cookies[AffiliateClick::AFFILIATE_CLICK]);
                                            }
                                        }
                                    }
                                    // END AFFILIATE
                                    //
                                    // Send email for admin
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
                                            'fr' => (isset($_SESSION['fr']) && $_SESSION['fr']) ? $_SESSION['fr'] : ''
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

                                    // Send email for admin with content _product_mail_settings
                                    $mailSetting_content = MailSettings::model()->mailScope()->findByAttributes(array(
                                        'mail_key' => 'content_shopping_mail',
                                    ));
                                    if ($mailSetting_content) {
                                        //Hiện ra danh sách sản phẩm được chọn.
                                        $order_prd = $this->renderPartial('_product_mail_settings', array(
                                            'order' => $order,
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
                                            'fr' => (isset($_SESSION['fr']) && $_SESSION['fr']) ? $_SESSION['fr'] : ''
                                        );

                                        //
                                        $content = $order_prd;
                                        //
                                        $subject = $mailSetting_content->getMailSubject($data);
                                        //
                                        if ($content && $subject) {
                                            Yii::app()->mailer->send('', Yii::app()->siteinfo['admin_email'], $subject, $content);
                                            //$mailer->send($from, $email, $subject, $message);
                                        }
                                    }

                                    /*
                                     * send mail for customer
                                     * */
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
                                    $mailSetting3 = MailSettings::model()->mailScope()->findByAttributes(array(
                                        'mail_key' => 'order_rent',
                                    ));
                                    if ($mailSetting3) {
                                        //Hiện ra danh sách sản phẩm được chọn.
                                        $order_prd = $this->renderPartial('_product_mail_settings', array(
                                            'products' => $products,
                                            'order' => $order,
                                            'shoppingCart' => $shoppingCart,), true);
                                        if (isset($order->shop_id) && $order->shop_id != "") {
                                            $mailtoshop = ShopStore::model()->findByPk($order->shop_id)->email;
                                        } else {
                                            $mailtoshop = Yii::app()->siteinfo['admin_email'];
                                        }
                                        //
                                        $content = $order_prd;
                                        //
                                        $subject = $mailSetting3->getMailSubject($data);
                                        //
                                        if ($content && $subject) {
                                            Yii::app()->mailer->send("", $mailtoshop, $subject, $content);
                                            //$mailer->send($from, $email, $subject, $message);
                                        }
                                    }
                                    $mailSetting4 = MailSettings::model()->mailScope()->findByAttributes(array(
                                        'mail_key' => 'mail_to_customer',
                                    ));
                                    if ($mailSetting4) {
                                        //Hiện ra danh sách sản phẩm được chọn.
                                        $order_prd = $this->renderPartial('_product_mail_settings', array(
                                            'products' => $products,
                                            'order' => $order,
                                            'shoppingCart' => $shoppingCart,), true);
                                        $mailtocustomer = $order->billing_email;
                                        //
                                        $content = $order_prd;
                                        //
                                        $subject = $mailSetting4->getMailSubject($data);
                                        //
                                        if ($content && $subject) {
                                            Yii::app()->mailer->send("", $mailtocustomer, $subject, $content);
                                            //$mailer->send($from, $email, $subject, $message);
                                        }
                                    }

                                    // delete cart after all
                                    Yii::app()->customer->deleteShoppingCart();

                                    /**
                                     * @hungtm
                                     * check site config sms order
                                     * if site has config, execute send sms to config phones
                                     */
                                    $sms_order_config = SmsOrderConfig::checkSmsOrderConfig();
                                    if ($sms_order_config) {
                                        $this->sendSms($order, $sms_order_config);
                                    }

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
                                     * nếu user chọn phương thức thanh toán onepay
                                     * thì sẽ request đến trang thanh toán của one pay
                                     */
                                    if ($order->payment_method == Orders::PAYMENT_METHOD_PAYPAL) {
                                        $this->requestPaypal($order);
                                    }

                                    /**
                                     * @hungtm
                                     * nếu user chọn phương thức thanh toán onepay quốc tế
                                     * thì sẽ request đến trang thanh toán của one pay quốc tế
                                     */
                                    if ($order->payment_method == Orders::PAYMENT_METHOD_ONEPAY_QUOCTE) {
                                        $this->requestOnepayQuocte($order);
                                    }

                                    /**
                                     * @hungtm
                                     * nếu user chọn phương thức thanh toán vtc pay
                                     * thì sẽ request đến trang thanh toán của vtc pay
                                     */
                                    if ($order->payment_method == Orders::PAYMENT_METHOD_VTCPAY) {
                                        $this->requestVtcpay($order);
                                    }

                                    if ($order->payment_method == Orders::PAYMENT_AMORTIZATION) {
                                        $this->requestAlepay($order);
                                    }

                                    if ($order->isPaymentNganluong()) {
                                        $this->requestNganluong($order);
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
//                                else {
//                                    echo "<pre>";
//                                    print_r($order->getErrors());
//                                    echo "</pre>";
//                                    die();
//                                }
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
                            'user_address' => $user_address,
                        );
                    }
                    break;
            }

            $arr = array('shoppingCart' => $shoppingCart) + $params;
            $this->render($view, $arr);
        } else {// Luồng cho set product
            $set = $_GET['sid'];
            if (!$shoppingCart->countOnlyProducts($set)) {
                $this->sendResponse(500);
            }
            //Không tích điểm
            /* if (!$shoppingCart->checkPointUsed() && ($shoppingCart->getTotalPrice(false))) {
              $shoppingCart->addPointUsed(0);
              } */
            $step = Yii::app()->request->getParam('step');
            if (!$step) {
                $step = 's1';
            }
            $view = 'checkout_set_s1';
            $params = array();

            switch ($step) {
                case 's1':
                    {
                        if (Yii::app()->user->isGuest) {
                            break;
                        }
                    }
                default:
                    {
                        $view = 'checkout_set_s2';
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
                                $configBonus = BonusConfig::checkBonusConfig();
                                if (!Yii::app()->user->isGuest) {
                                    if (isset($configBonus) && $configBonus->status == true) {
                                        $order->bonus_point_used = $shoppingCart->getPointUsed();
                                    } else {
                                        $order->bonus_point_used = 0;
                                    }
                                }
                                //Note Shoppingcart Set
                                $products_shoppingcart = $shoppingCart->findAllProductsInSet($set);

                                $total_price_normal = 0;
                                foreach ($products_shoppingcart as $product_item) {
                                    if ($product_item['type_product'] != ActiveRecord::TYPE_PRODUCT_VOUCHER) {
                                        $total_price_normal += $product_item['price'];
                                    }
                                }
                                // check hình thức thanh toán không phải tại cửa hàng
                                if ($order->payment_method != 1 && $total_price_normal > 0) {
                                    $order->transport_freight = Orders::getShipfee($order->shipping_city, $order->shipping_district);
                                }
//                            $total_price_discount = $shoppingCart->getTotalPriceDiscount();
                                $total_price_discount = 0;
                                $percent_vat = Yii::app()->siteinfo['percent_vat'];
                                $vat = 0;
                                if ($percent_vat > 0 && $total_price_normal > 0) {
                                    $vat = $total_price_discount - (((100 - $percent_vat) / 100) * $total_price_discount);
                                    $order->vat = $vat;
                                }
                                $discount_for_dealers = 0;
                                if (!Yii::app()->user->isGuest && $userinfo['type'] == 4) {
                                    //Giảm giá cho đại lý @hatv
                                    $percent_discount = Yii::app()->siteinfo['dealers_discount'];
                                    if ($percent_discount > 0 && $total_price_discount > 0) {
                                        $discount_for_dealers = $total_price_discount - (((100 - $percent_discount) / 100) * $total_price_discount);
                                        $order->discount_for_dealers = $discount_for_dealers;
                                    }
                                }

                                $order->old_order_total = $shoppingCart->getSetTotalPrice($set, false);
                                // check hình thức thanh toán không phải tại cửa hàng
                                if ($order->payment_method != 1) {
                                    $order->order_total = $order->old_order_total + $order->transport_freight + $vat - $discount_for_dealers;
                                } else {
                                    $order->order_total = $order->old_order_total + $vat - $discount_for_dealers;
                                }
                                //Tính điểm trên tổng hóa đơn
//                            $order_total_2_bonus = ($configBonus->plus_point > 0) ? round(($order->order_total / $configBonus->plus_point)) : 0;
                                // Điểm cộng chờ
//                            $order->wait_bonus_point = $shoppingCart->getTotalBonusPoint() + $order_total_2_bonus;
//                            $order->donate_total = $shoppingCart->getTotalDonate();
                                // Điểm cộng chờ
                                $order->wait_bonus_point = 0;
                                $order->donate_total = 0;
                                //Tính điểm cộng khi hoàn thành hóa đơn
                                if ($order->save()) {
                                    // Lưu log va trừ điểm bonus
//                                if (!Yii::app()->user->isGuest && $order->bonus_point_used != 0) {
//                                    $bonus_log_use = new BonusPointLog();
//                                    $bonus_log_use->user_id = Yii::app()->user->id;
//                                    $bonus_log_use->site_id = Yii::app()->controller->site_id;
//                                    $bonus_log_use->order_id = $order->order_id;
//                                    $bonus_log_use->point = $shoppingCart->getPointUsed();
//                                    $bonus_log_use->type = BonusPointLog::BONUS_TYPE_USE_POINT; //type điểm trừ
//                                    $bonus_log_use->created_time = time();
//                                    $bonus_log_use->note = BonusPointLog::BONUS_NOTE_USE_POINT_IN_ORDER;
//                                    if ($bonus_log_use->save()) {
//                                        $user = Users::model()->findByPk(Yii::app()->user->id);
//                                        $user->bonus_point = $user->bonus_point - $bonus_log_use->point;
//                                        $user->save();
//                                    }
//                                }
                                    Yii::app()->user->setFlash('success', Yii::t('shoppingcart', 'order_success_notice'));
                                    $products = $shoppingCart->findAllProductsInSet($set);
                                    foreach ($products as $key => $product) {
                                        $orderProduct = new OrderProducts();
                                        $orderProduct->product_id = $product['id'];
                                        $orderProduct->is_configurable = $product['is_configurable'];
                                        $orderProduct->id_product_link = $key;
                                        $orderProduct->order_id = $order->order_id;
                                        $orderProduct->product_qty = $shoppingCart->getQuantity($key, $set);
                                        $orderProduct->product_price = $product['price'];
                                        $atts = $shoppingCart->getAttributesByKey($key);
                                        if ($atts) {
                                            $orderProduct->product_attributes = json_encode($atts);
                                        }
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
                                            'set' => $set,
                                            'shoppingCart' => $shoppingCart,), true);
                                        // Chi tiết trong thư
                                        $data = array(
                                            'link' => '<a href="' . Yii::app()->createAbsoluteUrl('/economy/shoppingcart/order', array('id' => $order->order_id, 'key' => $order->key)) . '">Link</a>',
                                            'customer_name' => $billing->name,
                                            'customer_email' => $billing->email,
                                            'customer_address' => $billing->address,
                                            'customer_phone' => $billing->phone,
                                            'order_detail' => $order_prd,
                                            'coupon_code' => $order->coupon_code,
                                            'order_total' => $order->order_total,
                                            'fr' => (isset($_SESSION['fr']) && $_SESSION['fr']) ? $_SESSION['fr'] : ''
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
                                    Yii::app()->customer->getShoppingCart()->removeSet($set);
//                                Yii::app()->customer->deleteShoppingCart();
                                    /**
                                     * @hungtm
                                     * check site config sms order
                                     * if site has config, execute send sms to config phones
                                     */
                                    $sms_order_config = SmsOrderConfig::checkSmsOrderConfig();
                                    if ($sms_order_config) {
                                        $this->sendSms($order, $sms_order_config);
                                    }

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

                                    /**
                                     * @hungtm
                                     * nếu user chọn phương thức thanh toán vtc pay
                                     * thì sẽ request đến trang thanh toán của vtc pay
                                     */
                                    if ($order->payment_method == Orders::PAYMENT_METHOD_VTCPAY) {
                                        $this->requestVtcpay($order);
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

                        $params = array(
                            'billing' => $billing,
                            'shipping' => $shipping,
                            'order' => $order,
                        );
                    }
                    break;
            }

            $arr = array('shoppingCart' => $shoppingCart) + $params;
            $this->render($view, $arr);
        }
    }

    public function executeSendSms($config, $content, $phones)
    {
        ini_set("soap.wsdl_cache_enabled", "0");
        $client = new SoapClient("http://g3g4.vn:8008/smsws/services/SendMT?wsdl");
        //
        $arr_replate = array_map(function ($val) {
            return preg_replace("/[^0-9+]/", "", $val);
        }, $phones);
        $customers = array_map(function ($val) {
            $return = '';
            $len_val = strlen($val);
            if (($val != '') && ($len_val >= 10) && ($len_val <= 11)) {
                $return = array(
                    'phone' => $val,
                    'provider_key' => SmsProvider::getServiceProvider($val),
                );
            }
            return $return;
        }, $arr_replate);
        $customers = array_filter($customers);
        $ary_provider = array();
        foreach ($customers as $customer) {
            $ary_provider[$customer['provider_key']][] = $customer['phone'];
        }
        $count_message = Sms::countMessage($content);
        $ary_price = Sms::getCostProviderArr($ary_provider, $count_message);
        $total_price = array_sum($ary_price);

        $user_id = Yii::app()->user->id;
        $site_id = $this->site_id;
        $sms_money = SmsMoney::model()->findByAttributes(array('site_id' => $site_id));

        //
        $ary_log = array();
        $ary_log['user_money'] = $sms_money->money;
        //
        $detail_contact = '';
        if (count($ary_provider)) {
            foreach ($ary_provider as $key => $ary_customer) {
                if ($detail_contact != '') {
                    $detail_contact .= ', ';
                }
                $detail_contact .= $key . ': ' . count($ary_customer);
            }
        }
        $model_sms = new Sms();
        $model_sms->text_message = $content;
        $model_sms->type = 3; // gửi từ đơn hàng
        $model_sms->number_person = count($phones);
        $model_sms->group_customer_id = 0;
        $model_sms->ary_price = json_encode($ary_price);
        $model_sms->list_number = json_encode($ary_provider);
        $model_sms->count_message = $count_message;
        $model_sms->ary_provider = $detail_contact;
        if ($sms_money->money < $total_price) {
            $model_sms->status = 0; // không đủ tiền để gửi tin nhắn
        }
        if ($model_sms->save()) {
            if ($model_sms->status == 0) {
                return;
            }
            if (count($customers)) {
                // Trừ tiền của user
                $sms_money->money -= $total_price;
                $sms_money->money_used += $total_price;
                $sms_money->save();
                // Các biến dùng để tính toán việc cộng lại tiền cho user
                $return_money = 0;
                $return_customers = array();
                $return_ary_provider = array();

                $ary_log['after_user_money'] = $sms_money->money;
                foreach ($customers as $key_c => $customer) {
                    $sms_detail = new SmsDetail();
                    $sms_detail->phone = $customer['phone'];
                    $sms_detail->sms_id = $model_sms->id;
                    if ($sms_detail->save()) {
                        $input = array(
                            'username' => 'banhat',
                            'password' => '',
                            'receiver' => $customer['phone'],
                            'content' => $content,
                            'loaisp' => $config->loaisp, // Gửi từ số bất kì
                            'brandname' => '',
                            'target' => $sms_detail->id, // ID tin nhắn 
                        );
                        $response_status = $client->sendSMS($input);
                        $status_message = $response_status->return;
                        $status = explode('|', $status_message);
                        $sms_detail->status = $status[0];
                        $sms_detail->message = $status[1];
                        $sms_detail->modified_time = time();
                        $sms_detail->save();
                        if ($status[0] != 0) {
                            $return_customers[] = $customer;
                        }
                    }
                    unset($customers[$key_c]);
                }
                $return_customers = array_filter($return_customers);
                if (count($return_customers)) {
                    foreach ($return_customers as $return_customer) {
                        $return_ary_provider[$return_customer['provider_key']][] = $return_customer['phone'];
                    }
                    $ary_log['return_ary_provider'] = $return_ary_provider;
                    $return_ary_price = Sms::getCostProviderArr($return_ary_provider, $count_message);
                    $return_total_price = array_sum($return_ary_price);
                    $ary_log['return_total_price'] = $return_ary_price;
                    $sms_money->money += $return_total_price;
                    $sms_money->money_used -= $return_total_price;
                    $sms_money->save();
                }
                $log_json = json_encode($ary_log);
                $this->sms_logs($log_json, array('sms_id' => $model_sms->id));
            }
        }
    }

    function sms_logs($message, $params = array())
    {
        $sms_id = '';
        if (isset($params['sms_id'])) {
            $sms_id = $params['sms_id'];
        }
        $sql = 'INSERT INTO sms_logs(username, ipaddress, logtime, controller, action, details, sms_id, site_id) VALUES (\'' . Yii::app()->user->name . '\',\'' . $_SERVER['REMOTE_ADDR'] . '\',\'' . date("Y-m-d H:i:s") . '\',\'' . $this->getId() . '\',\'' . $this->getAction()->getId() . '\',\'' . $message . '\', \'' . $sms_id . '\', \'' . Yii::app()->controller->site_id . '\')';
        $command = Yii::app()->db->createCommand($sql);
        $command->execute();
    }

    function unicode_str_filter($str)
    {
        $unicode = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd' => 'đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D' => 'Đ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );
        foreach ($unicode as $nonUnicode => $uni) {
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }
        return $str;
    }

    /**
     * @hungtm
     * description: execute send sms when customer order product
     * @param type $order
     * @param type $config
     */
    public function sendSms($order, $config)
    {
        $search = array(
            '{user_name}',
            '{user_phone}',
            '{user_email}',
            '{order_total}'
        );
        $replace = array(
            $order->billing_name,
            $order->billing_phone,
            $order->billing_email,
            $order->order_total
        );
        // send to admin
        if ($config->send_admin && $config->phone_admin && $config->content) {
            $content = str_replace($search, $replace, $config->content);
            $content = $this->unicode_str_filter($content);
            // message check alphabe and special characters
            $content = preg_replace('/[^\_\\\^\"\?\=\~\`\!\$\+\&\|\[\]\{\}\;\<\>\#@A-Za-z0-9\.\': \*%\/\(\)-]/', '', $content);
            $phones = explode(',', $config->phone_admin);
            $this->executeSendSms($config, $content, $phones);
        }
        // send to customer
        if ($config->send_customer && $order->billing_phone && $config->content_customer) {
            $content = str_replace($search, $replace, $config->content_customer);
            $content = $this->unicode_str_filter($content);
            // message check alphabe and special characters
            $content = preg_replace('/[^\_\\\^\"\?\=\~\`\!\$\+\&\|\[\]\{\}\;\<\>\#@A-Za-z0-9\.\': \*%\/\(\)-]/', '', $content);
            $phones = array($order->billing_phone);
            $this->executeSendSms($config, $content, $phones);
        }
    }

    /**
     * @hungtm
     * function send sms to customer and admin website via sms
     * @param type $order
     * @param type $config_apisms
     * only website Gia viên
     */
    public function sendOrderSms($order, $config_apisms)
    {
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
    public function sendVoucher($order, $config_apivoucher)
    {
        $products_voucher = OrderProducts::getProductVoucherInOrder($order->order_id);
        if (isset($products_voucher) && count($products_voucher)) {
            $ws_client = new nusoap_client($config_apivoucher->url, 'wsdl');
            $i = 0;
            $payment_type = 2;
            if ($order->payment_method == Orders::PAYMENT_METHOD_ONEPAY || $order->payment_method == Orders::PAYMENT_METHOD_ONEPAY_QUOCTE) {
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
                    'price' => (int)$p_voucher['product_price'],
                    'price_order' => (int)$p_voucher['price_market'],
                    'quantity' => (int)$p_voucher['product_qty'],
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

    public function actionCallbackAlepaySuccess()
    {
        $id = Yii::app()->request->getParam('id');
        $key = Yii::app()->request->getParam('key');
        if ($id && $key) {
            $order = Orders::model()->findByPk($id);
            if (!$order) {
                $this->sendResponse(404);
            }
            if ($order->key != $key) {
                $this->sendResponse(404);
            }
            $products = OrderProducts::getProductsDetailInOrder($id);
            //
            $paymentmethod = Orders::getPaymentMethodInfo($order->payment_method);
            $transportmethod = Orders::getTransportMethodInfo($order->transport_method);

            $data = Yii::app()->request->getParam('data');
            $checksum = Yii::app()->request->getParam('checksum');
            $returnUrl = Yii::app()->createAbsoluteUrl('/economy/shoppingcart/callbackAlepaySuccess', array(
                'id' => $order->order_id,
                'key' => $order->key,
            ));
            $config = SitePayment::model()->getConfigPayment(SitePayment::TYPE_ALEPAY);
            $alepay = new common\components\alepay\Lib\Alepay([
                'apiKey' => $config['api_key'],
                'encryptKey' => $config['encrypt_key'],
                'checksumKey' => $config['checksum'],
                'callbackUrl' => $returnUrl,
                'env' => 'live'
            ]);
            if (isset($data) && isset($checksum)) {

                $utils = new \common\components\alepay\Lib\Utils\AlepayUtils();
                $result = $utils->decryptCallbackData($data, $config['encrypt_key']);
                $order->transaction_data = $result;
                $order->save();
//                $obj_data = json_decode($result);
            }
            $obj_data = json_decode($order['transaction_data']);
            $info = json_decode($alepay->getTransactionInfo($obj_data->data));
            //
            $this->render('show_alepay_success', array(
                'order' => $order->attributes,
                'products' => $products,
                'paymentmethod' => $paymentmethod,
                'transportmethod' => $transportmethod,
                'obj_data' => $obj_data,
                'alepay' => $alepay,
                'info' => $info
            ));
        }
    }

    public function requestAlepay($order)
    {
        //
        $returnUrl = Yii::app()->createAbsoluteUrl('/economy/shoppingcart/callbackAlepaySuccess', array(
            'id' => $order->order_id,
            'key' => $order->key,
        ));
        $cancelUrl = Yii::app()->createAbsoluteUrl('/economy/shoppingcart/order', array(
            'id' => $order->order_id,
            'key' => $order->key,
        ));
        $config = SitePayment::model()->getConfigPayment(SitePayment::TYPE_ALEPAY);
        $alepay = new \common\components\alepay\Lib\Alepay([
            'apiKey' => $config['api_key'],
            'encryptKey' => $config['encrypt_key'],
            'checksumKey' => $config['checksum'],
            'callbackUrl' => $returnUrl,
            'env' => 'live'
        ]);
        //
        $province = LibProvinces::model()->findByPk($order->billing_city);
        $products = OrderProducts::getProductsDetailInOrder($order->order_id);
        //
        $data = [
            'orderCode' => $order->order_id,
            'amount' => $order->order_total,
            'currency' => 'VND',
            'orderDescription' => $order->order_id,
            'totalItem' => count($products),
            'checkoutType' => 2, // Chỉ thanh toán trả góp
            'returnUrl' => $returnUrl,
            'cancelUrl' => $cancelUrl,
            'buyerName' => $order->billing_name,
            'buyerEmail' => $order->billing_email,
            'buyerPhone' => $order->billing_phone,
            'buyerAddress' => $order->billing_address,
            'buyerCity' => (isset($province->name) && $province->name) ? $province->name : '',
            'buyerCountry' => 'Việt Nam',
            'paymentHours' => 48,
        ];
        //
        $result = $alepay->sendOrderToAlepay($data); // Khởi tạo
        if (isset($result) && !empty($result->checkoutUrl)) {
            $url_checkout = (string)$result->checkoutUrl;
            $this->redirect($url_checkout);
            //$alepay->return_json('OK', 'Thành công', $result->checkoutUrl);
//            echo '<meta http-equiv="refresh" content="0;url=' . $result->checkoutUrl . '">';
        } else {
            echo $result->errorDescription;
        }
    }

    public function callAPI($url, $data = false)
    {
        $url .= 'checkout/v1/request-order';
        $curl = curl_init();
        //
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        //
        curl_setopt($curl, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //
        $result = curl_exec($curl);
        //
        curl_close($curl);
        //
        return $result;
    }

    /**
     * $hungtm
     * thanh toán ngân lượng
     * @param type $order
     */
    public function requestNganluong($order)
    {
        $config = SitePayment::model()->getConfigPayment(SitePayment::TYPE_NGANLUONG);
        $nlcheckout = new NganluongHelper($config['merchan_id'], $config['secure_pass'], $config['email_bussiness'], $config['url_request']);
        $total_amount = $order->order_total;
        $array_items = array();
        //
        $payment_method = $order->payment_method;
        $bank_code = isset($order->payment_method_child) ? $order->payment_method_child : '';
        $order_code = $order->order_id; // mã booking
        //
        $payment_type = '';
        $discount_amount = 0;
        $order_description = '';
        $tax_amount = 0;
        $fee_shipping = 0;
        $return_url = urlencode(Yii::app()->createAbsoluteUrl('/economy/shoppingcart/callbackNganluongSuccess', array(
            'id' => $order->order_id,
            'key' => $order->key,
        )));
        // $cancel_url = urlencode('http://localhost/nganluong.vn/checkoutv3?orderid=' . $order_code);
        $cancel_url = urlencode(Yii::app()->createAbsoluteUrl('/economy/shoppingcart/order', array(
            'id' => $order->order_id,
            'key' => $order->key,
        )));
        //
        $buyer_fullname = $order->billing_name; // Tên người đặt phòng
        $buyer_email = $order->billing_email; // Email người đặt phòng
        $buyer_mobile = $order->billing_phone; // Điện thoại người đặt phòng
        $buyer_address = $order->billing_address; // Địa chỉ người đặt phòng
        //
        if ($payment_method != '' && $buyer_email != "" && $buyer_mobile != "" && $buyer_fullname != "" && filter_var($buyer_email, FILTER_VALIDATE_EMAIL)) {
            if ($payment_method == Orders::PAYMENT_METHOD_VISA) {
                $nl_result = $nlcheckout->VisaCheckout($order_code, $total_amount, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items, $bank_code);
            } elseif ($payment_method == Orders::PAYMENT_METHOD_NL) {
                $nl_result = $nlcheckout->NLCheckout($order_code, $total_amount, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items);
            } elseif ($payment_method == Orders::PAYMENT_METHOD_ATM_ONLINE && $bank_code != '') {
                $nl_result = $nlcheckout->BankCheckout($order_code, $total_amount, $bank_code, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items);
            } elseif ($payment_method == Orders::PAYMENT_METHOD_NH_OFFLINE) {
                $nl_result = $nlcheckout->officeBankCheckout($order_code, $total_amount, $bank_code, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items);
            } elseif ($payment_method == Orders::PAYMENT_METHOD_ATM_OFFLINE) {
                $nl_result = $nlcheckout->BankOfflineCheckout($order_code, $total_amount, $bank_code, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items);
            } elseif ($payment_method == Orders::PAYMENT_METHOD_IB_ONLINE) {
                $nl_result = $nlcheckout->IBCheckout($order_code, $total_amount, $bank_code, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items);
            }
        }
        if ($nl_result->error_code == '00') {
            $url_checkout = (string)$nl_result->checkout_url;
            $this->redirect($url_checkout);
        } else {
            echo $nl_result->error_message;
        }
    }

    /**
     * @hungtm
     * call back onepay nội địa quốc tế
     */
    public function actionCallbackNganluongSuccess()
    {
        $id = Yii::app()->request->getParam('id');
        $key = Yii::app()->request->getParam('key');
        $token = Yii::app()->request->getParam('token');
        $config = SitePayment::model()->getConfigPayment(SitePayment::TYPE_NGANLUONG);
        $nlcheckout = new NganluongHelper($config['merchan_id'], $config['secure_pass'], $config['email_bussiness'], $config['url_request']);
        $nl_result = $nlcheckout->GetTransactionDetail($token);
        $order = Orders::model()->findByPk($id);
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
                        $order->payment_status = Orders::ORDER_PAYMENT_STATUS_PAID;
                        $order->save();
                    }
                }
            } else {
                echo $nlcheckout->GetErrorMessage($nl_errorcode);
                die();
            }
        }
        $this->redirect(Yii::app()->createUrl('/economy/shoppingcart/order', array(
            'id' => $order->order_id,
            'key' => $order->key,
        )));
    }

    /**
     * $hungtm
     * thanh toán vtc pay
     * @param type $order
     */
    public function requestVtcpay($order)
    {
        $config = SitePayment::getPaymentType(SitePayment::TYPE_VTCPAY);
        $destinationUrl = $config->url_request;
        //new version
        $param_ext = '';
        $currency = 1; // VNĐ if 2 is USD
        $url_return = Yii::app()->createAbsoluteUrl('/economy/shoppingcart/order', array(
            'id' => $order->order_id,
            'key' => $order->key,
        ));
        $plaintext = $config->merchan_id . "-" . $currency . "-" . $order->order_id . "-" . $order->order_total . "-" . $config->receive_account . "-" . $param_ext . "-" . $config->secure_pass . "-" . $url_return;
        $sign = strtoupper(hash('sha256', $plaintext));
        $data = "?website_id=" . $config->merchan_id . "&payment_method=" . $currency . "&order_code=" . $order->order_id . "&amount=" . $order->order_total . "&receiver_acc=" . $config->receive_account . "&urlreturn=" . $url_return;
        $customer_first_name = $order->billing_name;
        $customer_last_name = '';
        $bill_to_address_line1 = $order->billing_address;
        $bill_to_address_line2 = '';
        $city_name = '';
        $address_country = '';
        $customer_email = $order->billing_email;
        $order_des = $order->note;
        $customer_mobile = $order->billing_phone;
        $data = $data . "&customer_first_name=" . $customer_first_name . "&customer_last_name=" . $customer_last_name . "&customer_mobile=" . $customer_mobile . "&bill_to_address_line1=" . $bill_to_address_line1 . "&bill_to_address_line2=" . $bill_to_address_line2 . "&city_name=" . $city_name . "&address_country=" . $address_country . "&customer_email=" . $customer_email . "&order_des=" . $order_des . "&param_extend=" . $param_ext . "&sign=" . $sign;

        $destinationUrl = $destinationUrl . $data;
        $this->redirect($destinationUrl);
    }

    /**
     * @hungtm
     * thanh toán onepay quốc tế
     * @param type $order
     */
    public function requestOnepayQuocte($order)
    {
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
    public function actionCallbackOnepayQuocte()
    {
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

    public function requestPaypal($order)
    {
        $products = OrderProducts::getProductsDetailInOrder($order->order_id);
        $currency = 'USD';
        $i = 0;
        $items = [];
        $sub_total = 0;
        foreach ($products as $product) {
            $items[$i] = new \PayPal\Api\Item();
            $price = number_format($product['price'], 2);
            $items[$i]->setName($product['name'])
                ->setCurrency($currency)
                ->setQuantity($product['product_qty'])
                ->setPrice($price);
            $sub_total += $price * $product['product_qty'];
            $i++;
        }
        $shipping = 0;

        $total = $sub_total + $shipping;

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
            ->setDescription('Pay For Order: ' . $order->order_id)
            ->setInvoiceNumber($order->order_id);

        $redirectUrls = new \PayPal\Api\RedirectUrls();
        $returnUrl = Yii::app()->createAbsoluteUrl('economy/shoppingcart/paypalCallback', [
            'success' => 'true',
            'orderId' => $order->order_id
        ]);
        $cancelUrl = Yii::app()->createAbsoluteUrl('economy/shoppingcart/paypalCallback', [
            'success' => 'false',
            'orderId' => $order->order_id
        ]);
        $redirectUrls->setReturnUrl($returnUrl)
            ->setCancelUrl($cancelUrl);

        $payment = new PayPal\Api\Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);

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

        $order = Orders::model()->findByPk($orderId);
        if (!$order) {
            $this->sendResponse(404);
        }
        $url = Yii::app()->createUrl('/economy/shoppingcart/order', array(
            'id' => $order->order_id,
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
            $order->payment_status = Orders::ORDER_PAYMENT_STATUS_PAID;
            $order->save();
        } catch (Exception $e) {
            $data = json_decode($e->getData());
            echo "<pre>";
            print_r($data);
            echo "</pre>";
            die();
        }

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
    public function requestOnepay($order)
    {
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
    public function actionCallbackOnepay()
    {
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

    public static function null2unknown($data)
    {
        if ($data == "") {
            return "No Value Returned";
        } else {
            return $data;
        }
    }

    public function actionAddconfigurable()
    {
        $product_id = (int)Yii::app()->request->getParam('pid');
        $configurable_id = (int)Yii::app()->request->getParam('cid');
        $returnUrl = Yii::app()->request->getParam('returnUrl');
        if (isset($returnUrl) && $returnUrl) {
            $returnUrl = ClaGenerate::decrypt($returnUrl);
        }
        $quantity = (int)Yii::app()->request->getParam('qty', 1);
        $key = $product_id . '_' . $configurable_id;
        if ($product_id) {
            $product = Product::model()->findByPk($product_id);
            $product_configurable = ProductConfigurableValue::model()->findByPk($configurable_id);
            if ($product && $product->site_id == $this->site_id) {
                $shoppingCart = Yii::app()->customer->getShoppingCart();
                $shoppingCart->add($key, array('product_id' => $key, 'price' => $product_configurable->price, 'is_configurable' => 1, 'qty' => intval($quantity)));
            }
        }
        if (Yii::app()->request->isAjaxRequest) {
            $this->jsonResponse('200', array(
                'message' => 'success',
                'total' => Yii::app()->customer->getShoppingCart()->countProducts(),
                'total_price' => Yii::app()->customer->getShoppingCart()->getTotalPrice(),
                'products' => Yii::app()->customer->getShoppingCart()->countOnlyProducts(),
                'redirect' => (isset($returnUrl) && $returnUrl) ? $returnUrl : Yii::app()->createUrl('/economy/shoppingcart'),
                'cartTitle' => Yii::t('shoppingcart', 'shoppingcart') . ' (' . Yii::app()->customer->getShoppingCart()->countOnlyProducts() . ')',
                'cart' => $this->renderPartial('cart_ajax', array(
                    'shoppingCart' => $shoppingCart,
                    'total_price' => Yii::app()->customer->getShoppingCart()->getTotalPrice(),
                ), true),
            ), true);
        } else {
            $this->redirect((isset($returnUrl) && $returnUrl) ? $returnUrl : Yii::app()->createUrl('/economy/shoppingcart'));
        }
    }

    public function actionAddWholesale()
    {
        $product_id = (int)Yii::app()->request->getParam('pid');
        $quantity = (int)Yii::app()->request->getParam('qty');
        $attributeConfigurableValues = Yii::app()->request->getParam(ClaShoppingCart::PRODUCT_ATTRIBUTE_CONFIGURABLE_KEY);
        if (!$quantity || $quantity < 0) {
            $quantity = 1;
        }
        //
        if ($product_id) {
            $product = Product::model()->findByPk($product_id);
            if ($product && $product['price'] > 0) {
                $saveAttributes = array();
                $key = $product_id;
                $shoppingCart = Yii::app()->customer->getShoppingCart();
                if ($attributeConfigurableValues && count($attributeConfigurableValues)) {
                    foreach ($attributeConfigurableValues as $configurable_value_id => $info) {
                        // số lượng sản phẩm
                        $config_quantity = isset($info[ClaShoppingCart::PRODUCT_QUANTITY_KEY]) ? $info[ClaShoppingCart::PRODUCT_QUANTITY_KEY] : '';
                        if (!$config_quantity) {
                            continue;
                        }

                        //
                        $configurable_value_Info = ProductConfigurableValue::model()->findByPk($configurable_value_id);
                        if (!$configurable_value_Info) {
                            continue;
                        }

                        if ($configurable_value_Info['product_id'] != $product_id) {
                            continue;
                        }
                        $product_configurable = ProductConfigurable::model()->findByPk($product_id);
                        if (!$product_configurable) {
                            continue;
                        }
                        $saveAttributes = array();
                        for ($i = 1; $i <= ClaProduct::ATTRIBUTE_CONFIGURABLE_MAX_FIELD; $i++) {
                            $attribute_id_key = 'attribute' . $i . '_id';
                            if (!isset($product_configurable[$attribute_id_key])) {
                                continue;
                            }
                            $attribute_id = $product_configurable[$attribute_id_key];
                            $attr = ProductAttribute::model()->findByPk($attribute_id);
                            if (!$attr) {
                                continue;
                            }
                            $configurable_value = isset($configurable_value_Info['attribute' . $i . '_value']) ? $configurable_value_Info['attribute' . $i . '_value'] : 0;
                            $attrOption = AttributeHelper::helper()->getSingleAttributeOption($attribute_id, $configurable_value);
                            if (!$attrOption) {
                                continue;
                            }
                            //
                            $saveAttributes['attributes'][$attribute_id]['name'] = $attr['name'];
                            $saveAttributes['attributes'][$attribute_id]['value'] = $attrOption['value'];
                            $saveAttributes['attributes'][$attribute_id]['type_option'] = $attr['type_option'];
                            $saveAttributes['attributes'][$attribute_id]['ext'] = $attrOption['ext'];
                            $saveAttributes['attributes'][$attribute_id]['field_configurable'] = 'attribute' . $attr['field_configurable'] . '_value';
                            $saveAttributes['attributes'][$attribute_id]['field_configurable_value'] = $configurable_value;
                            $saveAttributes['attributes'][$attribute_id]['configurable_value_id'] = $configurable_value_id;
                        }
                        $key = $product_id . '_' . $configurable_value_id;
                        $shoppingCart->add($key, array('product_id' => $product_id, 'qty' => intval($config_quantity), 'price' => $product->price, ClaShoppingCart::MORE_INFO => $saveAttributes));
                    }
                } else {
                    $shoppingCart->add($key, array('product_id' => $product_id, 'qty' => intval($quantity), 'price' => $product->price, ClaShoppingCart::MORE_INFO => $saveAttributes));
                }
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

    public function actionAddWholesizesale()
    {
        $product_id = (int)Yii::app()->request->getParam('pid');
        $update = (int)Yii::app()->request->getParam('update');
        $quantity = (int)Yii::app()->request->getParam('qty');
        $attributeConfigurableValues = Yii::app()->request->getParam(ClaShoppingCart::PRODUCT_ATTRIBUTE_CONFIGURABLE_KEY);
        if (!$quantity || $quantity < 0) {
            $quantity = 1;
        }
        //
        if ($product_id) {
            $product = Product::model()->findByPk($product_id);
            if ($product) {
                $saveAttributes = array();
                $key = $product_id;
                $shoppingCart = Yii::app()->customer->getShoppingCart();
                if ($attributeConfigurableValues && count($attributeConfigurableValues)) {
                    foreach ($attributeConfigurableValues as $key1 => $value) {
                        if ($value && count($value)) {
                            foreach ($value as $configurable_value_id => $info) {
                                // số lượng sản phẩm

                                $config_quantity = isset($info[ClaShoppingCart::PRODUCT_QUANTITY_KEY]) ? $info[ClaShoppingCart::PRODUCT_QUANTITY_KEY] : '';
                                if (!$config_quantity) {
                                    continue;
                                }
                                //
                                $configurable_value_Info = ProductConfigurableValue::model()->findByPk($key1);
                                $configurable_value_Info1 = ProductConfigurableValue::model()->findByPk($configurable_value_id);
                                if (!$configurable_value_Info) {
                                    continue;
                                }
                                if ($configurable_value_Info['product_id'] != $product_id) {
                                    continue;
                                }
                                $product_configurable = ProductConfigurable::model()->findByPk($product_id);
                                if (!$product_configurable) {
                                    continue;
                                }

                                $saveAttributes = array();
                                for ($i = 1; $i <= ClaProduct::ATTRIBUTE_CONFIGURABLE_MAX_FIELD; $i++) {
                                    $attribute_id_key = 'attribute' . $i . '_id';
                                    if (!isset($product_configurable[$attribute_id_key])) {
                                        continue;
                                    }
                                    $attribute_id = $product_configurable[$attribute_id_key];
                                    $attr = ProductAttribute::model()->findByPk($attribute_id);

                                    if (!$attr) {
                                        continue;
                                    }
                                    if ($i != 1) {
                                        $configurable_value = isset($configurable_value_Info['attribute' . $i . '_value']) ? $configurable_value_Info['attribute' . $i . '_value'] : 0;
                                    } else {
                                        $configurable_value = isset($configurable_value_Info1['attribute' . $i . '_value']) ? $configurable_value_Info1['attribute' . $i . '_value'] : 0;
                                    }
                                    $attrOption = AttributeHelper::helper()->getSingleAttributeOption($attribute_id, $configurable_value);
                                    if (!$attrOption) {
                                        continue;
                                    }
                                    //
                                    $saveAttributes['attributes'][$attribute_id]['name'] = $attr['name'];
                                    $saveAttributes['attributes'][$attribute_id]['value'] = $attrOption['value'];
                                    $saveAttributes['attributes'][$attribute_id]['type_option'] = $attr['type_option'];
                                    $saveAttributes['attributes'][$attribute_id]['ext'] = $attrOption['ext'];
                                    $saveAttributes['attributes'][$attribute_id]['field_configurable'] = 'attribute' . $attr['field_configurable'] . '_value';
                                    $saveAttributes['attributes'][$attribute_id]['field_configurable_value'] = $configurable_value;
                                    $saveAttributes['attributes'][$attribute_id]['configurable_value_id'] = $configurable_value_id;
                                }
                                $key = $product_id . '_' . $configurable_value_id . '_' . $key1;
                                $shoppingCart->add($key, array('product_id' => $product_id, 'qty' => intval($config_quantity), 'price' => $product->price, 'update' => $update, ClaShoppingCart::MORE_INFO => $saveAttributes));
                            }
                        }
                    }
                } else {
                    $shoppingCart->add($key, array('product_id' => $product_id, 'qty' => intval($quantity), 'price' => $product->price, 'update' => $update, ClaShoppingCart::MORE_INFO => $saveAttributes));
                }
                if (Yii::app()->request->isAjaxRequest) {
                    $this->jsonResponse('200', array(
                        'message' => 'success',
                        'total' => Yii::app()->customer->getShoppingCart()->countProducts(),
                        'products' => Yii::app()->customer->getShoppingCart()->countOnlyProducts(),
                        'cartTitle' => Yii::t('shoppingcart', 'shoppingcart') . ' (' . Yii::app()->customer->getShoppingCart()->countOnlyProducts() . ')',
                        'cart' => $this->renderPartial('cart_ajax', array(
                            'shoppingCart' => $shoppingCart,
                        ), true),
                    ));
                }
            }
        }
    }

    public function actionValidate()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new Billing();
            $model->unsetAttributes();
            if (isset($_POST['Billing'])) {
                $model->attributes = $_POST['Billing'];
            }
            if ($model->validate()) {
                $validator = new CEmailValidator();
                if (!$validator->validateValue($model->email)) {
                    $model->addError('email', Yii::t('errors', 'email_invalid', array('{name}' => '"' . $model->email . '"')));
                }
                $errors = $model->getErrors();
                if (isset($errors) && count($errors)) {
                    $this->jsonResponse(400, array(
                        'errors' => $model->getJsonErrors(),
                    ));
                } else {
                    $this->jsonResponse(200);
                }
            } else {
                $this->jsonResponse(400, array(
                    'errors' => $model->getJsonErrors(),
                ));
            }
        }
    }


    /**
     * Thêm sp vào giỏ hàng
     */
    public function actionAdd()
    {
        $product_id = (int)Yii::app()->request->getParam('pid');
        $quantity = (int)Yii::app()->request->getParam('qty');
        $set = !is_null(Yii::app()->request->getParam('set')) ? (int)Yii::app()->request->getParam('set') : null;
        $make_set = (int)Yii::app()->request->getParam('make_set');
        $returnUrl = Yii::app()->request->getParam('returnUrl');
        if (isset($returnUrl) && $returnUrl) {
            $returnUrl = ClaGenerate::decrypt($returnUrl);
        }

        $attributes = Yii::app()->request->getParam(ClaShoppingCart::PRODUCT_ATTRIBUTE_CONFIGURABLE_KEY);
        $attributesCP = Yii::app()->request->getParam(ClaShoppingCart::PRODUCT_ATTRIBUTE_CHANGEPRICE_KEY);
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
                        $saveAttributes['type_attributes'] = ((int)$attr['is_configurable']) ? ProductAttribute::TYPE_ATTRIBUTE_CONFIGURABLE : '';
                        $saveAttributes['attributes'][$attribute_id]['name'] = $attr['name'];
                        $saveAttributes['attributes'][$attribute_id]['value'] = $attrOption['value'];
                        $saveAttributes['attributes'][$attribute_id]['type_option'] = $attr['type_option'];
                        $saveAttributes['attributes'][$attribute_id]['ext'] = $attrOption['ext'];
                        $saveAttributes['attributes'][$attribute_id]['field_configurable'] = 'attribute' . $attr['field_configurable'] . '_value';
                        $saveAttributes['attributes'][$attribute_id]['field_configurable_value'] = $configurable_value;
                        $key .= $configurable_value;
                    }
                }

                // attribute change price
                if ($attributesCP && count($attributesCP)) {
                    foreach ($attributesCP as $attribute_id => $att_value) {
                        $attr = ProductAttribute::model()->findByPk($attribute_id);
                        if ($attr->site_id != $this->site_id)
                            continue;
                        $attrOption = AttributeHelper::helper()->getSingleAttributeOption($attribute_id, $att_value);
                        if (!$attrOption)
                            continue;
                        $saveAttributes['type_attributes'] = ((int)$attr['is_change_price']) ? ProductAttribute::TYPE_ATTRIBUTE_CHANGEPRICE : '';
                        $saveAttributes['attributes'][$attribute_id]['name'] = $attr['name'];
                        $saveAttributes['attributes'][$attribute_id]['value'] = $attrOption['value'];
                        $saveAttributes['attributes'][$attribute_id]['type_option'] = $attr['type_option'];
                        $saveAttributes['attributes'][$attribute_id]['ext'] = $attrOption['ext'];
                        $saveAttributes['attributes'][$attribute_id]['change_price'] = ProductAttributeOptionPrice::model()->getPrice($product_id, $attrOption['id']);
                        $key .= $att_value;
                    }
                }
                // Use set - Hatv
                if (Yii::app()->siteinfo['use_shoppingcart_set']) {
                    if (Yii::app()->request->isAjaxRequest) {
                        $shoppingCart = Yii::app()->customer->getShoppingCart();
                        if ($shoppingCart->countSetProduct() == 0 || $make_set) {
                            $num_set = (count(Yii::app()->customer->getShoppingCart()->getProducts()));
                            if ($num_set >= ClaShoppingCart::LIMIT_SET) { // Vì mảng bắt đầu từ 0
                                $this->jsonResponse('400', array(
                                    'msg' => 'Xin lỗi bạn đã tạo quá số lượng set',
                                ));
                            }
                            $shoppingCart->add($key, array('product_id' => $product_id,
                                'qty' => intval($quantity),
                                'price' => $product->price,
                                'make_set' => true,
                                ClaShoppingCart::MORE_INFO => $saveAttributes));
                            $set = end(array_keys(Yii::app()->customer->getShoppingCart()->getProducts()));
                        } else if (!is_null($set)) {

                            $shoppingCart->add($key, array('product_id' => $product_id,
                                'qty' => intval($quantity),
                                'price' => $product->price,
                                'set' => $set,
                                ClaShoppingCart::MORE_INFO => $saveAttributes));
                        }
                        if (isset($make_set)) {

                        }
                        $this->jsonResponse('200', array(
                            'cart' => $this->renderPartial('set_cart_ajax', array(
                                'shoppingCart' => $shoppingCart,
                                'set' => $set,
                            ), true),
                        ));
                    }
                } else {
                    //Don't Use Set - Defalut
                    $shoppingCart = Yii::app()->customer->getShoppingCart();
                    $shoppingCart->add($key, array('product_id' => $product_id,
                        'qty' => intval($quantity),
                        'price' => $product->price,
                        ClaShoppingCart::MORE_INFO => $saveAttributes));
                    if (Yii::app()->request->isAjaxRequest) {
                        $this->jsonResponse('200', array(
                            'message' => 'success',
                            'total' => Yii::app()->customer->getShoppingCart()->countProducts(),
                            'total_price' => HtmlFormat::money_format(Yii::app()->customer->getShoppingCart()->getTotalPrice(false)),
                            'products' => Yii::app()->customer->getShoppingCart()->countOnlyProducts(),
                            'redirect' => (isset($returnUrl) && $returnUrl) ? $returnUrl : Yii::app()->createUrl('/economy/shoppingcart'),
                            'cartTitle' => Yii::t('shoppingcart', 'shoppingcart')
                                . ' (' . Yii::app()->customer->getShoppingCart()->countOnlyProducts() . ')',
                            'cart' => $this->renderPartial('cart_ajax', array(
                                'shoppingCart' => $shoppingCart,
                                'total_price' => Yii::app()->customer->getShoppingCart()->getTotalPrice(),
                            ), true),
                        ));
                    } else {
                        $this->redirect((isset($returnUrl) && $returnUrl) ? $returnUrl : Yii::app()->createUrl('/economy/shoppingcart'));
                    }
                }
            }
        }
    }

    /**
     * Hatv
     * Thêm thay đổi số lượng sản phẩm trong giỏ hàng
     */
    public function actionChangeQty()
    {
        $product_id = (int)Yii::app()->request->getParam('pid');
        $quantity = (int)Yii::app()->request->getParam('qty');
        $attributes = Yii::app()->request->getParam(ClaShoppingCart::PRODUCT_ATTRIBUTE_CONFIGURABLE_KEY);
        $attributesCP = Yii::app()->request->getParam(ClaShoppingCart::PRODUCT_ATTRIBUTE_CHANGEPRICE_KEY);

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
                        $saveAttributes['type_attributes'] = ((int)$attr['is_configurable']) ? ProductAttribute::TYPE_ATTRIBUTE_CONFIGURABLE : '';
                        $saveAttributes['attributes'][$attribute_id]['name'] = $attr['name'];
                        $saveAttributes['attributes'][$attribute_id]['value'] = $attrOption['value'];
                        $saveAttributes['attributes'][$attribute_id]['type_option'] = $attr['type_option'];
                        $saveAttributes['attributes'][$attribute_id]['ext'] = $attrOption['ext'];
                        $saveAttributes['attributes'][$attribute_id]['field_configurable'] = 'attribute' . $attr['field_configurable'] . '_value';
                        $saveAttributes['attributes'][$attribute_id]['field_configurable_value'] = $configurable_value;
                        $key .= $configurable_value;
                    }
//
                }

                // sttribute change price
                if ($attributesCP && count($attributesCP)) {
                    foreach ($attributesCP as $attribute_id => $att_value) {
                        $attr = ProductAttribute::model()->findByPk($attribute_id);
                        if ($attr->site_id != $this->site_id)
                            continue;
                        $attrOption = AttributeHelper::helper()->getSingleAttributeOption($attribute_id, $att_value);
                        if (!$attrOption)
                            continue;
                        $saveAttributes['type_attributes'] = ((int)$attr['is_change_price']) ? ProductAttribute::TYPE_ATTRIBUTE_CHANGEPRICE : '';
                        $saveAttributes['attributes'][$attribute_id]['name'] = $attr['name'];
                        $saveAttributes['attributes'][$attribute_id]['type_attribute'] = ((int)$attr['is_change_price']) ? ProductAttribute::TYPE_ATTRIBUTE_CHANGEPRICE : '';
                        $saveAttributes['attributes'][$attribute_id]['value'] = $attrOption['value'];
                        $saveAttributes['attributes'][$attribute_id]['type_option'] = $attr['type_option'];
                        $saveAttributes['attributes'][$attribute_id]['ext'] = $attrOption['ext'];
                        $saveAttributes['attributes'][$attribute_id]['change_price'] = ProductAttributeOptionPrice::model()->getPrice($product_id, $attrOption['id']);
                        $key .= $att_value;
                    }
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
    public function actionUpdate()
    {
        $key = Yii::app()->request->getParam('key');
        $quantity = (int)Yii::app()->request->getParam('qty');
        if ($quantity <= 0) {
            $quantity = 1;
        }
        if (!Yii::app()->siteinfo['use_shoppingcart_set']) {
            if ($key && $quantity) {
                $shoppingCart = Yii::app()->customer->getShoppingCart();
                $cartInfo = $shoppingCart->getInfoByKey($key);
                if ($cartInfo && isset($cartInfo['product_id'])) {
                    $product = Product::model()->findByPk($cartInfo['product_id']);
                    if ($product && $product->site_id == $this->site_id) {
                        $shoppingCart->update($key, array('qty' => $quantity, 'price' => $product->price, 'product_id' => $product['id']));
                        //
                        if (Yii::app()->request->isAjaxRequest) {
                            $this->jsonResponse('200', array(
                                'message' => 'success',
                                'total' => Yii::app()->customer->getShoppingCart()->countProducts(),
                            ));
                        } else {
                            if (Yii::app()->controller->site_id == 2230) {
                                // Edallybh.vn
                                $this->redirect(Yii::app()->createUrl('/economy/shoppingcart/checkout', array('step' => 's2', 'user' => 'guest')));
                            } else {
                                $this->redirect(Yii::app()->createUrl('/economy/shoppingcart'));
                            }
                        }
                    }
                }
            }
        } else {
            $set = Yii::app()->request->getParam('set');
            if ($key && $quantity && isset($set)) {
                $shoppingCart = Yii::app()->customer->getShoppingCart();
                $cartInfo = $shoppingCart->getInfoByKey($key, $set);
                if ($cartInfo && isset($cartInfo['product_id'])) {
                    $product = Product::model()->findByPk($cartInfo['product_id']);
                    if ($product && $product->site_id == $this->site_id) {
                        $shoppingCart->update($key, array('qty' => $quantity, 'price' => $product->price, 'product_id' => $product['id'], 'set' => $set));
                        //
                        if (Yii::app()->request->isAjaxRequest) {
                            $this->jsonResponse('200', array(
                                'message' => 'success',
                                'total' => Yii::app()->customer->getShoppingCart()->countProducts(),
                            ));
                        } else
                            $this->redirect(Yii::app()->createUrl('/economy/shoppingcart', array('sid' => $set)));
                    }
                }
            }
        }
        $this->sendResponse(400);
    }

    /**
     * xóa product khỏi shopping cart
     */
    public function actionDelete()
    {
        $key = Yii::app()->request->getParam('key');
        $removeall = Yii::app()->request->getParam('removeall');
        $removesetkey = Yii::app()->request->getParam('removesetkey');
//        $key = (is_numeric($key)) ? $key : (int) $key;
        if ($removesetkey == 1 && $key) {
            $shoppingCart = Yii::app()->customer->getShoppingCart();

            $shoppingCart->removeProductAttribute($key);
            if (Yii::app()->request->isAjaxRequest) {
                $this->jsonResponse('200', array(
                    'message' => 'success',
                    'total' => Yii::app()->customer->getShoppingCart()->countProducts(),
                ));
            } else
                $this->redirect(Yii::app()->createUrl('/economy/shoppingcart'));
        }
        if ($removeall == 1) {
            $shoppingCart = Yii::app()->customer->getShoppingCart();

            $shoppingCart->removeAll();
            if (Yii::app()->request->isAjaxRequest) {
                $this->jsonResponse('200', array(
                    'message' => 'success',
                    'total' => Yii::app()->customer->getShoppingCart()->countProducts(),
                ));
            } else
                $this->redirect(Yii::app()->createUrl('/economy/shoppingcart'));
        }
        if ($key) {
            if (!Yii::app()->siteinfo['use_shoppingcart_set']) {
                $shoppingCart = Yii::app()->customer->getShoppingCart();
                $cartInfo = $shoppingCart->getInfoByKey($key);
                if ($cartInfo && isset($cartInfo['product_id'])) {
                    $product = Product::model()->findByPk($cartInfo['product_id']);
                    if ($product && $product->site_id == $this->site_id) {
                        $shoppingCart->remove($key);
                        if (Yii::app()->request->isAjaxRequest) {
                            $this->jsonResponse('200', array(
                                'message' => 'success',
                                'total' => Yii::app()->customer->getShoppingCart()->countProducts(),
                            ));
                        } else
                            $this->redirect(Yii::app()->createUrl('/economy/shoppingcart'));
                    }
                }
            } else {
                $set = Yii::app()->request->getParam('set');
                $shoppingCart = Yii::app()->customer->getShoppingCart();
                $cartInfo = $shoppingCart->getInfoByKey($key, $set);
                if ($cartInfo && isset($cartInfo['product_id'])) {
                    $product = Product::model()->findByPk($cartInfo['product_id']);
                    if ($product && $product->site_id == $this->site_id) {
                        $shoppingCart->remove($key, $set);
                        if (Yii::app()->request->isAjaxRequest) {
                            $this->jsonResponse('200', array(
                                'message' => 'success',
                                'total' => Yii::app()->customer->getShoppingCart()->countProducts(),
                            ));
                        } else
                            $this->redirect(Yii::app()->createUrl('/economy/shoppingcart', array('sid' => $set)));
                    }
                }
            }
        }
        $this->sendResponse(400);
    }

    /**
     * xóa set shopping cart
     */
    public function actionDeleteSet()
    {
        $set = Yii::app()->request->getParam('set');
        if (!is_null($set)) {
            $shoppingCart = Yii::app()->customer->getShoppingCart();
            $shoppingCart->removeSet($set);
            if (Yii::app()->request->isAjaxRequest) {
                $this->jsonResponse('200', array(
                    'message' => 'success',
                    'set' => $set,
                    'total' => Yii::app()->customer->getShoppingCart()->countProducts(),
                ));
            } else
                $this->redirect(Yii::app()->createUrl('/economy/shoppingcart'));
        }
        $this->sendResponse(400);
    }

    /**
     * xóa mã coupon khỏi shopping cart
     */
    public function actionDeleteCouponCode()
    {
//        $key = Yii::app()->request->getParam('key');
//        $key = (is_numeric($key)) ? $key : (int) $key;
        $shoppingCart = Yii::app()->customer->getShoppingCart();
        $shoppingCart->removeCouponCode();
        if (Yii::app()->request->isAjaxRequest) {
            $this->jsonResponse('200', array(
                'message' => 'success',
            ));
        } else {
            $this->redirect(Yii::app()->createUrl('/economy/shoppingcart'));
        }
    }

    /**
     * xóa mã bonus point shopping cart
     */
    public function actionDeletePoint()
    {
//        $key = Yii::app()->request->getParam('key');
//        $key = (is_numeric($key)) ? $key : (int) $key;
        $shoppingCart = Yii::app()->customer->getShoppingCart();
        $shoppingCart->deletePointUsed();
        if (Yii::app()->request->isAjaxRequest) {
            $this->jsonResponse('200', array(
                'message' => 'success',
            ));
        } else {
            $this->redirect(Yii::app()->createUrl('/economy/shoppingcart'));
        }
    }

    public function actionOrderShop()
    {
        $id = Yii::app()->request->getParam('id');
        $key = Yii::app()->request->getParam('key');
        if ($id && $key) {
            $orders = Orders::getOrdersByIds($id);
            if (!$orders) {
                $this->sendResponse(404);
            }
            $order_key = implode(',', array_column($orders, 'key'));
            if ($key != $order_key) {
                $this->sendResponse(404);
            }
            foreach ($orders as $i => $order) {
                $orders[$i]['products'] = OrderProducts::getProductsDetailInOrder($order['order_id']);
                $orders[$i]['paymentmethod'] = Orders::getPaymentMethodInfo($order['payment_method']);
                $orders[$i]['transportmethod'] = Orders::getTransportMethodInfo($order['transport_method']);
            }
//
            $this->render('order_shop', array(
                'orders' => $orders
            ));
//
        }
    }

    public function actionOrder()
    {
        $id = Yii::app()->request->getParam('id');
        $key = Yii::app()->request->getParam('key');
        if ($id && $key) {
            $order = Orders::model()->findByPk($id);
            if (!$order) {
                $this->sendResponse(404);
            }
            if ($order->key != $key) {
                $this->sendResponse(404);
            }
            $products = OrderProducts::getProductsDetailInOrder($id);
//
            $paymentmethod = Orders::getPaymentMethodInfo($order->payment_method);
            $transportmethod = Orders::getTransportMethodInfo($order->transport_method);
//
            if ($order->payment_method == Orders::PAYMENT_METHOD_VTCPAY) {
                $model_log = LogVtcpay::model()->findByPk($id);
                if ($model_log === NULL) {
                    $config = SitePayment::getPaymentType(SitePayment::TYPE_VTCPAY);
                    $status = Yii::app()->request->getParam('status');
                    $website_id = Yii::app()->request->getParam('website_id');
                    $order_code = Yii::app()->request->getParam('order_code');
                    $amount = Yii::app()->request->getParam('amount');
                    $sign = Yii::app()->request->getParam('sign');
                    $string_hash = $status . '-' . $website_id . '-' . $order_code . '-' . $amount . '-' . $config->secure_pass;
                    $temp_sign = hash('sha256', $string_hash);
                    // write log
                    $log = new LogVtcpay();
                    $log->order_id = $id;
                    $log->status = $status;
                    $log->website_id = $website_id;
                    $log->order_code = $order_code;
                    $log->amount = $amount;
                    $log->sign = $sign;
                    if (strtoupper($temp_sign) == $sign) {
                        $log->correct = 1;
                    } else {
                        $log->correct = 0;
                    }
                    $log->save();
                    // update status payment order
                    $transStatus = '';
                    if ($status == 1 || $status == 2) {
                        $transStatus = 'Giao dịch thành công';
                        $order->payment_status = Orders::ORDER_PAYMENT_STATUS_PAID;
                        $order->save();
                    } else if ($status == 7 || $status == 0) {
                        $transStatus = 'Giao dịch đang chờ xử lý';
                        $order->payment_status = Orders::ORDER_PAYMENT_STATUS_PROCESSING;
                        $order->save();
                    } else {
                        $transStatus = 'Giao dịch thất bại';
                    }
                }
            }

            $this->render('order', array(
                'order' => $order->attributes,
                'products' => $products,
                'paymentmethod' => $paymentmethod,
                'transportmethod' => $transportmethod,
            ));
//
        }
    }

    public function actionGuide()
    {
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
    public function actionUpdateAjax()
    {
        $product_id = (int)Yii::app()->request->getParam('pid');
        $quantity = (int)Yii::app()->request->getParam('qty');
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
    public function actionAddMulti()
    {
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

    public function actionOtp()
    {
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

    /**
     * @Hatv check giảm giá
     */
    public function actionGetdiscount()
    {
        $code = Yii::app()->request->getParam('code');
        $site_id = Yii::app()->controller->site_id;
        if (isset($code) && $code != '') {
            $check = false;
            $error_message = '';
            $shoppingCart = Yii::app()->customer->getShoppingCart();
            //
            if ($shoppingCart->getCouponCode() == $code) {
                $this->jsonResponse(404, array('msg' => 'Bạn đang sử dụng mã này rồi'));
            }
            //
            $coupon_code = CouponCode::model()->findByAttributes(array('code' => $code, 'site_id' => $site_id));
            if ($coupon_code === NULL) {
                $this->jsonResponse(404, array('msg' => 'Không tồn tại mã giảm giá này'));
            }
            if ($coupon_code->site_id != Yii::app()->controller->site_id) {
                $this->jsonResponse(404, array('msg' => 'Không tồn tại mã giảm giá này'));
            }
            $couponCampaign = CouponCampaign::model()->findByPk($coupon_code->campaign_id);
            // Kiểm tra chiến dịch
            if ($couponCampaign === NULL) {
                $this->jsonResponse(404, array('msg' => 'Mã code không chính xác hoặc mã code đã hết thời hạn sử dụng, xin hãy nhập code khác!'));
            }
            // Kiểm tra thời gian chiến dịch
            if ($couponCampaign->expired_date <= time() || $couponCampaign->released_date >= time()) {
                $this->jsonResponse(404, array('msg' => 'Mã code không chính xác hoặc mã code đã hết thời hạn sử dụng, xin hãy nhập code khác!'));
            }
            // Kiêm tra xem có giới hạn số lần sử dụng hay không
            if (!$couponCampaign->no_limit) {
                if ($coupon_code->used >= $couponCampaign->usage_limit) {
                    $this->jsonResponse(404, array('msg' => 'Mã code đã hết số lần sử dụng!'));
                }
            }
            // Kiểm tra xem chiến dịch áp dụng cho loại nào
            if ($couponCampaign->applies_to_resource == CouponCampaign::APPLY_ALL) {
                // Áp dụng khuyến mại cho tất cả
                $check = true;
            } else if ($couponCampaign->applies_to_resource == CouponCampaign::APPLY_MINIMUM) {
                // Áp dụng cho đơn hàng từ bao nhiêu
                if ($shoppingCart->getTotalPrice(false) >= $couponCampaign->minimum_order_amount) {
                    $check = true;
                } else {
                    $error_message = 'Giá trị đơn hàng tối thiểu để được khuyến mại là ' . number_format($couponCampaign->minimum_order_amount, 0, '.', ',');
                }
            } else if ($couponCampaign->applies_to_resource == CouponCampaign::APPLY_CATEGORY) {
                // Áp dụng cho danh mục sản phẩm
                $products = $shoppingCart->findAllProducts();
                $category_ids = array_column($products, 'product_category_id');
                if (!in_array($couponCampaign->category_id, $category_ids)) {
                    $error_message = 'Đơn hàng bạn mua không có sản phẩm nào thuộc danh mục được khuyến mãi';
                } else {
                    $check = true;
                }
            } else if ($couponCampaign->applies_to_resource == CouponCampaign::APPLY_PRODUCT) {
                // Áp dụng cho sản phẩm
                $products = $shoppingCart->findAllProducts();
                $product_ids = array_column($products, 'id');
                if (!in_array($couponCampaign->product_id, $product_ids)) {
                    $error_message = 'Đơn hàng bạn mua không có sản phẩm nào được khuyến mãi';
                } else {
                    $check = true;
                }
            }
            if ($check == true) {
                $shoppingCart->addCouponCode($code);
                $discount = $shoppingCart->getDiscountCoupon(true);
                $discountNotFormat = $shoppingCart->getDiscountCoupon(false);
                $totalRemain = $shoppingCart->getTotalPriceDiscount(true);
                $this->jsonResponse(200, array_merge($couponCampaign->attributes, ['totalDiscount' => $discount, 'discountNotFormat' => $discountNotFormat, 'totalRemain' => $totalRemain]));
            }
            $this->jsonResponse(404, array('msg' => $error_message));
        }
        $this->jsonResponse(404);
    }

    public function actionGetshipfee()
    {
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

    public function actionGetdistrictAndshipfee()
    {
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

    public function getShipfeeWithWeight()
    {
        $shoppingCart = Yii::app()->customer->getShoppingCart();
        $products = $shoppingCart->findAllProducts();
        $weight = (float)0;
        $shipfee = (float)0;
        foreach ($products as $product) {
            $weight += $product['weight'];
        }
        $data_config = SiteConfigShipfeeWeight::getAllConfigShipfeeWeight();
        if (isset($data_config) && count($data_config)) {
            foreach ($data_config as $config) {
                if ($weight == 0) {
                    if ((int)$config['from'] == 0) {
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

    public function actionGetdiscountCoupon()
    {
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
    public function actionGetdiscountPoint()
    {
        $point_used = Yii::app()->request->getParam('point_used');

        if (isset($point_used)) {
            //check point
            $configBonus = BonusConfig::checkBonusConfig();
            $user_point = ClaUser::getUserInfo(Yii::app()->user->id)['bonus_point'];
            $shoppingCart = Yii::app()->customer->getShoppingCart();
            $toal_price = $shoppingCart->getTotalPrice(false);
            $min_point = $configBonus->min_point;
            $max_point = $configBonus->max_point;
            $min_order_price = $configBonus->minimum_order_amount;
            if ($configBonus && $point_used != 0) {
                if ($configBonus->status == false) {
                    $this->jsonResponse(404, array('error' => 'Tính năng tích điểm bị khóa'));
                } else if ($point_used > $user_point) {
                    $this->jsonResponse(404, array('error' => 'Bạn dùng quá số điểm khả dụng'));
                } else if ($point_used < $min_point && $min_point != 0) {
                    $this->jsonResponse(404, array('error' => 'Số điểm tối thiểu có thể sử dụng là ' . $min_point));
                } else if ($point_used > $user_point && $max_point != 0) {
                    $this->jsonResponse(404, array('error' => 'Bạn chỉ có thể sử dụng tối đa ' . $max_point . ' điểm cho một đơn hàng'));
                } else if ($toal_price < $min_order_price && $min_order_price != 0) {
                    $this->jsonResponse(404, array('error' => 'Đơn hàng tối thiểu để sử dụng mã là ' . number_format($min_order_price)));
                }
            }
            $shoppingCart = Yii::app()->customer->getShoppingCart();
            $shoppingCart->addPointUsed($point_used);
            $this->jsonResponse(200, array('point_bonus' => $point_used));
        }
        $this->jsonResponse(404);
    }

    /**
     * xóa coupon code
     */
    public function actionRemoveCouponCode()
    {
        $key = Yii::app()->request->getParam('key');
//        $key = (is_numeric($key)) ? $key : (int) $key;
        if ($key) {
            $shoppingCart = Yii::app()->customer->getShoppingCart();
            $cartInfo = $shoppingCart->getInfoByKey($key);
            if ($cartInfo && isset($cartInfo['product_id'])) {
                $product = Product::model()->findByPk($cartInfo['product_id']);
                if ($product && $product->site_id == $this->site_id) {
                    $shoppingCart->remove($key);
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
        $this->sendResponse(400);
    }

    /**
     * Thêm sp vào giỏ hàng
     */
    public function actionQuickAdd()
    {
        $product_id = (int)Yii::app()->request->getParam('pid');
        $quantity = (int)Yii::app()->request->getParam('qty');
        $attributes = Yii::app()->request->getParam(ClaShoppingCart::PRODUCT_ATTRIBUTE_CONFIGURABLE_KEY);
        $attributesCP = Yii::app()->request->getParam(ClaShoppingCart::PRODUCT_ATTRIBUTE_CHANGEPRICE_KEY);

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
                        $saveAttributes['type_attributes'] = ((int)$attr['is_configurable']) ? ProductAttribute::TYPE_ATTRIBUTE_CONFIGURABLE : '';
                        $saveAttributes['attributes'][$attribute_id]['name'] = $attr['name'];
                        $saveAttributes['attributes'][$attribute_id]['value'] = $attrOption['value'];
                        $saveAttributes['attributes'][$attribute_id]['type_option'] = $attr['type_option'];
                        $saveAttributes['attributes'][$attribute_id]['ext'] = $attrOption['ext'];
                        $saveAttributes['attributes'][$attribute_id]['field_configurable'] = 'attribute' . $attr['field_configurable'] . '_value';
                        $saveAttributes['attributes'][$attribute_id]['field_configurable_value'] = $configurable_value;
                        $key .= $configurable_value;
                    }
                }

                // attribute change price
                if ($attributesCP && count($attributesCP)) {
                    foreach ($attributesCP as $attribute_id => $att_value) {
                        $attr = ProductAttribute::model()->findByPk($attribute_id);
                        if ($attr->site_id != $this->site_id)
                            continue;
                        $attrOption = AttributeHelper::helper()->getSingleAttributeOption($attribute_id, $att_value);
                        if (!$attrOption)
                            continue;
                        $saveAttributes['type_attributes'] = ((int)$attr['is_change_price']) ? ProductAttribute::TYPE_ATTRIBUTE_CHANGEPRICE : '';
                        $saveAttributes['attributes'][$attribute_id]['name'] = $attr['name'];
                        $saveAttributes['attributes'][$attribute_id]['value'] = $attrOption['value'];
                        $saveAttributes['attributes'][$attribute_id]['type_option'] = $attr['type_option'];
                        $saveAttributes['attributes'][$attribute_id]['ext'] = $attrOption['ext'];
                        $saveAttributes['attributes'][$attribute_id]['change_price'] = ProductAttributeOptionPrice::model()->getPrice($product_id, $attrOption['id']);
                        $key .= $att_value;
                    }
                }
//
                $shoppingCart = Yii::app()->customer->getShoppingCart();
                $shoppingCart->update($key);
                $shoppingCart->add($key, array('product_id' => $product_id, 'qty' => intval($quantity), 'price' => $product->price, ClaShoppingCart::MORE_INFO => $saveAttributes));

                //
//                $shoppingCart = Yii::app()->customer->getShoppingCart();
                if (!$shoppingCart->countOnlyProducts()) {
                    $this->sendResponse(500);
                }
                if (!$shoppingCart->checkPointUsed() && ($shoppingCart->getTotalPrice(false))) {
                    $shoppingCart->addPointUsed(0);
                }
                $step = Yii::app()->request->getParam('step');
                if (!$step) {
                    $step = 's2';
                }
                $view = 'checkout_s1';
                $params = array();

                switch ($step) {
                    case 's1':
                        {
                            if (Yii::app()->user->isGuest) {
                                break;
                            }
                        }
                    default:
                        {
                            $view = 'checkout_s2';
                            $billing = new Billing();
                            $billing->billtoship = 1;
//                        if (!Yii::app()->user->isGuest) {
//                            $userinfo = ClaUser::getUserInfo(Yii::app()->user->id);
//                            if ($userinfo) {
//                                $billing->name = $userinfo['name'];
//                                if ($userinfo['address'])
//                                    $billing->address = $userinfo['address'];
//                                if ($userinfo['email'])
//                                    $billing->email = $userinfo['email'];
//                                if ($userinfo['phone'])
//                                    $billing->phone = $userinfo['phone'];
//                                if ($userinfo['province_id'])
//                                    $billing->city = $userinfo['province_id'];
//                            }
//                        }
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
                                    $configBonus = BonusConfig::checkBonusConfig();
                                    if (!Yii::app()->user->isGuest) {
                                        if (isset($configBonus) && $configBonus->status == true) {
                                            $order->bonus_point_used = $shoppingCart->getPointUsed();
                                        } else {
                                            $order->bonus_point_used = 0;
                                        }
                                    }
                                    $products_shoppingcart = $shoppingCart->findAllProducts();
                                    $total_price_normal = 0;
                                    foreach ($products_shoppingcart as $product_item) {
                                        if ($product_item['type_product'] != ActiveRecord::TYPE_PRODUCT_VOUCHER) {
                                            $total_price_normal += $product_item['price'];
                                        }
                                    }

                                    // check hình thức thanh toán không phải tại cửa hàng
//                                if ($order->payment_method != 1 && $total_price_normal > 0) {
//                                    $order->transport_freight = Orders::getShipfee($order->shipping_city, $order->shipping_district);
//                                }

                                    $total_price_discount = $shoppingCart->getTotalPriceDiscount();
                                    $percent_vat = Yii::app()->siteinfo['percent_vat'];
                                    $vat = 0;
                                    if ($percent_vat > 0 && $total_price_normal > 0) {
                                        $vat = $total_price_discount - (((100 - $percent_vat) / 100) * $total_price_discount);
                                        $order->vat = $vat;
                                    }
                                    $userinfo = ClaUser::getUserInfo(Yii::app()->user->id);
                                    $discount_for_dealers = 0;
                                    if (!Yii::app()->user->isGuest && $userinfo['type'] == 4) {
                                        //Giảm giá cho đại lý @hatv
                                        $percent_discount = Yii::app()->siteinfo['dealers_discount'];
                                        if ($percent_discount > 0 && $total_price_discount > 0) {
                                            $discount_for_dealers = $total_price_discount - (((100 - $percent_discount) / 100) * $total_price_discount);
                                            $order->discount_for_dealers = $discount_for_dealers;
                                        }
                                    }
                                    $order->old_order_total = $shoppingCart->getTotalPrice(false);
                                    // check hình thức thanh toán không phải tại cửa hàng
                                    if ($order->payment_method != 1) {
                                        $order->order_total = $total_price_discount + $order->transport_freight + $vat - $discount_for_dealers;
                                    } else {
                                        $order->order_total = $total_price_discount + $vat - $discount_for_dealers;
                                    }
                                    //Tính điểm trên tổng hóa đơn
                                    $bonusPointFromOrderToal = ($configBonus->plus_point > 0) ? round(($order->order_total / $configBonus->plus_point)) : 0;
                                    // Điểm cộng chờ
                                    $order->wait_bonus_point = $shoppingCart->getTotalBonusPoint() + $bonusPointFromOrderToal;
                                    $order->donate_total = $shoppingCart->getTotalDonate();
                                    //Tính điểm cộng khi hoàn thành hóa đơn
                                    if ($order->save()) {
                                        // Lưu log va trừ điểm bonus
                                        if (!Yii::app()->user->isGuest && $order->bonus_point_used != 0) {
                                            $bonus_log_use = new BonusPointLog();
                                            $bonus_log_use->user_id = Yii::app()->user->id;
                                            $bonus_log_use->site_id = Yii::app()->controller->site_id;
                                            $bonus_log_use->order_id = $order->order_id;
                                            $bonus_log_use->point = $shoppingCart->getPointUsed();
                                            $bonus_log_use->type = BonusPointLog::BONUS_TYPE_USE_POINT; //type điểm trừ
                                            $bonus_log_use->created_time = time();
                                            $bonus_log_use->note = BonusPointLog::BONUS_NOTE_USE_POINT_IN_ORDER;
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
                                            $orderProduct->is_configurable = $product['is_configurable'];
                                            $orderProduct->id_product_link = $key;
                                            $orderProduct->order_id = $order->order_id;
                                            $orderProduct->product_qty = $shoppingCart->getQuantity($key);
                                            $orderProduct->product_price = $product['price'];
                                            $atts = $shoppingCart->getAttributesByKey($key);
                                            if ($atts) {
                                                $orderProduct->product_attributes = json_encode($atts);
                                            }
                                            $orderProduct->save();
                                        }
                                        // delete cart
                                        Yii::app()->customer->deleteShoppingCart();
                                        //
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

                                        $this->redirect(Yii::app()->createUrl('/economy/shoppingcart/order', array(
                                            'id' => $order->order_id,
                                            'key' => $order->key,
                                        )));
                                    }
                                }
                            }
                            $params = array(
                                'billing' => $billing,
                                'shipping' => $shipping,
                                'order' => $order,
                            );
                        }
                        break;
                }

                $arr = array('shoppingCart' => $shoppingCart) + $params;
                $this->render($view, $arr);
            }
        }
    }

    /**
     * Dùng nguyên cho ống nhựa thành long
     */
    public function actionCheckoutNew()
    {
        //
        $this->layoutForAction = '//layouts/checkout';
        //
        $shoppingCart = Yii::app()->customer->getShoppingCart();
        // Luồng Defaut
        if (!Yii::app()->siteinfo['use_shoppingcart_set']) {
            if (!$shoppingCart->countOnlyProducts()) {
                $this->redirect(Yii::app()->homeUrl);
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
            $user_address = array();

            switch ($step) {
                case 's1':
                    {
                        if (Yii::app()->user->isGuest) {
                            break;
                        }
                    }
                default:
                    {
                        $view = 'checkout_s2';
                        $billing = new Billing();
                        $billing->billtoship = 1;
                        if (!Yii::app()->user->isGuest) {
                            $userinfo = ClaUser::getUserInfo(Yii::app()->user->id);
                            $user_address = Users::getUserAddress(Yii::app()->user->id);
                            $user_address['0'] = $userinfo;
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
                                if ($userinfo['district_id'])
                                    $billing->district = $userinfo['district_id'];
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
                                if (!$order->isPaymentNganluong()) {
                                    if (!isset($paymentMethod[$order->payment_method])) {
                                        $order->payment_method = null;
                                    }
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
                                $configBonus = BonusConfig::checkBonusConfig();
                                if (!Yii::app()->user->isGuest) {
                                    if (isset($configBonus) && $configBonus->status == true) {
                                        $order->bonus_point_used = $shoppingCart->getPointUsed();
                                    } else {
                                        $order->bonus_point_used = 0;
                                    }
                                }
                                //Note Shoppingcart Set
                                $products_shoppingcart = $shoppingCart->findAllProducts();
                                $total_price_normal = 0;
                                foreach ($products_shoppingcart as $product_item) {
                                    if ($product_item['type_product'] != ActiveRecord::TYPE_PRODUCT_VOUCHER) {
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

                                $discount_for_dealers = 0;
                                if (!Yii::app()->user->isGuest && $userinfo['type'] == 4) {
                                    //Giảm giá cho đại lý @authot: hatv
                                    $percent_discount = Yii::app()->siteinfo['dealers_discount'];
                                    if ($percent_discount > 0 && $total_price_discount > 0) {
                                        $discount_for_dealers = $total_price_discount - (((100 - $percent_discount) / 100) * $total_price_discount);
                                        $order->discount_for_dealers = $discount_for_dealers;
                                    }
                                }

                                $order->old_order_total = $shoppingCart->getTotalPrice(false);
                                $order->order_total = $total_price_discount + $vat - $discount_for_dealers;
                                // Check payment method to add $order->transport_freight
                                if ($order->payment_method != 1) {
                                    $order->order_total += $order->transport_freight;
                                }

                                /* Section bonus point */
                                // Calculate number bonus point after complete Order Request
                                $bonusPointFromOrderTotal = ($configBonus->plus_point > 0) ? round(($order->order_total / $configBonus->plus_point)) : 0;

                                // Add wait_bonus_point and donate_total to Order Model
                                $order->wait_bonus_point = $shoppingCart->getTotalBonusPoint() + $bonusPointFromOrderTotal;
                                $order->donate_total = $shoppingCart->getTotalDonate();
                                $order->currency = $shoppingCart->getProductCurrency();
                                if (Yii::app()->request->getPost('TypeOrder') != 1) {
                                    $order->order_status = Orders::ORDER_DESTROY;
                                }
                                if ($order->save()) {
                                    // Update coupon used-number
                                    if ($order->coupon_code) {
                                        $coupon_code = CouponCode::model()->findByAttributes(array(
                                            'code' => $order->coupon_code
                                        ));
                                        $coupon_code->used++;
                                        $coupon_code->save();
                                    }

                                    /**
                                     * Write log to db and use point.
                                     * */
                                    $bonusConfig = BonusConfig::checkBonusConfig();
                                    if (!Yii::app()->user->isGuest && $order->bonus_point_used != 0 && $bonusConfig) {
                                        $user = Users::model()->findByPk(Yii::app()->user->id);
                                        $options = ['note' => BonusPointLog::BONUS_NOTE_USE_POINT_IN_ORDER];
                                        $user->usePoint($shoppingCart->getPointUsed(), $options, $order->attributes);
                                    }
                                    /* -- End use point -- */

                                    Yii::app()->user->setFlash('success', Yii::t('shoppingcart', 'order_success_notice'));
                                    $products = $shoppingCart->findAllProducts();
                                    foreach ($products as $key => $product) {
                                        $orderProduct = new OrderProducts();
                                        $orderProduct->product_id = $product['id'];
                                        $orderProduct->is_configurable = $product['is_configurable'];
                                        $orderProduct->id_product_link = $key;
                                        $orderProduct->order_id = $order->order_id;
                                        $orderProduct->product_qty = $shoppingCart->getQuantity($key);
                                        $orderProduct->product_price = $product['price'];
                                        $atts = $shoppingCart->getAttributesByKey($key);
                                        if ($atts) {
                                            $orderProduct->product_attributes = json_encode($atts);
                                        }
                                        $orderProduct->save();
                                    }

                                    // Yêu cầu báo giá
                                    if (Yii::app()->request->getPost('TypeOrder') == 1) {
                                        // Send email for admin
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
                                                'order_total' => HtmlFormat::money_format($order->order_total),
                                                'old_order_total' => HtmlFormat::money_format($order->old_order_total),
                                                'transport_freight' => HtmlFormat::money_format($order->transport_freight),
                                                'discount' => '(' . $order->discount_for_dealers . '%)',
                                                'discount_percent' => $order->discount_percent,
                                                'type' => 'Đặt hàng',
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

                                        /*
                                         * send mail for customer
                                         * */
                                        $mailSetting1 = MailSettings::model()->mailScope()->findByAttributes(array(
                                            'mail_key' => 'customerordernotice_order',
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
                                                'order_total' => HtmlFormat::money_format($order->order_total),
                                                'old_order_total' => HtmlFormat::money_format($order->old_order_total),
                                                'transport_freight' => HtmlFormat::money_format($order->transport_freight),
                                                'discount' => '(' . $order->discount_for_dealers . '%)',
                                                'discount_percent' => $order->discount_percent,
                                            );
                                            //
                                            $content1 = $mailSetting1->getMailContent($data);
                                            //
                                            $subject1 = $mailSetting1->getMailSubject($data);
                                            //
                                            if ($content1 && $subject1) {
                                                $file = $this->exportMakeFile($order->id);
                                                $mailer = Yii::app()->mailer;
                                                $mailer->phpmailer->AddAttachment($file, 'baogia' . '.' . 'html');
                                                $mailer->send('', $order->billing_email, $subject1, $content1);
                                                Yii::app()->user->setFlash('success', 'Gửi yêu cầu thành công. Hệ thống đã gửi 1 mail về địa chỉ mail "' . $order->billing_email . '" cho bạn.');
                                            }
                                        }
                                    } else {
                                        // Send email for admin
                                        $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                                            'mail_key' => 'quotationnotice',
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
                                                'order_total' => HtmlFormat::money_format($order->order_total),
                                                'old_order_total' => HtmlFormat::money_format($order->old_order_total),
                                                'transport_freight' => HtmlFormat::money_format($order->transport_freight),
                                                'discount' => '(' . $order->discount_for_dealers . '%)',
                                                'discount_percent' => $order->discount_percent,
                                                'type' => 'Đặt hàng',
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

                                        /*
                                         * send mail for customer
                                         * */
                                        $mailSetting1 = MailSettings::model()->mailScope()->findByAttributes(array(
                                            'mail_key' => 'customerordernotice_request',
                                        ));
                                        if ($mailSetting1) {
                                            //Hiện ra danh sách sản phẩm được chọn.
                                            $order_prd = $this->renderPartial('_product_mail_settings', array(
                                                'products' => $products,
                                                'shoppingCart' => $shoppingCart,), true);
                                            // Chi tiết trong thư
                                            $detail_order = $data = array(
                                                'link' => '<a href="' . Yii::app()->createAbsoluteUrl('/economy/shoppingcart/orderBillPrint', array('id' => $order->order_id, 'key' => $order->key)) . '">Link</a>',
                                                'customer_name' => $billing->name,
                                                'customer_email' => $billing->email,
                                                'customer_address' => $billing->address,
                                                'customer_phone' => $billing->phone,
                                                'order_detail' => $order_prd,
                                                'coupon_code' => $order->coupon_code,
                                                'order_total' => HtmlFormat::money_format($order->order_total),
                                                'old_order_total' => HtmlFormat::money_format($order->old_order_total),
                                                'transport_freight' => HtmlFormat::money_format($order->transport_freight),
                                                'discount' => '(' . $order->discount_for_dealers . '%)',
                                                'discount_percent' => $order->discount_percent,
                                                'type' => 'Đặt hàng',
                                            );
                                            //
                                            $content1 = $mailSetting1->getMailContent($data);
                                            //
                                            $subject1 = $mailSetting1->getMailSubject($data);
                                            //
                                            if ($content1 && $subject1) {
                                                $file = $this->exportMakeFile($order->order_id);
                                                $mailer = Yii::app()->mailer;
                                                $mailer->phpmailer->AddAttachment($file, 'baogia' . '.' . 'html');
                                                $mailer->send('', $order->billing_email, $subject1, $content1);
                                                Yii::app()->user->setFlash('success', 'Gửi yêu cầu thành công. Hệ thống đã gửi 1 mail về địa chỉ mail "' . $order->billing_email . '" cho bạn.');
                                            }
                                        }
                                    }

                                    // delete cart after all
                                    Yii::app()->customer->deleteShoppingCart();

                                    /**
                                     * hungtm
                                     * kiểm tra xem đơn hàng có sản phẩm voucher hay không
                                     * nếu có sẽ call api bắn mã voucher cho khách hàng qua số điện thoại
                                     */
                                    $config_apivoucher = SiteApivoucher::checkConfigVoucher();
                                    if ($config_apivoucher) {
                                        $this->sendVoucher($order, $config_apivoucher);
                                    }

                                    //
                                    $this->redirect(Yii::app()->createUrl('/economy/shoppingcart/orderNew', array(
                                        'id' => $order->order_id,
                                        'key' => $order->key,
                                        'type' => Yii::app()->request->getPost('TypeOrder'),
                                    )));
                                }
                            }
                        }
                        $params = array(
                            'billing' => $billing,
                            'shipping' => $shipping,
                            'order' => $order,
                            'user_address' => $user_address,
                        );
                    }
                    break;
            }

            $arr = array('shoppingCart' => $shoppingCart) + $params;
            $this->render($view, $arr);
        }
    }

    public function actionOrderNew()
    {
        $id = Yii::app()->request->getParam('id');
        $key = Yii::app()->request->getParam('key');
        $type = Yii::app()->request->getParam('type');
        if ($id && $key) {
            $order = Orders::model()->findByPk($id);
            if (!$order) {
                $this->sendResponse(404);
            }
            if ($order->key != $key) {
                $this->sendResponse(404);
            }
            $products = OrderProducts::getProductsDetailInOrder($id);
//
            $paymentmethod = Orders::getPaymentMethodInfo($order->payment_method);
            $transportmethod = Orders::getTransportMethodInfo($order->transport_method);
//
            if ($order->payment_method == Orders::PAYMENT_METHOD_VTCPAY) {
                $model_log = LogVtcpay::model()->findByPk($id);
                if ($model_log === NULL) {
                    $config = SitePayment::getPaymentType(SitePayment::TYPE_VTCPAY);
                    $status = Yii::app()->request->getParam('status');
                    $website_id = Yii::app()->request->getParam('website_id');
                    $order_code = Yii::app()->request->getParam('order_code');
                    $amount = Yii::app()->request->getParam('amount');
                    $sign = Yii::app()->request->getParam('sign');
                    $string_hash = $status . '-' . $website_id . '-' . $order_code . '-' . $amount . '-' . $config->secure_pass;
                    $temp_sign = hash('sha256', $string_hash);
                    // write log
                    $log = new LogVtcpay();
                    $log->order_id = $id;
                    $log->status = $status;
                    $log->website_id = $website_id;
                    $log->order_code = $order_code;
                    $log->amount = $amount;
                    $log->sign = $sign;
                    if (strtoupper($temp_sign) == $sign) {
                        $log->correct = 1;
                    } else {
                        $log->correct = 0;
                    }
                    $log->save();
                    // update status payment order
                    $transStatus = '';
                    if ($status == 1 || $status == 2) {
                        $transStatus = 'Giao dịch thành công';
                        $order->payment_status = Orders::ORDER_PAYMENT_STATUS_PAID;
                        $order->save();
                    } else if ($status == 7 || $status == 0) {
                        $transStatus = 'Giao dịch đang chờ xử lý';
                        $order->payment_status = Orders::ORDER_PAYMENT_STATUS_PROCESSING;
                        $order->save();
                    } else {
                        $transStatus = 'Giao dịch thất bại';
                    }
                }
            }
            //
            $this->viewForAction = 'order';
            if ($type) {
                $this->viewForAction = 'order_type' . $type;
            }
            //
            $this->render($this->viewForAction, array(
                'order' => $order->attributes,
                'products' => $products,
                'paymentmethod' => $paymentmethod,
                'transportmethod' => $transportmethod,
            ));
        }
    }

    public function actionOrderBillPrint()
    {
        $id = Yii::app()->request->getParam('id');
        $key = Yii::app()->request->getParam('key');
        $type = Yii::app()->request->getParam('type');
        $this->layoutForAction = '';
        $this->layout = '';
        if ($id && $key) {
            $site = Yii::app()->siteinfo;
            $this->layout = 'disable';
            $model = Orders::model()->findByPk($id);
            if ($model->site_id != $this->site_id)
                $this->sendResponse(404);

            $products = OrderProducts::getProductsDetailInOrder($id);

            $paymentmethod = Orders::getPaymentMethodInfo($model->payment_method);
            $transportmethod = Orders::getTransportMethodInfo($model->transport_method);

            $this->renderPartial('printbilladmin', array(
                'model' => $model,
                'products' => $products,
                'site' => $site,
            ));
        }
    }

    /**
     * Make file order detail
     * @param $id
     * @return string
     * @throws CHttpException
     * @author: Hatv
     */
    public function exportMakeFile($id)
    {
        $model = Orders::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

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

            //Create File
            $file = Yii::getPathOfAlias('common') . '/../' . 'assets' . '/' . time() . '_' . $model->order_id . '_bill.html';

            $hander = fopen($file, "w");
            @chmod($file, 0755);
            fwrite($hander, $content);
            fclose($hander);
            return $file;
            //
        }
    }

}
