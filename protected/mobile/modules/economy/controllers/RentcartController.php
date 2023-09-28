<?php

class RentcartController extends PublicController
{

    public $layout = '//layouts/shopping';

    public function actionIndex()
    {
        $this->redirect('/economy/rentcart/order');
    }

    public function actionOrderSimple()
    {
        $this->pageTitle = $this->metaTitle = $this->metakeywords = Yii::t('rent', 'rentcart');
        $model = new OrderRentSimple();
        //
        if (Yii::app()->request->isPostRequest) {
            $model->attributes = Yii::app()->request->getPost('OrderRentSimple');
            $model->created_time = time();
            $model->modified_time = time();
            if ($model->save()) {
                $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                    'mail_key' => 'order_rent_simple_notice',
                ));
                if ($mailSetting) {
                    $region = OrderRentSimple::getNameRegion($model->region);
                    $data = array(
                        'customer_name' => $model->name,
                        'phone' => $model->phone,
                        'region' => $region,
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
                Yii::app()->user->setFlash('success', 'Bạn đã gửi yêu cầu thành công, Chúng tôi sẽ liên hệ với bạn sớm nhất!');
                $this->refresh();
            }
        }
        $this->render('order_simple', array(
            'model' => $model
        ));
    }

    /**
     * Dat hang
     */
    public function actionOrder()
    {
        // Init Value
        $this->pageTitle = $this->metaTitle = $this->metakeywords = Yii::t('rent', 'rentcart');
        $shoppingCart = Yii::app()->customer->getRentCart();
        $model = new BillingRentCart();
        //
        if ($shoppingCart->getProductInfo()) {
            $model->rent_product_id = $shoppingCart->getProductInfo()['id'];
            $model->from_date = $shoppingCart->getDateFrom();
            $model->to_date = $shoppingCart->getDateTo();
            $model->quantity = $shoppingCart->getQuantity();
            $model->vat = $shoppingCart->getVatStatus();
            $model->insurance = $shoppingCart->getInsuranceStatus();
            $model->receive_address_id = $shoppingCart->receive_type;
            $model->return_address_id = $shoppingCart->return_type;
            $model->district_id = $shoppingCart->district_id;
            $model->province_id = $shoppingCart->province_id;
            $model->return_district_id = $shoppingCart->return_district_id;
            $model->return_province_id = $shoppingCart->return_province_id;
            $model->rent_category_id = $shoppingCart->getCategoryId();
        }

        $params = Yii::app()->request->getParam('BillingRentCart');
        $idd = Yii::app()->request->getParam('idd');
        $v = Yii::app()->request->getParam('v');
        if (isset($idd) && $idd && isset($v) && $v) {
            $params['destination_id'] = $idd;
            $params['rent_product_id'] = $v;
            $params['rent_category_id'] = 1;
            $shoppingCart->updateRentCart($params);
        }

        $billing = new BillingRent();
        $orderModel = new OrderRent();
        $billingRentCart = Yii::app()->user->getState('BillingRentCart');
        $billingRent = Yii::app()->user->getState('BillingRent');
        $orderRent = Yii::app()->user->getState('OrderRent');
        $modelOrderRent = new OrderRent();
        //
        if ($params) {
            $model->attributes = $params;
            //Check Ajax type
            if (Yii::app()->request->isAjaxRequest) {
                if ($model->validate()) {
                    if (count($params) && isset($params['rent_product_id']) && isset($params['from_date']) && isset($params['to_date'])) {
                        $product = RentProduct::model()->findByPk($params['rent_product_id']);
                        if ($product && $product->site_id == Yii::app()->controller->site_id) {
                            $shoppingCart->updateRentCart($params);
                        }
                        Yii::app()->user->setState('BillingRentCart', Yii::app()->request->getParam('BillingRentCart'));
                    }
                    //
                    $rentCart = $this->renderPartial('rent_cart', array('shoppingCart' => $shoppingCart), true);
                    $model->setScenario('order');
                    if ($model->validate()) {
                        $this->jsonResponse(200, array('message' => 'success', 'rentCart' => $rentCart, 'model' => $model, 'day' => $shoppingCart->getDateRange()));
                    } else {
                        $this->jsonResponse(400, array('message' => 'error', 'errors' => $model->getJsonErrors(), 'rentCart' => $rentCart, 'model' => $model, 'day' => $shoppingCart->getDateRange()));
                    }
                }
                $this->jsonResponse(400, array(
                    'errors' => $model->getJsonErrors(),
                ));
            } else {

                // Submit type
                $model->setScenario('order');
                if (count($params) && isset($params['rent_product_id']) && isset($params['from_date']) && isset($params['to_date'])) {
                    $product = RentProduct::model()->findByPk($params['rent_product_id']);
                    if ($product && $product->site_id == Yii::app()->controller->site_id) {
                        $shoppingCart->updateRentCart($params);
                    }
                    Yii::app()->user->setState('BillingRentCart', Yii::app()->request->getParam('BillingRentCart'));

                    //
                    if (Yii::app()->user->getState('BillingRent')) {
                        $billing->attributes = Yii::app()->user->getState('BillingRent');
                    }
                    if (Yii::app()->user->getState('OrderRent')) {
                        $orderModel->attributes = Yii::app()->user->getState('OrderRent');
                    }
                    //
                    $post_billing = Yii::app()->request->getParam('BillingRent');
                    $post_orderModel = Yii::app()->request->getParam('OrderRent');
                    //
                    if ($post_billing && $post_orderModel) {
                        $billing->attributes = $post_billing;
                        $orderModel->attributes = $post_orderModel;
                        if ($model->validate() && $billing->validate() && $orderModel->validate()) {
                            if (Yii::app()->request->getParam('OrderRent')) {
                                $modelOrderRent->attributes = $billingRentCart;
                                $param = Yii::app()->request->getParam('OrderRent');
                                $modelOrderRent->attributes = $billingRent;
                                $modelOrderRent->attributes = $billing->attributes;
                                $modelOrderRent->attributes = $orderRent;
                                $modelOrderRent->attributes = $param;
                                $modelOrderRent->total_price = $shoppingCart->getTotalPrice();
                                $modelOrderRent->vat = $shoppingCart->getVatFee();
                                $modelOrderRent->deposits = $shoppingCart->getDepositsFee();
                                $modelOrderRent->created_time = time();
                                $modelOrderRent->status = TranslateOrder::ORDER_WAITFORPROCESS; //
                                $modelOrderRent->currency = $shoppingCart->getCurrency();
                                $modelOrderRent->key = ClaGenerate::getUniqueCode(array('prefix' => 'o'));
                                $modelOrderRent->is_check = true;
                                $modelOrderRent->use_vat = $shoppingCart->getVatStatus();
                                $modelOrderRent->use_insurance = $shoppingCart->getInsuranceStatus();
                                $modelOrderRent->insurance = $shoppingCart->getInsuranceFee();
                                $modelOrderRent->ship_fee = $shoppingCart->getShipFee();
                                $modelOrderRent->return_fee = $shoppingCart->getReturnfee();
                                if (isset($_COOKIE['shop_id']) && $_COOKIE['shop_id']) {
                                    $modelOrderRent->shop_id = $_COOKIE['shop_id'];
                                }
                                $modelOrderRent->total_product_price = $shoppingCart->getProductPrice();
                                $modelOrderRent->receive_address_id = $shoppingCart->receive_type;
                                $modelOrderRent->return_address_id = $shoppingCart->return_type;
                                $modelOrderRent->return_address_name = $shoppingCart->return_address_name;
                                $modelOrderRent->receive_address_name = $shoppingCart->receive_address_name;
                                $modelOrderRent->district_id = $shoppingCart->district_id;
                                if ($modelOrderRent->save()) {
                                    $modelOrderRentDetail = new OrderRentDetail();
                                    $modelOrderRentDetail->order_id = $modelOrderRent->id;
                                    $modelOrderRentDetail->rent_from = $shoppingCart->getDateFrom(true);
                                    $modelOrderRentDetail->rent_to = $shoppingCart->getDateTo(true);
                                    $modelOrderRentDetail->rent_product_id = $shoppingCart->getProductInfo()['id'];
                                    $modelOrderRentDetail->quantity = $shoppingCart->getQuantity();
                                    $modelOrderRentDetail->price = $shoppingCart->getProductInfo()['price'];
                                    $modelOrderRentDetail->currency = 'VND';
                                    $modelOrderRentDetail->rent_category_id = $shoppingCart->getCategoryId();
                                    $modelOrderRentDetail->created_time = time();
                                    $modelOrderRentDetail->day = $shoppingCart->getDateRange();
                                    if ($modelOrderRentDetail->save()) {
                                        if ($modelOrderRent->payment_method == OrderRent::PAYMENT_METHOD_NGANLUONG) {
                                            $this->requestNganluong($modelOrderRent);
                                        }
                                        Yii::app()->user->setFlash('success', Yii::t('shoppingcart', 'order_success_notice'));
                                        //
                                        Yii::app()->user->setState('BillingRentCart', null);
                                        Yii::app()->user->setState('BillingRent', null);
                                        Yii::app()->user->setState('OrderRent', null);
                                        Yii::app()->customer->deleteRentCart();
                                        // Send email for admin
                                        $items = OrderRentDetail::getItemssDetailInOrder($modelOrderRent->id);

                                        $order_prd = $this->renderPartial('checkout_mail_partial', array(
                                            'modelOrderRent' => $modelOrderRent,
                                            'items' => $items,), true);

                                        $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                                            'mail_key' => 'order_rent_notice',
                                        ));
                                        if ($mailSetting) {
                                            //Hiện ra danh sách sản phẩm được chọn.
                                            $data = array(
                                                'link' => '<a href="' . Yii::app()->createAbsoluteUrl('/economy/rentcart/checkout', array('id' => $modelOrderRent->id, 'key' => $modelOrderRent->key)) . '">Link</a>',
                                                'customer_name' => $modelOrderRent->name,
                                                'customer_email' => $modelOrderRent->email,
                                                'customer_phone' => $modelOrderRent->phone,
                                                'total_price' => $modelOrderRent->total_price,
                                                'order_prd' => $order_prd,
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

                                        $mailSetting2 = MailSettings::model()->mailScope()->findByAttributes(array(
                                            'mail_key' => 'customer_order_rent_notice',
                                        ));
                                        if ($mailSetting2) {
                                            //Hiện ra danh sách sản phẩm được chọn.
                                            $data = array(
                                                'link' => '<a href="' . Yii::app()->createAbsoluteUrl('/economy/rentcart/checkout', array('id' => $modelOrderRent->id, 'key' => $modelOrderRent->key)) . '">Link</a>',
                                                'customer_name' => $modelOrderRent->name,
                                                'customer_email' => $modelOrderRent->email,
                                                'customer_phone' => $modelOrderRent->phone,
                                                'total_price' => $modelOrderRent->total_price,
                                                'order_prd' => $order_prd,
                                            );
                                            //
                                            $content2 = $mailSetting2->getMailContent($data);
                                            //
                                            $subject2 = $mailSetting2->getMailSubject($data);
                                            //
                                            if ($content2 && $subject2) {
                                                Yii::app()->mailer->send('', $modelOrderRent->email, $subject2, $content2);
                                            }
                                        }
                                        $mailSetting3 = MailSettings::model()->mailScope()->findByAttributes(array(
                                            'mail_key' => 'order_rent',
                                        ));
                                        if ($mailSetting3) {
                                            //Hiện ra danh sách sản phẩm được chọn.
                                            $order_prd = $this->renderPartial('mail_rentcart', array(
                                                'modelOrderRentDetail' => $modelOrderRentDetail,
                                                'modelOrderRent' => $modelOrderRent,
                                                'items' => $items,
                                                'shoppingCart' => $shoppingCart,), true);

                                            if (isset($modelOrderRent->shop_id) && $modelOrderRent->shop_id != "" ) {

                                                $mailtoshop = ShopStore::model()->findByPk($modelOrderRent->shop_id)->email;
                                            }
                                            else {
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
                                            $order_prd = $this->renderPartial('mail_rentcart', array(
                                                'modelOrderRentDetail' => $modelOrderRentDetail,
                                                'modelOrderRent' => $modelOrderRent,
                                                'items' => $items,
                                                'shoppingCart' => $shoppingCart,), true);
                                            $mailtocustomer = $modelOrderRent->email;
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
                                        //
                                        $this->redirect(Yii::app()->createUrl('/economy/rentcart/checkout', array('id' => $modelOrderRent->id, 'key' => $modelOrderRent->key)));
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $listdistrict = [];
        if ($model->province_id) {
            $listdistrict = array('' => Yii::t('common', 'choose_district')) + LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }

        $listdistrict_return = [];
        if ($model->return_province_id) {
            $listdistrict_return = array('' => Yii::t('common', 'choose_district')) + LibDistricts::getListDistrictArrFollowProvince($model->return_province_id);
        }

        $rentCart = $this->renderPartial('rent_cart', array('shoppingCart' => $shoppingCart), true);
        //
        $this->render('order', array(
            'shoppingCart' => $shoppingCart,
            'model' => $model,
            'rentCart' => $rentCart,
            'listdistrict' => $listdistrict,
            'listdistrict_return' => $listdistrict_return,
            'orderModel' => $orderModel,
            'billing' => $billing,
            'modelOrderRent' => $modelOrderRent,
        ));
    }

    //mã giảm giá
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
                $shoppingCart->updateRentCart($code);
                $this->jsonResponse(200, array_merge($couponCampaign->attributes, ['totalDiscount' => $discount, 'discountNotFormat' => $discountNotFormat, 'totalRemain' => $totalRemain]));
            }
            $this->jsonResponse(404, array('msg' => $error_message));
        }
        $this->jsonResponse(404);
    }

    /**
     * Cart Info
     */
    public function actionBillingInfo()
    {
        $this->metaTitle = Yii::t('rent', 'billing_info');
        $shoppingCart = Yii::app()->customer->getRentCart();
        $params = Yii::app()->user->getState('BillingRentCart');
        if (!count($params)) {
            $this->redirect('order');
        }
        $this->pageTitle = $this->metakeywords = Yii::t('rent', 'billing_info');
        $model = new BillingRentCart();
        $model->attributes = $params;

        $rentCart = $this->renderPartial('rent_cart', array(
            'shoppingCart' => $shoppingCart,
        ), true);
        //
        $billing = new BillingRent();
        $orderModel = new OrderRent();
        //
        if (Yii::app()->user->getState('BillingRent')) {
            $billing->attributes = Yii::app()->user->getState('BillingRent');
        }
        if (Yii::app()->user->getState('OrderRent')) {
            $orderModel->attributes = Yii::app()->user->getState('OrderRent');
        }
        //
        $post_billing = Yii::app()->request->getParam('BillingRent');
        $post_orderModel = Yii::app()->request->getParam('OrderRent');
        //
        if ($post_billing && $post_orderModel) {
            $billing->attributes = $post_billing;
            $orderModel->attributes = $post_orderModel;
            if ($billing->validate() && $orderModel->validate()) {
                Yii::app()->user->setState('BillingRent', Yii::app()->request->getParam('BillingRent'));
                Yii::app()->user->setState('OrderRent', Yii::app()->request->getParam('OrderRent'));
                $this->redirect('payment');
            }
        }
        //
        $this->render('billing_info', array(
            'shoppingCart' => $shoppingCart,
            'rentCart' => $rentCart,
            'model' => $model,
            'orderModel' => $orderModel,
            'billing' => $billing
        ));
    }

    public function actionPayment()
    {
        $this->metaTitle = Yii::t('rent', 'payment');
        $this->pageTitle = $this->metakeywords = Yii::t('rent', 'shoppingcart_payment');
        $shoppingCart = Yii::app()->customer->getRentCart();
        $billingRentCart = Yii::app()->user->getState('BillingRentCart');
        $billingRent = Yii::app()->user->getState('BillingRent');
        $orderRent = Yii::app()->user->getState('OrderRent');
        //
        if (!$orderRent && !$billingRentCart && !$billingRent) {
            $this->redirect('order');
        }
        //
        $modelOrderRent = new OrderRent();
        //

        if (Yii::app()->request->getParam('OrderRent')) {
            $modelOrderRent->attributes = $billingRentCart;
            $param = Yii::app()->request->getParam('OrderRent');
            $modelOrderRent->attributes = $billingRent;
            $modelOrderRent->attributes = $orderRent;
            $modelOrderRent->attributes = $param;
            $modelOrderRent->total_price = $shoppingCart->getTotalPrice();
            $modelOrderRent->vat = $shoppingCart->getVatFee();
            $modelOrderRent->deposits = $shoppingCart->getDepositsFee();
            $modelOrderRent->created_time = time();
            $modelOrderRent->status = TranslateOrder::ORDER_WAITFORPROCESS; //
            $modelOrderRent->currency = $shoppingCart->getCurrency();
            $modelOrderRent->key = ClaGenerate::getUniqueCode(array('prefix' => 'o'));
            $modelOrderRent->is_check = true;
            $modelOrderRent->use_vat = $shoppingCart->getVatStatus();
            $modelOrderRent->use_insurance = $shoppingCart->getInsuranceStatus();
            $modelOrderRent->insurance = $shoppingCart->getInsuranceFee();
            $modelOrderRent->ship_fee = $shoppingCart->getShipFee();
            $modelOrderRent->return_fee = $shoppingCart->getReturnfee();
            $modelOrderRent->total_product_price = $shoppingCart->getProductPrice();
            $modelOrderRent->receive_address_id = $shoppingCart->receive_type;
            $modelOrderRent->return_address_id = $shoppingCart->return_type;
            $modelOrderRent->return_address_name = $shoppingCart->return_address_name;
            $modelOrderRent->receive_address_name = $shoppingCart->receive_address_name;
            if ($modelOrderRent->save()) {
                $modelOrderRentDetail = new OrderRentDetail();
                $modelOrderRentDetail->order_id = $modelOrderRent->id;
                $modelOrderRentDetail->rent_from = $shoppingCart->getDateFrom(true);
                $modelOrderRentDetail->rent_to = $shoppingCart->getDateTo(true);
                $modelOrderRentDetail->rent_product_id = $shoppingCart->getProductInfo()['id'];
                $modelOrderRentDetail->quantity = $shoppingCart->getQuantity();
                $modelOrderRentDetail->price = $shoppingCart->getProductInfo()['price'];
                $modelOrderRentDetail->currency = 'VND';
                $modelOrderRentDetail->created_time = time();
                $modelOrderRentDetail->day = $shoppingCart->getDateRange();
                if ($modelOrderRentDetail->save()) {
                    if ($modelOrderRent->payment_method == OrderRent::PAYMENT_METHOD_NGANLUONG) {
                        $this->requestNganluong($modelOrderRent);
                    }
                    Yii::app()->user->setFlash('success', Yii::t('shoppingcart', 'order_success_notice'));
                    //
                    Yii::app()->user->setState('BillingRentCart', null);
                    Yii::app()->user->setState('BillingRent', null);
                    Yii::app()->user->setState('OrderRent', null);
                    Yii::app()->customer->deleteRentCart();
                    // Send email for admin
                    $items = OrderRentDetail::getItemssDetailInOrder($modelOrderRent->id);

                    $order_prd = $this->renderPartial('checkout_mail_partial', array(
                        'modelOrderRent' => $modelOrderRent,
                        'items' => $items,), true);

                    $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                        'mail_key' => 'order_rent_notice',
                    ));
                    if ($mailSetting) {
                        //Hiện ra danh sách sản phẩm được chọn.
                        $data = array(
                            'link' => '<a href="' . Yii::app()->createAbsoluteUrl('/economy/rentcart/checkout', array('id' => $modelOrderRent->id, 'key' => $modelOrderRent->key)) . '">Link</a>',
                            'customer_name' => $modelOrderRent->name,
                            'customer_email' => $modelOrderRent->email,
                            'customer_phone' => $modelOrderRent->phone,
                            'total_price' => $modelOrderRent->total_price,
                            'order_prd' => $order_prd,
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

                    $mailSetting2 = MailSettings::model()->mailScope()->findByAttributes(array(
                        'mail_key' => 'customer_order_rent_notice',
                    ));
                    if ($mailSetting2) {
                        //Hiện ra danh sách sản phẩm được chọn.
                        $data = array(
                            'link' => '<a href="' . Yii::app()->createAbsoluteUrl('/economy/rentcart/checkout', array('id' => $modelOrderRent->id, 'key' => $modelOrderRent->key)) . '">Link</a>',
                            'customer_name' => $modelOrderRent->name,
                            'customer_email' => $modelOrderRent->email,
                            'customer_phone' => $modelOrderRent->phone,
                            'total_price' => $modelOrderRent->total_price,
                            'order_prd' => $order_prd,
                        );
                        //
                        $content2 = $mailSetting2->getMailContent($data);
                        //
                        $subject2 = $mailSetting2->getMailSubject($data);
                        //
                        if ($content2 && $subject2) {
                            Yii::app()->mailer->send('', $modelOrderRent->email, $subject2, $content2);
                        }
                    }
                    //
                    $this->redirect(Yii::app()->createUrl('/economy/rentcart/checkout', array('id' => $modelOrderRent->id, 'key' => $modelOrderRent->key)));
                }
            }
        }

        $rentCart = $this->renderPartial('rent_cart', array(
            'shoppingCart' => $shoppingCart,
        ), true);

        //
        $this->render('payment', array(
            'shoppingCart' => $shoppingCart,
            'modelOrderRent' => $modelOrderRent,
            'rentCart' => $rentCart
        ));
    }

    public function actionCheckout()
    {
        $id = Yii::app()->request->getParam('id');
        $key = Yii::app()->request->getParam('key');
        if ($id && $key) {
            $modelOrderRent = OrderRent::model()->findByPk($id);
            if (!$modelOrderRent) {
                $this->sendResponse(404);
            }
            if ($modelOrderRent->key != $key) {
                $this->sendResponse(404);
            }
            $items = OrderRentDetail::getItemssDetailInOrder($id);
            //
            $this->render('checkout', array(
                'modelOrderRent' => $modelOrderRent,
                'items' => $items,
            ));
        }
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

    public static function null2unknown($data)
    {
        if ($data == "") {
            return "No Value Returned";
        } else {
            return $data;
        }
    }

    /**
     * Thêm sp vào giỏ hàng
     */
    public function actionAdd()
    {
        $shoppingCart = Yii::app()->customer->getRentCart();
        $model = new BillingRentCart();
        //
        $params = Yii::app()->request->getParam('BillingRentCart');
        if ($params) {
            $model->attributes = $params;
            if ($model->validate()) {
                if (count($params) && isset($params['rent_product_id']) && isset($params['from_date']) && isset($params['to_date'])) {
                    $product = RentProduct::model()->findByPk($params['rent_product_id']);
                    if ($product && $product->site_id == Yii::app()->controller->site_id) {
                        $shoppingCart->updateRentCart($params);
                    }
                }
                if (Yii::app()->request->isAjaxRequest) {
                    $this->jsonResponse(200, array('message' => 'success', 'day' => $shoppingCart->getDateRange(), 'total_price' => HtmlFormat::money_format($shoppingCart->getProductPrice())));
                } else {
                    $this->redirect(array('order'));
                }
            }
            if (Yii::app()->request->isAjaxRequest) {
                $this->jsonResponse(400);
            } else {
                $this->redirect(array('orderSimple'));
            }
        }
    }

    /**
     * Thêm sp vào giỏ hàng
     */
    public function actionAddPrd($id)
    {
        $params['rent_product_id'] = $id;
        $params['from_date'] = date('d/m/Y', time() + (60 * 60 * 24 * 4));
        $params['to_date'] = date('d/m/Y', time() + (60 * 60 * 24 * 5));

        $shoppingCart = Yii::app()->customer->getRentCart();
        $model = new BillingRentCart();
        //
        if ($params) {
            $model->attributes = $params;
            if (count($params) && isset($params['rent_product_id']) && isset($params['from_date']) && isset($params['to_date'])) {
                $product = RentProduct::model()->findByPk($params['rent_product_id']);
                if ($product && $product->site_id == Yii::app()->controller->site_id) {
                    $shoppingCart->updateRentCart($params);
                }
            }
            $this->redirect(array('orderSimple'));
        }
    }

    /**
     * Thêm sp vào giỏ hàng
     */
    public function actionGetProductInDestination()
    {
        $des_id = (int)Yii::app()->request->getParam('id');
        if (!$des_id) {
            $this->sendResponse(404);
        }
        $rentProduct = RentProduct::getAllRentProductInDestination($des_id);
        $return[''] = '--- Chọn quốc gia ---';
        $array_op = $return + array_column($rentProduct, 'name', 'id');
        $html = CHtml::dropDownList('OrderRentSimple[product_id]', '', $array_op);
        $this->jsonResponse(200, array(
            'message' => 'success',
            'html' => $html,
        ));
    }
    public function actionGetProductRentCategory()
    {
        $des_id = (int)Yii::app()->request->getParam('id');
        if (!$des_id) {
            $this->sendResponse(404);
        }
        $optionsCategory = RentProductPrice::getOptionsCategory($des_id);
        $html = CHtml::dropDownList('OrderRentSimple[product_id]', '', $optionsCategory);
        $this->jsonResponse(200, array(
            'message' => 'success',
            'html' => $html,
        ));
    }

    /**
     * Hatv
     * Thêm thay đổi số lượng sản phẩm trong giỏ hàng
     */
    public function actionChangeQty()
    {
        $product_id = (int)Yii::app()->request->getParam('pid');
        $quantity = (int)Yii::app()->request->getParam('qty');
        $attributes = Yii::app()->request->getParam(ClaRentCart::PRODUCT_ATTRIBUTE_CONFIGURABLE_KEY);
        $attributesCP = Yii::app()->request->getParam(ClaRentCart::PRODUCT_ATTRIBUTE_CHANGEPRICE_KEY);

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
                $shoppingCart = Yii::app()->customer->getRentCart();
                $shoppingCart->changeQty($key, array('product_id' => $product_id, 'qty' => intval($quantity), 'price' => $product->price, ClaRentCart::MORE_INFO => $saveAttributes));
                if (Yii::app()->request->isAjaxRequest) {
                    $this->jsonResponse('200', array(
                        'message' => 'success',
                        'total' => Yii::app()->customer->getRentCart()->countProducts(),
                        'products' => Yii::app()->customer->getRentCart()->countOnlyProducts(),
                        'redirect' => Yii::app()->createUrl('/economy/rentcart'),
                        'cartTitle' => Yii::t('shoppingcart', 'shoppingcart') . ' (' . Yii::app()->customer->getRentCart()->countOnlyProducts() . ')',
                        'cart' => $this->renderPartial('cart_ajax', array(
                            'shoppingCart' => $shoppingCart,
                        ), true),
                    ));
                } else
                    $this->redirect(Yii::app()->createUrl('/economy/rentcart'));
            }
        }
    }

    /**
     * xóa product khỏi shopping cart
     */
    public function actionDelete()
    {
        $key = Yii::app()->request->getParam('key');
//        $key = (is_numeric($key)) ? $key : (int) $key;
        if ($key) {
            if (!Yii::app()->siteinfo['use_shoppingcart_set']) {
                $shoppingCart = Yii::app()->customer->getRentCart();
                $cartInfo = $shoppingCart->getInfoByKey($key);
                if ($cartInfo && isset($cartInfo['product_id'])) {
                    $product = Product::model()->findByPk($cartInfo['product_id']);
                    if ($product && $product->site_id == $this->site_id) {
                        $shoppingCart->remove($key);
                        if (Yii::app()->request->isAjaxRequest) {
                            $this->jsonResponse('200', array(
                                'message' => 'success',
                                'total' => Yii::app()->customer->getRentCart()->countProducts(),
                            ));
                        } else
                            $this->redirect(Yii::app()->createUrl('/economy/rentcart'));
                    }
                }
            } else {
                $set = Yii::app()->request->getParam('set');
                $shoppingCart = Yii::app()->customer->getRentCart();
                $cartInfo = $shoppingCart->getInfoByKey($key, $set);
                if ($cartInfo && isset($cartInfo['product_id'])) {
                    $product = Product::model()->findByPk($cartInfo['product_id']);
                    if ($product && $product->site_id == $this->site_id) {
                        $shoppingCart->remove($key, $set);
                        if (Yii::app()->request->isAjaxRequest) {
                            $this->jsonResponse('200', array(
                                'message' => 'success',
                                'total' => Yii::app()->customer->getRentCart()->countProducts(),
                            ));
                        } else
                            $this->redirect(Yii::app()->createUrl('/economy/rentcart', array('sid' => $set)));
                    }
                }
            }
        }
        $this->sendResponse(400);
    }

    public function actionGetReceiveDistrict()
    {
        $shoppingCart = Yii::app()->customer->getRentCart();
        $params = Yii::app()->request->getParam('BillingRentCart');
        $province_id = $params['province_id'];

        if ($province_id) {
            $listdistrict = LibDistricts::getListDistrictFollowProvince($province_id);

            if ($listdistrict) {
                //
                if (count($params) && isset($params['rent_product_id']) && isset($params['from_date']) && isset($params['to_date'])) {
                    $product = RentProduct::model()->findByPk($params['rent_product_id']);
                    if ($product && $product->site_id == Yii::app()->controller->site_id) {
                        $shoppingCart->updateRentCart($params);
                    }
                }
                //
                $rentCart = $this->renderPartial('rent_cart', array('shoppingCart' => $shoppingCart), true);
                $this->jsonResponse('200', array(
                    'rentCart' => $rentCart,
                    'html' => $this->renderPartial('ldistrict', array('listdistrict' => $listdistrict), true),
                ));
            }
        } else {
            $listdistrict = array();
            $rentCart = $this->renderPartial('rent_cart', array('shoppingCart' => $shoppingCart), true);
            $this->jsonResponse('200', array(
                'rentCart' => $rentCart,
                'html' => $this->renderPartial('ldistrict', array('listdistrict' => $listdistrict), true),
            ));
        }
    }

    public function actionGetReturnDistrict()
    {
        $shoppingCart = Yii::app()->customer->getRentCart();
        $params = Yii::app()->request->getParam('BillingRentCart');
        $return_province_id = $params['return_province_id'];

        if ($return_province_id) {
            $listdistrict = LibDistricts::getListDistrictFollowProvince($return_province_id);

            if ($listdistrict) {
                //
                if (count($params) && isset($params['rent_product_id']) && isset($params['from_date']) && isset($params['to_date'])) {
                    $product = RentProduct::model()->findByPk($params['rent_product_id']);
                    if ($product && $product->site_id == Yii::app()->controller->site_id) {
                        $shoppingCart->updateRentCart($params);
                    }
                }
                //
                $rentCart = $this->renderPartial('rent_cart', array('shoppingCart' => $shoppingCart), true);
                $this->jsonResponse('200', array(
                    'rentCart' => $rentCart,
                    'html' => $this->renderPartial('ldistrict', array('listdistrict' => $listdistrict), true),
                ));
            }
        } else {
            $listdistrict = array();
            $rentCart = $this->renderPartial('rent_cart', array('shoppingCart' => $shoppingCart), true);
            $this->jsonResponse('200', array(
                'rentCart' => $rentCart,
                'html' => $this->renderPartial('ldistrict', array('listdistrict' => $listdistrict), true),
            ));
        }
    }

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
        $return_url = urlencode(Yii::app()->createAbsoluteUrl('/economy/rentcart/callbackNganluongSuccess', array(
            'id' => $order->order_id,
            'key' => $order->key,
        )));
        // $cancel_url = urlencode('http://localhost/nganluong.vn/checkoutv3?orderid=' . $order_code);
        $cancel_url = urlencode(Yii::app()->createAbsoluteUrl('/economy/rentcart/checkout', array(
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
     *
     */
    public function actionCallbackNganluongSuccess()
    {
        $id = Yii::app()->request->getParam('id');
        $key = Yii::app()->request->getParam('key');
        $config = SitePayment::model()->getConfigPayment(SitePayment::TYPE_NGANLUONG);
        $nlcheckout = new NganluongHelper($config['merchan_id'], $config['secure_pass'], $config['email_bussiness'], $config['url_request']);
        $token = $_GET['token'];
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
                        //
                        $mailSettingCustommer = MailSettings::model()->mailScope()->findByAttributes(array(
                            'mail_key' => 'payment_method_customer_notice',
                        ));
//            //
                        if ($mailSettingCustommer) {
//                // Chi tiết trong thư
                            $data2 = array(
                                'link' => '<a href="' . Yii::app()->createAbsoluteUrl('/economy/rentcart/checkout', array('id' => $order->id, 'key' => $order->key)) . '">Link</a>',
                                'customer' => $order->name,
                                'payment_method' => TranslateOrder::getPaymentMethod()[$order->payment_method],
                            );
//                //
                            $content = $mailSettingCustommer->getMailContent($data2);
                            $subject = $mailSettingCustommer->getMailSubject($data2);
//                //
                            if ($content && $subject) {
                                Yii::app()->mailer->send('', $order->email, $subject, $content);
                            }
                        };
                    }
                }
            } else {
                echo $nlcheckout->GetErrorMessage($nl_errorcode);
                die();
            }
        }
        $this->redirect(Yii::app()->createUrl('/economy/rentcart/checkout', array(
            'id' => $order->id,
            'key' => $order->key,
        )));
    }

    public function actionOrderAjax()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $name = Yii::app()->request->getParam('name', '');
            $phone = Yii::app()->request->getParam('phone', '');
            $region = Yii::app()->request->getParam('region', '');
            if ($name && $phone && $region) {
                $model = new OrderRentSimple();
                $model->name = $name;
                $model->phone = $phone;
                $model->region = $region;
                if ($model->save()) {
                    $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                        'mail_key' => 'order_rent_simple_notice',
                    ));
                    if ($mailSetting) {
                        $region = OrderRentSimple::getNameRegion($model->region);
                        $data = array(
                            'customer_name' => $model->name,
                            'phone' => $model->phone,
                            'region' => $region,
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
                    $this->jsonResponse(200, array(
                        'message' => 'Gửi yêu cầu thành công'
                    ));
                }
            }
        }
        Yii::app()->end();
    }

}
