<?php

use common\components\Transport;

/**
 * @dess Login Controller
 *
 * @author minhbachngoc
 * @since 10/21/2013 16:10
 */
class ShoppingController extends ApiController
{
    /**
     * Displays the login page and validate login value
     */
    public function actionGetAttribute()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $id = isset($post['id']) ? $post['id'] : false;
        if ($id) {
            $product_attr = V2ProAttributes::getModel(['id' => $id]);
            if ($product_attr) {
                $resonse['data'] = $product_attr->attributes;
                $resonse['code'] = 1;
                $resonse['message'] = 'Lấy thông tin thành công';
            }
        }
        return $this->responseData($resonse);
    }

    public function actionGetPaymentMethod()
    {
        $resonse = $this->getResponse();
        $arr = [
            Orders::PAYMENT_METHOD_AFTER => Yii::t('shoppingcart', 'payment_receive'),
            Orders::PAYMENT_METHOD_ATM_OFFLINE => Yii::t('shoppingcart', 'payment_atm'),
//            Orders::PAYMENT_METHOD_VNPAY => Yii::t('shoppingcart', 'payment_vnpay'),
//            Orders::PAYMENT_METHOD_ONLINE => Yii::t('shoppingcart', 'payment_online')
        ];
        $resonse['data'] = $arr;
        $resonse['code'] = 1;
        $resonse['message'] = 'Lấy thông tin thành công';
        return $this->responseData($resonse);
    }


    public function actionGetVariable()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $product_id = isset($post['id']) ? $post['id'] : false;
        if ($product_id) {
            $key = V2ProVariables::getKeyByAttrs(isset($post['key']) ? $post['key'] : []);
            $var = V2ProVariables::getModel(['key' => $key, 'product_id' => $product_id]);
            if ($var->id) {
                $data['id'] = $var->id;
                $data['image'] = ClaUrl::getImageUrl($var['avatar_path'], $var['avatar_name']);
                $data['price'] = $var->price;
                $data['price_text'] = $var['price'] > 0 ? number_format($var['price'], '0', ',', '.') . 'đ' : 'Liên hệ';
                $data['quantity'] = $var['quantity'];
                $data['status'] = $var['status'];
                $resonse['data'] = $data;
                $resonse['code'] = 1;
                $resonse['message'] = 'Lấy thông tin sản phẩm thành công';
            }
        }
        return $this->responseData($resonse);
    }


    public function actionAdd()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['id']) && $post['id']) {
            $product_id = $post['id'];
            $quantity = (isset($post['qty']) && $post['qty']) ? $post['qty'] : 0;
            $var_id = (isset($post['var_id']) && $post['var_id']) ? $post['var_id'] : 0;
        }
        if (!$quantity || $quantity < 0) {
            $quantity = 1;
        }
        if ($product_id) {
            if (!$var_id) {
                $product = Product::model()->findByAttributes(['id' => $product_id, 'site_id' => $this->site_id]);
                $shoppingCart = Yii::app()->customer->getShoppingCart();
                $shoppingCart->add($product_id, array(
                        'product_id' => $product_id,
                        'qty' => intval($quantity),
                        'price' => $product->price,
                    ) + $product->attributes);
                $resonse['code'] = 1;
                $resonse['message'] = 'Thêm sản phẩm vào giỏ hàng thành công';
                return $this->responseData($resonse);
            }
            $product = V2ProVariables::model()->findByAttributes(['id' => $var_id, 'product_id' => $product_id, 'site_id' => $this->site_id]);
            $product_base = Product::model()->findByAttributes(['id' => $product_id, 'site_id' => $this->site_id]);
            if ($product && $product_base) {
                $key = $var_id;
                $shoppingCart = Yii::app()->customer->getShoppingCart();
                $options = $product_base->attributes;
                $shoppingCart->add($key, array(
                        'product_id' => $product_id,
                        'qty' => intval($quantity),
                        'price' => $product->price,
                        'var_id' => $var_id,
                        'key' => $product->key,
                    ) + $options);
                $resonse['code'] = 1;
                $resonse['message'] = 'Thêm sản phẩm vào giỏ hàng thành công';
            }
        }
        return $this->responseData($resonse);
    }


    function AddProducts($products)
    {
        if (isset($products) && $products) {
            foreach ($products as $product) {
                $saveAttributes = array();
                if (isset($product['id']) && $product['id']) {
                    $product_id = $product['id'];
                    $quantity = (isset($product['qty']) && $product['qty']) ? $product['qty'] : 0;
                    $attributes = (isset($product[ClaShoppingCart::PRODUCT_ATTRIBUTE_CONFIGURABLE_KEY]) && $product[ClaShoppingCart::PRODUCT_ATTRIBUTE_CONFIGURABLE_KEY]) ? $product[ClaShoppingCart::PRODUCT_ATTRIBUTE_CONFIGURABLE_KEY] : 0;
                    $key = $product_id;
                    if ($attributes) {
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
                }
                if (!$quantity || $quantity < 0) {
                    $quantity = 1;
                }
                if ($product_id) {
                    $product = Product::model()->findByAttributes(['id' => $product_id, 'site_id' => $this->site_id]);
                    $shoppingCart = Yii::app()->customer->getShoppingCart();
                    $set = null;

                    $shoppingCart->add($key, array('product_id' => $product_id,
                        'qty' => intval($quantity),
                        'price' => $product->price,
                        'set' => $set,
                        ClaShoppingCart::MORE_INFO => $saveAttributes));


//                    $product_base = Product::model()->findByAttributes(['id' => $product_id, 'site_id' => $this->site_id]);
//                    if ($product && $product_base) {
//                        $key = $var_id;
//                        $shoppingCart = Yii::app()->customer->getShoppingCart();
//                        $options = $product_base->attributes;
//                        $shoppingCart->add($key, array(
//                                'product_id' => $product_id,
//                                'qty' => intval($quantity),
//                                'price' => $product->price,
//                                'var_id' => $var_id,
//                                'key' => $product->key,
//                            ) + $options);
//                    }
                }
            }
        }

    }

    public function actionGetTransport() {
        $resonse = $this->getResponse();
        $resonse['data'] = Orders::getTranportMethod();
        $resonse['code'] = 1;
        $resonse['message'] = 'Thêm sản phẩm vào giỏ hàng thành công';
        return $this->responseData($resonse);
    }


    public function actionCheckout()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $shoppingCart = Yii::app()->customer->getShoppingCart();
        if (!isset($post['products'])) { //Check sản phẩm
            $resonse['code'] = 0;
            $resonse['message'] = 'Không có sản phẳm nào';
            return $this->responseData($resonse);
        }
        self::AddProducts($post['products']);
        if (isset($post['discount_code']) && $post['discount_code']) { //Check mã giảm giá
            $get_discount = self::checkDiscount($post['discount_code']);
            if (!$get_discount['check']) {
                $resonse['code'] = 0;
                $resonse['message'] = $get_discount['message'];
                return $this->responseData($resonse);
            }
        }

        // Luồng Defaut
        if (!$shoppingCart->countOnlyProducts()) {
            $resonse['code'] = 0;
            $resonse['message'] = 'Chưa có sản phẩm nào trong giỏ hàng';
            return $this->responseData($resonse);
        }
        if (!$shoppingCart->checkPointUsed() && ($shoppingCart->getTotalPrice(false))) {
            $shoppingCart->addPointUsed(0);
        }

        $user_address = array();

        $method_arr = Orders::getPaymentMethod();
        foreach ($method_arr as $key => $value) {
            $payment_method[$key]['key'] = $key;
            $payment_method[$key]['value'] = $value;
        }

        $billing = new Billing();
        $billing->billtoship = 0;

        $shipping = new Shipping();
        $order = new Orders();

        $billing->attributes = $post['Billing']; //Truyền vào dữ liệu

        $shipping->attributes = $post['Shipping'];
        if (!$billing->billtoship) {
            $shipping->attributes = $billing->attributes;
        }
        $order->attributes = $post['Orders'];
        // $order->price_ship = (int)str_replace('.', '', Yii::app()->request->getPost('Orders')['price_ship']);
        $infoshop = Yii::app()->siteinfo;
        if ($billing->validate() && $shipping->validate()) {
            //assign billing
            //$order->latlng = $billing->latlng;
            $order->billing_name = $billing->name;
            $order->billing_address = $billing->address;
            $order->billing_email = $billing->email;
            $order->billing_phone = $billing->phone;
            $order->billing_zipcode = $billing->zipcode;
            $order->billing_city = $billing->city;
            $order->billing_district = $billing->district;
            $order->billing_ward = $billing->ward;
            //assign shipping
            $order->shipping_name = $shipping->name;
            $order->shipping_phone = $shipping->phone;
            $order->shipping_address = $shipping->address;
            $order->shipping_city = $shipping->city;
            $order->shipping_district = $shipping->district;
            $order->shipping_ward = $shipping->ward;

            $paymentMethod = Orders::getPaymentMethod();
            if (!$order->isPaymentNganluong()) {
                if (!isset($paymentMethod[$order->payment_method])) {
                    $order->payment_method = null;
                }
            }
            //
            $order->site_id = $this->site_id;

            if (isset($post['user_id']) && $post['user_id']) {
                $order->user_id = $post['user_id'];
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
                if (isset($configBonus) && $configBonus && $configBonus->status == true) {
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
            //
            $discount_for_dealers = 0;

            $order->old_order_total = $shoppingCart->getTotalPrice(false);
            $order->order_total = $total_price_discount + $vat - $discount_for_dealers;
            // Check payment method to add $order->transport_freight
            if ($order->payment_method != 1) {
                $order->order_total += $order->transport_freight;
            }

            /* Section bonus point */
            // Calculate number bonus point after complete Order Request
            $bonusPointFromOrderTotal = ($configBonus && $configBonus->plus_point > 0) ? round(($order->order_total / $configBonus->plus_point)) : 0;
            // Add wait_bonus_point and donate_total to Order Model
            $order->wait_bonus_point = $shoppingCart->getTotalBonusPoint() + $bonusPointFromOrderTotal;
            $order->donate_total = $shoppingCart->getTotalDonate();
            $order->currency = $shoppingCart->getProductCurrency();

            if ($order->save()) {
                // Update coupon used-number
                if ($order->coupon_code) {
                    $coupon_code = CouponCode::model()->findByAttributes(array(
                        'code' => $order->coupon_code,
                    ));
                    $coupon_code->used++;
                    $coupon_code->save();
                }
                // tạo đơn hàng bên giao hành tiết kiệm
//                $tran = new Transport();
//                $paymentMethod = Orders::getPaymentMethod();
                if ($order->price_ship && Yii::app()->siteinfo['token_ghtk'] && Yii::app()->siteinfo['checkout_order'] && Yii::app()->siteinfo['enable_ghtk']) {
                    $order->status_check = Orders::ORDER_CHECK_NONE;
                    $order->save();
                }
                if ($order->price_ship && Yii::app()->siteinfo['token_ghtk'] && !Yii::app()->siteinfo['checkout_order'] && Yii::app()->siteinfo['enable_ghtk']) {
                    $free_rp = Transport::getInfoTransport($billing, $order, $infoshop, LibProvinces::getProvincesById($billing['city'])[0]['name'], LibDistricts::getDistrictById($billing['district'])[0]['name']);
                    if ($free_rp && isset($free_rp['order']) && $free_rp['order']) {
                        $order->status_ship_text = json_encode($free_rp);
                        $order->status_check = Orders::ORDER_CHECK_PROCESSING;
                        $order->status_ship = Orders::ORDER_CHECK_PROCESSING;
                        $order->code_ship = $free_rp['order'];
                    } else {
                        $order->transport_method = 0;
                    }
                    $order->save();
                }
                /**
                 * Write log to db and use point.
                 * */
                $bonusConfig = BonusConfig::checkBonusConfig();
                if (!Yii::app()->user->isGuest && $order->bonus_point_used != 0 && $bonusConfig) {
                    $user = Users::model()->findByPk($post['user_id']);
                    $options = ['note' => BonusPointLog::BONUS_NOTE_USE_POINT_IN_ORDER];
                    $user->usePoint($shoppingCart->getPointUsed(), $options, $order->attributes);
                }
                /* -- End use point -- */
                Yii::app()->user->setFlash('success', Yii::t('shoppingcart', 'order_success_notice'));
                $products = $shoppingCart->findAllProducts();
                foreach ($products as $key => $product) {
                    $orderProduct = new OrderProducts();
                    $orderProduct->product_id = $product['id'];
                    $orderProduct->product_code = $product['code'];
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
//                $order->loadTransport();
                // AFFILIATE
                // END AFFILIATE
                // Send email for admin & khách hàng
                $this->sendMaile($order);
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
                if ($order->payment_method != Orders::PAYMENT_METHOD_AFTER) {


                    /**
                     * @hungtm
                     * nếu user chọn phương thức thanh toán onepay
                     * thì sẽ request đến trang thanh toán của one pay
                     */
                    if ($order->payment_method == Orders::PAYMENT_METHOD_ONEPAY) {
                        $this->requestOnepay($order);
                    }
                    /**
                     * @QuangTS
                     * nếu user chọn phương thức thanh toán vnpay
                     * thì sẽ request đến trang thanh toán của vnpay
                     */
                    if ($order->payment_method == Orders::PAYMENT_METHOD_VNPAY) {
                        $this->requestVNpay($order);
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
                            $resonse['data'] = $order->attributes;
                            $resonse['code'] = 1;
                            $resonse['message'] = 'Đặt hàng thành công.';
                            return $this->responseData($resonse);
                        }
                        if (isset($payonline['pmbk_error'])) {
                            $resonse['message'] = "Bảo Kim lỗi : " . $payonline['pmbk_error'] . ". Chúng tôi đã lưu đơn hàng của bạn vào hệ thống. Rất xin lỗi vì sự cố này.";
                            return $this->responseData($resonse);
                        }
                    }
//                    if ($order->payment_method == Orders::PAYMENT_METHOD_ATM_OFFLINE) {
//                         //Lưu lại tài khoản ngân hàng
//                        $order->save();
//                    }
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
                $resonse['data'] = $order->attributes;
                $resonse['code'] = 1;
                $resonse['message'] = 'Đặt hàng thành công.';
            }
        }
        if ($billing->getErrors()) {
            $resonse['code'] = 0;
            $resonse['message'] = $billing->getErrors();
            return $this->responseData($resonse);
        }
        if ($shipping->getErrors()) {
            $resonse['code'] = 0;
            $resonse['message'] = $shipping->getErrors();
            return $this->responseData($resonse);
        }

        return $this->responseData($resonse);
    }

    function checkDiscount($discount, $total_price = 0, $product = [])
    {
        $resonse = [];
        $code = (isset($discount) && $discount) ? $discount : '';
        $site_id = Yii::app()->controller->site_id;
        if (isset($code) && $code != '') {
            $shoppingCart = Yii::app()->customer->getShoppingCart();
            $check = false;
            $coupon_code = CouponCode::model()->findByAttributes(array('code' => $code, 'site_id' => $site_id));
            if ($coupon_code === NULL || $coupon_code->site_id != Yii::app()->controller->site_id) {
                $resonse['message'] = 'Không tồn tại mã giảm giá này';
            }
            $couponCampaign = CouponCampaign::model()->findByPk($coupon_code->campaign_id);
            // Kiểm tra chiến dịch
            if ($couponCampaign === NULL) {
                $resonse['message'] = 'Mã code không chính xác hoặc mã code đã hết thời hạn sử dụng, xin hãy nhập code khác!';
            }
            // Kiểm tra thời gian chiến dịch
            if ($couponCampaign) {
                if ($couponCampaign->expired_date <= time() || $couponCampaign->released_date >= time()) {
                    $resonse['message'] = 'Mã code không chính xác hoặc mã code đã hết thời hạn sử dụng, xin hãy nhập code khác!';
                }
                // Kiêm tra xem có giới hạn số lần sử dụng hay không
                if (!$couponCampaign->no_limit) {
                    if ($coupon_code->used >= $couponCampaign->usage_limit) {
                        $resonse['message'] = 'Mã code đã hết số lần sử dụng!';
                    }
                }
                // Kiểm tra xem chiến dịch áp dụng cho loại nào
                if ($couponCampaign->applies_to_resource == CouponCampaign::APPLY_ALL) {
                    // Áp dụng khuyến mại cho tất cả
                    $check = true;
                } else if ($couponCampaign->applies_to_resource == CouponCampaign::APPLY_MINIMUM) {
                    // Áp dụng cho đơn hàng từ bao nhiêu
                    if ($total_price >= $couponCampaign->minimum_order_amount) {
                        $check = true;
                    } else {
                        $resonse['message'] = 'Giá trị đơn hàng tối thiểu để được khuyến mại là ' . number_format($couponCampaign->minimum_order_amount, 0, '.', ',');
                    }
                } else if ($couponCampaign->applies_to_resource == CouponCampaign::APPLY_CATEGORY) {
                    // Áp dụng cho danh mục sản phẩm
                    $products = $product;
                    $category_ids = array_column($products, 'product_category_id');
                    if (!in_array($couponCampaign->category_id, $category_ids)) {
                        $resonse['message'] = 'Đơn hàng bạn mua không có sản phẩm nào thuộc danh mục được khuyến mãi';
                    } else {
                        $check = true;
                        $resonse['check'] = $check;
                    }
                } else if ($couponCampaign->applies_to_resource == CouponCampaign::APPLY_PRODUCT) {
                    // Áp dụng cho sản phẩm
                    $products = $product;
                    $product_ids = array_column($products, 'id');
                    if (!in_array($couponCampaign->product_id, $product_ids)) {
                        $resonse['message'] = 'Đơn hàng bạn mua không có sản phẩm nào được khuyến mãi';
                    } else {
                        $check = true;
                    }
                }
            }
            $resonse['check'] = $check;
            if ($check == true) {
                $shoppingCart->addCouponCode($code);
                $discount = $shoppingCart->getDiscountCoupon(true);
                $discountNotFormat = $shoppingCart->getDiscountCoupon(false);
                $totalRemain = $shoppingCart->getTotalPriceDiscount(true);
                $resonse['code']['data'] = array_merge($couponCampaign->attributes, ['totalDiscount' => $discount, 'discountNotFormat' => $discountNotFormat, 'totalRemain' => $totalRemain]);
                $resonse['message'] = 'Xác nhận mã giảm giá thành công';
                return $resonse;
            }
        }
        return $resonse;
    }



    function sendMaile($order)
    {
        // $order = Orders::model()->findByPk(15166);
        $products = [];
        $products = OrderProducts::getProductsDetailInOrder($order->order_id);
        $data = $order->attributes;
        $data['fr'] = (isset($_SESSION['fr']) && $_SESSION['fr']) ? $_SESSION['fr'] : '';
        $data['order_payment_method'] = Orders::getPaymentMethodInfo($order->payment_method);
        $data['billing_district'] = ($district = LibDistricts::getDistrictDetailFollowProvince($order['billing_city'], $order['billing_district'])) ? $district['name'] : '';
        $data['billing_province'] = ($province = LibProvinces::getProvinceDetail($order['billing_city'])) ? $province['name'] : '';
        $data['shipping_district'] = ($district = LibDistricts::getDistrictDetailFollowProvince($order['shipping_city'], $order['shipping_district'])) ? $district['name'] : '';
        $data['shipping_province'] = ($province = LibProvinces::getProvinceDetail($order['shipping_city'])) ? $province['name'] : '';
        $data['time_create'] = date('d-m-Y H:i:s', $order['created_time']);
        $data['order_payment_status'] = ($order['payment_status'] == ActiveRecord::STATUS_ACTIVED) ? Yii::t('shoppingcart', 'payment_paid') : Yii::t('shoppingcart', 'payment_none');
        $data['order_total_all'] = Product::getPriceText(array('price' => $order['old_order_total'], 'currency' => $order['currency']));
        $data['order_total_cost'] = Product::getPriceText(array('price' => $order['order_total'], 'currency' => $order['currency']));
//        $data['order_coupon'] = Product::getPriceText(array('price' => $order['order_coupon_value'], 'currency' => $order['currency']));
        $data['order_transport_freight'] = Product::getPriceText(array('price' => $order['price_ship'], 'currency' => $order['currency']));
        $data['order_transport_method'] = Orders::getTransportMethodInfo($order->transport_method);
        if ($order->shop_id && $order->transport_type == Orders::TRANSPORT_TYPE_SHOP) {
            $shop = ShopStore::model()->findByPk($order->shop_id);
            $data['order_shop'] = $shop ? Yii::t('site', 'store') . ':' . $shop->name . '(' . $shop->address . ')' : '';
        } else {
            $data['order_shop'] = '';
        }
        $data['prducts'] = $this->renderPartial('_product_mail_settings', array(
            'products' => $products,
            'order' => $order,
        ), true);
        $data['order_id'] = $order->getLabelId();

        //Gửi Admin
        $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
            'mail_key' => 'ordernotice',
        ));
        if ($mailSetting) {
            $data['link'] = Yii::app()->createAbsoluteUrl('/quantri/economy/order/update', array('id' => $order->order_id));
            $content = $mailSetting->getMailContent($data);
            $subject = $mailSetting->getMailSubject($data);
            // echo $content;
            // die();
            $mail = Yii::app()->siteinfo['admin_email'];
            if ($content && $subject && $mail) {
                Yii::app()->mailer->send('', $mail, $subject, $content);
                //$mailer->send($from, $email, $subject, $message);
            }
        }
        //Gửi khách
        $mailSetting4 = MailSettings::model()->mailScope()->findByAttributes(array(
            'mail_key' => 'mail_to_customer',
        ));
        if ($mailSetting4) {
            $data['link'] = Yii::app()->createAbsoluteUrl('/economy/shoppingcart/order', array('id' => $order->order_id, 'key' => $order->key));
            $content = $mailSetting4->getMailContent($data);
            $subject = $mailSetting4->getMailSubject($data);
            $mail = $order->billing_email;
            // echo $content;
            // die();
            if ($content && $subject && $mail) {
                Yii::app()->mailer->send("", $mail, $subject, $content);
                //$mailer->send($from, $email, $subject, $message);
            }
        }
    }

    public function actionGetdiscount()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $code = (isset($post['code']) && $post['code']) ? $post['code'] : '';
        $site_id = Yii::app()->controller->site_id;
        if (isset($code) && $code != '') {
            $check = false;
            $error_message = '';
            $shoppingCart = Yii::app()->customer->getShoppingCart();
            //
            if ($shoppingCart->getCouponCode() == $code) {
                $resonse['code'] = 0;
                $resonse['message'] = 'Bạn đang sử dụng mã này rồi';
                return $this->responseData($resonse);
            }
            //
            $coupon_code = CouponCode::model()->findByAttributes(array('code' => $code, 'site_id' => $site_id));
            if ($coupon_code === NULL || $coupon_code->site_id != Yii::app()->controller->site_id) {
                $resonse['code'] = 0;
                $resonse['message'] = 'Không tồn tại mã giảm giá này';
                return $this->responseData($resonse);
            }

            $couponCampaign = CouponCampaign::model()->findByPk($coupon_code->campaign_id);
            // Kiểm tra chiến dịch
            if ($couponCampaign === NULL) {
                $resonse['code'] = 0;
                $resonse['message'] = 'Mã code không chính xác hoặc mã code đã hết thời hạn sử dụng, xin hãy nhập code khác!';
                return $this->responseData($resonse);
            }
            // Kiểm tra thời gian chiến dịch
            if ($couponCampaign) {
                if ($couponCampaign->expired_date <= time() || $couponCampaign->released_date >= time()) {
                    $resonse['code'] = 0;
                    $resonse['message'] = 'Mã code không chính xác hoặc mã code đã hết thời hạn sử dụng, xin hãy nhập code khác!';
                    return $this->responseData($resonse);
                }
                // Kiêm tra xem có giới hạn số lần sử dụng hay không
                if (!$couponCampaign->no_limit) {
                    if ($coupon_code->used >= $couponCampaign->usage_limit) {
                        $resonse['code'] = 0;
                        $resonse['message'] = 'Mã code đã hết số lần sử dụng!';
                        return $this->responseData($resonse);
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
                        $resonse['code'] = 0;
                        $resonse['message'] = 'Giá trị đơn hàng tối thiểu để được khuyến mại là ' . number_format($couponCampaign->minimum_order_amount, 0, '.', ',');
                        return $this->responseData($resonse);
                    }
                } else if ($couponCampaign->applies_to_resource == CouponCampaign::APPLY_CATEGORY) {
                    // Áp dụng cho danh mục sản phẩm
                    $products = $shoppingCart->findAllProducts();
                    $category_ids = array_column($products, 'product_category_id');
                    if (!in_array($couponCampaign->category_id, $category_ids)) {
                        $resonse['code'] = 0;
                        $resonse['message'] = 'Đơn hàng bạn mua không có sản phẩm nào thuộc danh mục được khuyến mãi';
                        return $this->responseData($resonse);
                    } else {
                        $check = true;
                    }
                } else if ($couponCampaign->applies_to_resource == CouponCampaign::APPLY_PRODUCT) {
                    // Áp dụng cho sản phẩm
                    $products = $shoppingCart->findAllProducts();
                    $product_ids = array_column($products, 'id');
                    if (!in_array($couponCampaign->product_id, $product_ids)) {
                        $resonse['code'] = 0;
                        $resonse['message'] = 'Đơn hàng bạn mua không có sản phẩm nào được khuyến mãi';
                        return $this->responseData($resonse);
                    } else {
                        $check = true;
                    }
                }
            }
            if ($check == true) {
                $shoppingCart->addCouponCode($code);
                $discount = $shoppingCart->getDiscountCoupon(true);
                $discountNotFormat = $shoppingCart->getDiscountCoupon(false);
                $totalRemain = $shoppingCart->getTotalPriceDiscount(true);
                $resonse['code']['data'] = array_merge($couponCampaign->attributes, ['totalDiscount' => $discount, 'discountNotFormat' => $discountNotFormat, 'totalRemain' => $totalRemain]);
                $resonse['code'] = 1;
                $resonse['message'] = 'Xác nhận mã giảm giá thành công';
            }
        }
        return $this->responseData($resonse);
    }

    public function actionGetShoppingcart()
    {
        $resonse = $this->getResponse();
        $shoppingCart = Yii::app()->customer->getShoppingCart();
        $resonse['message'] = 'Chưa có sản phẩm nào trong giỏ hàng';
        $products = $shoppingCart->getProducts();
        if (count($products)) {
            $resonse['data'] = $products;
            $resonse['code'] = 1;
            $resonse['message'] = 'Lấy thông tin giỏ hàng thành công';
        }

        return $this->responseData($resonse);
    }

}
