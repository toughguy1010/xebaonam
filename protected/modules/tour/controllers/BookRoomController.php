<?php

class BookRoomController extends PublicController {

    public $layout = '//layouts/book_room';

    /**
     * Đặt phòng khách sạn
     */
    public function actionCreate() {

        $model = new TourBooking();
        $model->scenario = 'book_room';
        $room = new TourBookingRoom();
        $room->scenario = 'book_room';

        if (isset($_POST['TourBooking']) || $_POST['TourBookingRoom']) {
            $model->attributes = $_POST['TourBooking'];
            $total_day = 1;
            if ($model->checking_in && $model->checking_in != '' && (int) strtotime($model->checking_in)) {
                $model->checking_in = (int) strtotime($model->checking_in);
            }
            if ($model->checking_out && $model->checking_out != '' && (int) strtotime($model->checking_out)) {
                $model->checking_out = (int) strtotime($model->checking_out);
            }
            if ($model->checking_in >= $model->checking_out) {
                $model->addError('checking_out', 'Ngày trả phòng phải lớn hơn ngày nhận phòng');
            } else {
                $time = $model->checking_out - $model->checking_in;
                $total_day = $time / 86400;
            }
            if ($model->transfer_request) {
                if ($model->arrival_time && $model->arrival_time != '' && (int) strtotime($model->arrival_time)) {
                    $model->arrival_time = (int) strtotime($model->arrival_time);
                }
                if ($model->travel_time && $model->travel_time != '' && (int) strtotime($model->travel_time)) {
                    $model->travel_time = (int) strtotime($model->travel_time);
                }
            }

            $room->attributes = $_POST['TourBookingRoom'];
            if (!$room->room_id) {
                $room->addError('room_id', 'Loại phòng không được phép rỗng');
            }
            if (!$room->room_qty) {
                $room->addError('room_qty', 'Số lượng phòng không được phép rỗng');
            }
            $model->ip_address = $_SERVER['REMOTE_ADDR']; // ip của người đặt phòng
            $model->type = TourBooking::TYPE_BOOKING_ROOM;
            //
            if ($model->validate() && $room->validate()) {
                $room_model = TourHotelRoom::model()->findByPk($room->room_id);
                $model->booking_total = $room->room_qty * $room_model->price * $total_day;
                if ($model->save()) {
                    $room->booking_id = $model->booking_id;
                    $room->hotel_id = $room_model->id;
                    $room->room_price = $room_model->price;
                    if ($room->save()) {
                        // payment online ngân lượng
                        if ($model->isPaymentOnline()) {
                            $config = SitePayment::model()->getConfigPayment(SitePayment::TYPE_NGANLUONG);
                            $nlcheckout = new NganluongHelper($config['merchan_id'], $config['secure_pass'], $config['email_bussiness'], $config['url_request']);
                            $total_amount = $model->booking_total;
                            //
                            $array_items = array();
                            $array_items[0] = array(
                                'item_name1' => $room_model->name,
                                'item_quantity1' => $room->room_qty,
                                'item_amount1' => $room->room_price,
                                'item_url1' => ''
                            );
                            //
                            $payment_method = $model->payment_method;
                            $bank_code = isset($model->bankcode) ? $model->bankcode : '';
                            $order_code = $model->booking_id; // mã booking
                            //
                            $payment_type = '';
                            $discount_amount = 0;
                            $order_description = '';
                            $tax_amount = 0;
                            $fee_shipping = 0;
                            $return_url = urlencode(Yii::app()->createAbsoluteUrl('tour/bookRoom/paymentSuccess'));
//                            $cancel_url = urlencode('http://localhost/nganluong.vn/checkoutv3?orderid=' . $order_code);
                            $cancel_url = urlencode(Yii::app()->createAbsoluteUrl('tour/bookRoom/paymentCancel', array('orderid' => $order_code)));
                            //
                            $buyer_fullname = $model->name; // Tên người đặt phòng
                            $buyer_email = $model->email; // Email người đặt phòng
                            $buyer_mobile = $model->phone; // Điện thoại người đặt phòng
                            $buyer_address = $model->address; // Địa chỉ người đặt phòng
                            if ($payment_method != '' && $buyer_email != "" && $buyer_mobile != "" && $buyer_fullname != "" && filter_var($buyer_email, FILTER_VALIDATE_EMAIL)) {
                                if ($payment_method == TourBooking::PAYMENT_METHOD_VISA) {
                                    $nl_result = $nlcheckout->VisaCheckout($order_code, $total_amount, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items, $bank_code);
                                } elseif ($payment_method == TourBooking::PAYMENT_METHOD_NL) {
                                    $nl_result = $nlcheckout->NLCheckout($order_code, $total_amount, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items);
                                } elseif ($payment_method == TourBooking::PAYMENT_METHOD_ATM_ONLINE && $bank_code != '') {
                                    $nl_result = $nlcheckout->BankCheckout($order_code, $total_amount, $bank_code, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items);
                                } elseif ($payment_method == TourBooking::PAYMENT_METHOD_NH_OFFLINE) {
                                    $nl_result = $nlcheckout->officeBankCheckout($order_code, $total_amount, $bank_code, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items);
                                } elseif ($payment_method == TourBooking::PAYMENT_METHOD_ATM_OFFLINE) {
                                    $nl_result = $nlcheckout->BankOfflineCheckout($order_code, $total_amount, $bank_code, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items);
                                } elseif ($payment_method == TourBooking::PAYMENT_METHOD_IB_ONLINE) {
                                    $nl_result = $nlcheckout->IBCheckout($order_code, $total_amount, $bank_code, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items);
                                }
                            }
                            if ($nl_result->error_code == '00') {
                                $url_checkout = (string) $nl_result->checkout_url;
                                $this->redirect($url_checkout);
                            } else {
                                echo $nl_result->error_message;
                            }
                        }
                        // send mail 
                        $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                            'mail_key' => 'booking_room_notice',
                        ));
                        if ($mailSetting) {
                            $data = array(
                                'user_name' => $model->name,
                            );
                            //
                            $content = $mailSetting->getMailContent($data);
                            //
                            $subject = $mailSetting->getMailSubject($data);
                            //
                            if ($content && $subject) {
                                $admins = ClaSite::getAdminMails();
                                if ($admins) {
                                    foreach ($admins as $admin) {
                                        Yii::app()->mailer->send('', $admin, $subject, $content);
                                    }
                                }
                            }
                        }
                        // end send mail
                        $this->redirect(Yii::app()->createUrl('tour/bookRoom/success', array('order_code' => $model->booking_id)));
                    }
                }
            }
        }

        $this->render('create', array(
            'model' => $model,
            'room' => $room
        ));
    }

    public function actionSuccess() {
        $order_code = Yii::app()->request->getParam('order_code');
        $model = TourBooking::model()->findByPk($order_code);
        $room = TourBookingRoom::model()->findByAttributes(array('booking_id' => $model->booking_id));
        $this->render('success', array(
            'model' => $model,
            'room' => $room
        ));
    }

    public function actionPaymentSuccess() {
        $token = Yii::app()->request->getParam('token', '');
        if ($token == '') {
            $this->redirect(Yii::app()->getBaseUrl(true));
        }
        $config = SitePayment::model()->getConfigPayment(SitePayment::TYPE_NGANLUONG);
        $nlcheckout = new NganluongHelper($config['merchan_id'], $config['secure_pass'], $config['email_bussiness'], $config['url_request']);
        $nl_result = $nlcheckout->GetTransactionDetail($token);
        $model = TourBooking::model()->findByPk($nl_result->order_code);
        $room = TourBookingRoom::model()->findByAttributes(array('booking_id' => $model->booking_id));
        if ($nl_result) {
            $nl_errorcode = (string) $nl_result->error_code;
            $nl_transaction_status = (string) $nl_result->transaction_status;
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
                        $model->status_payment = TourBooking::STATUS_SUCCESS_PAYMENT;
                        $model->save();
                    }
                }
            } else {
                echo $nlcheckout->GetErrorMessage($nl_errorcode);
                die();
            }
        }
        $this->render('success', array(
            'model' => $model,
            'room' => $room
        ));
    }

    public function actionPaymentCancel($orderid) {
        $model = TourBooking::model()->findByPk($orderid);
        $model->status = TourBooking::STATUS_CANCEL;
        $model->save();
        $this->render('cancel', array(
            'model' => $model
        ));
    }

    public function actionGetRoomInfo() {
        if (Yii::app()->request->isAjaxRequest) {
            $room_id = Yii::app()->request->getParam('room_id', 0);
            if (isset($room_id) && $room_id) {
                $room = TourHotelRoom::model()->findByPk($room_id);
                $data = $room->attributes;
                $data['price_format'] = number_format($data['price'], 0, ',', '.') . ' VNĐ';
                $this->jsonResponse(200, array(
                    'data' => $data
                ));
            }
        }
    }

}
