<?php

class BookingController extends PublicController {

    public $layout = '//layouts/booking';

    /**
     * Đặt phòng khách sạn
     */
    public function actionBookingRoom() {
        if (isset($_POST['TourBooking']) && $_POST['TourBooking']) {
            $listprovince = LibProvinces::getListProvinceArr();
            $hotel_id = $_POST['TourBooking']['hotel_id'];
            $hotel = TourHotel::model()->findByPk($hotel_id);
            $ids = array_filter($_POST['TourBooking']['room']);
            $checking_in = $_POST['TourBooking']['checking_in'];
            $checking_out = $_POST['TourBooking']['checking_out'];

            list($d, $m, $y) = explode('-', $checking_in);
            $checking_in = $y . '-' . $m . '-' . $d;
            $date_checking_in = strtotime($checking_in);

            list($do, $mo, $yo) = explode('-', $checking_out);
            $checking_out = $yo . '-' . $mo . '-' . $do;
            $date_checking_out = strtotime($checking_out);
            $datediff = abs($date_checking_in - $date_checking_out);
            $count_night = floor($datediff / (60 * 60 * 24));
            $rooms = TourHotelRoom::getRoomByIds(array_flip($ids), $count_night);
            $model = new TourBooking();
            $booking_total = 0;
            foreach ($rooms as $room) {
                $booking_total += $room['total_price'];
            }
            if (isset($_POST['TourBooking']['finish']) && $_POST['TourBooking']['finish']) {
                // lưu vào bảng booking
                $tour_booking = $_POST['TourBooking'];
                $model->name = $tour_booking['name'];
                $model->province_id = $tour_booking['province_id'];
                $model->address = $tour_booking['address'];
                $model->phone = $tour_booking['phone'];
                $model->email = $tour_booking['email'];
                $model->checking_in = $tour_booking['checking_in'];
                $model->checking_out = $tour_booking['checking_out'];
                $model->ip_address = $_SERVER['REMOTE_ADDR']; // ip của người đặt phòng
                $model->booking_total = $booking_total;
                if ($model->checking_in && $model->checking_in != '' && (int) strtotime($model->checking_in)) {
                    $model->checking_in = (int) strtotime($model->checking_in);
                }
                if ($model->checking_out && $model->checking_out != '' && (int) strtotime($model->checking_out)) {
                    $model->checking_out = (int) strtotime($model->checking_out);
                }
                $model->type = TourBooking::TYPE_BOOKING_ROOM;
                if ($model->save()) {
                    // lưu vào bảng tour_booking_room chi tiết từng phòng trong đơn đặt phòng
                    if (count($rooms)) {
                        foreach ($rooms as $room) {
                            $model_room = new TourBookingRoom();
                            $model_room->booking_id = $model->booking_id;
                            $model_room->hotel_id = $tour_booking['hotel_id'];
                            $model_room->room_id = $room['id'];
                            $model_room->room_qty = $room['qty'];
                            $model_room->room_price = $room['price'];
                            $model_room->save();
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
                    Yii::app()->user->setFlash('success', Yii::t('tour_booking', 'booking_room_success'));
                    $this->redirect(Yii::app()->request->url);
                }
            }
        }
        $this->render('booking_room', array(
            'model' => $model,
            'hotel' => $hotel,
            'checking_in' => $checking_in,
            'checking_out' => $checking_out,
            'rooms' => $rooms,
            'listprovince' => $listprovince
        ));
    }

    /**
     * Đặt tour
     */
    public function actionBookingTour() {
        if (isset($_POST['TourBooking']) && $_POST['TourBooking']) {
            $listprovince = LibProvinces::getListProvinceArr();
            $tour = Tour::model()->findByPk($_POST['TourBooking']['tour_id']);
            $category = TourCategories::model()->findByPk($tour->tour_category_id);
            $model = new TourBooking();
            $qty = $_POST['TourBooking']['qty'];
            $booking_total = $tour['price'];
            if (isset($_POST['TourBooking']['finish']) && $_POST['TourBooking']['finish']) {
                // lưu vào bảng booking
                $tour_booking = $_POST['TourBooking'];
                $model->name = $tour_booking['name'];
                $model->province_id = $tour_booking['province_id'];
                $model->address = $tour_booking['address'];
                $model->phone = $tour_booking['phone'];
                $model->email = $tour_booking['email'];
                $model->departure_date = $tour_booking['departure_date'];
                if ($model->departure_date && $model->departure_date != '' && (int) strtotime($model->departure_date)) {
                    $model->departure_date = (int) strtotime($model->departure_date);
                }
                $model->ip_address = $_SERVER['REMOTE_ADDR']; // ip của người đặt phòng
                $model->type = TourBooking::TYPE_BOOKING_TOUR;
                $model->booking_total = $booking_total;
                if ($model->save()) {
                    // lưu vào bảng tour_booking_room chi tiết từng phòng trong đơn đặt phòng
                    $model_tour = new TourBookingTour();
                    $model_tour->booking_id = $model->booking_id;
                    $model_tour->tour_id = $tour_booking['tour_id'];
                    $model_tour->tour_qty = $tour_booking['qty'];
                    $model_tour->tour_price = $tour['price'];
                    $model_tour->save();
                    // send mail
                    $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                        'mail_key' => 'booking_tour_notice',
                        'user_email' => $tour_booking['email'],
                        'user_phone' => $tour_booking['phone'],
                        'user_note' => $tour_booking['note'],
                        'user_name' => $tour_booking['name'],
                        'tour_name' => $tour->name,
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
                            Yii::app()->mailer->send('', Yii::app()->siteinfo['admin_email'], $subject, $content);
                            //$mailer->send($from, $email, $subject, $message);
                        }
                    }
                    // end send mail
                    Yii::app()->user->setFlash('success', Yii::t('tour_booking', 'booking_tour_success'));
                    $this->redirect(Yii::app()->request->url);
                }
            }
        }
        $this->render('booking_tour', array(
            'model' => $model,
            'tour' => $tour,
            'qty' => $qty,
            'listprovince' => $listprovince,
            'category' => $category
        ));
    }

    /**
     * Đặt tour
     */
    public function actionBookingTourNew($tour_id)
    {
        $tour = Tour::model()->findByPk($tour_id);
        if (!isset($_POST['TourBooking']['qty'])) {
            $qty = 1;
        }
        if ($tour) {
            $category = TourCategories::model()->findByPk($tour->tour_category_id);
            $model = new TourBooking();

            $booking_total = $tour->price;
            if (isset($_POST['TourBooking']) && $_POST['TourBooking']) {
                $tour_booking = $_POST['TourBooking'];
                $tour_booking['tour_id'] = $tour_id;
                // lưu vào bảng booking
                $model->name = $tour_booking['name'];
                $model->province_id = $tour_booking['province_id'];
                $model->address = $tour_booking['address'];
                $model->phone = $tour_booking['phone'];
                $model->email = $tour_booking['email'];
                $model->departure_date = $tour_booking['departure_date'];
                if ($model->departure_date && $model->departure_date != '' && (int)strtotime($model->departure_date)) {
                    $model->departure_date = (int)strtotime($model->departure_date);
                }
                $model->ip_address = $_SERVER['REMOTE_ADDR']; // ip của người đặt phòng
                $model->type = TourBooking::TYPE_BOOKING_TOUR;
                $model->booking_total = $booking_total;
                if ($model->save()) {
                    // lưu vào bảng tour_booking_room chi tiết từng phòng trong đơn đặt phòng
                    $model_tour = new TourBookingTour();
                    $model_tour->booking_id = $model->booking_id;
                    $model_tour->tour_id = $tour_booking['tour_id'];
                    $model_tour->tour_qty = $tour_booking['qty'];
                    $model_tour->tour_price = $tour['price'];
                    $model_tour->save();
                    // send mail
                    $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                        'mail_key' => 'booking_tour_notice',
                        'user_email' => $tour_booking['email'],
                        'user_phone' => $tour_booking['phone'],
                        'user_note' => $tour_booking['note'],
                        'user_name' => $tour_booking['name'],
                        'tour_name' => $tour->name,
                    ));
                    if ($mailSetting) {
                        $data = array(
                            'user_name' => $model->name,
                            'link' =>  '<a href="' . Yii::app()->createAbsoluteUrl('quantri/tour/booking/indextour') . '">Link</a>',
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
                    // end send mail
                    Yii::app()->user->setFlash('success', Yii::t('tour_booking', 'booking_tour_success'));
                    $this->redirect(Yii::app()->createUrl("/tour/booking/bookingcomplete",array('id'=>$model->booking_id)));
                }else{
                    echo "<pre>";
                    print_r($model->getErrors());
                    echo "</pre>";
                    die();
                }
            }
            $this->render('booking_tour', array(
                'model' => $model,
                'tour' => $tour,
                'qty' => $qty,
                'category' => $category
            ));
        }
    }

    /**
     * action validate booking
     */
    public function actionValidate() {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new TourBooking;
            $model->unsetAttributes();
            if (isset($_POST['TourBooking'])) {
                $model->attributes = $_POST['TourBooking'];
                if ($model->name && !$model->alias)
                    $model->alias = HtmlFormat::parseToAlias($model->name);
                $model->processPrice();
            }
            if ($model->validate()) {
                $this->jsonResponse(200);
            } else {
                $this->jsonResponse(400, array(
                    'errors' => $model->getJsonErrors(),
                ));
            }
        }
    }

    public function actionBookingcomplete() {
        $id = Yii::app()->request->getParam('id');
        if ($id) {
            $model = TourBooking::model()->findByPk($id);
            $tours = TourBookingTour::getToursDetailInBooking($id);
            $this->render('booking_tour_complete', array(
                'model' => $model,
                'tours' => $tours,
            ));
        }
    }

    public function actionBookingtrack() {
        $id = Yii::app()->request->getParam('id');
        if ($id) {
            $model = TourBooking::model()->findByPk($id);
            $tours = TourBookingTour::getToursDetailInBooking($id);

            $this->render('booking_track', array(
                'model' => $model,
                'tours' => $tours,
            ));
        }
    }

    public function actionBookingList() {
        $listTours = Tour::getOptionsTours();
        if (isset($_GET['id']) && $_GET['id']) {
            $tour_id = (int) $_GET['id'];
            $tour = Tour::model()->findByPk($tour_id);
            if($tour){
                $this->redirect(Yii::app()->createUrl('tour/booking/bookingTourNew', array('tour_id' => $tour->id)));
            }
        }
        $this->render('booking_list', array(
            'listTours' => $listTours,
        ));
    }

}
