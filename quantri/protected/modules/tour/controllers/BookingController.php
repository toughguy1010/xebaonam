<?php

class BookingController extends BackController
{

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdateRoom($id)
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('tour_booking', 'booking_room_manager') => Yii::app()->createUrl('/tour/booking/indexroom'),
            Yii::t('tour_booking', 'booking_room_update') => Yii::app()->createUrl('/tour/booking/updateRoom', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);
        if ($model->site_id != $this->site_id) {
            $this->sendResponse(404);
        }
        //
        $rooms = TourBookingRoom::getRoomsDetailInBooking($id);
        //
        if (isset($_POST['TourBooking'])) {
            $model->status = $_POST['TourBooking']['status'];
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl('tour/booking/indexroom'));
            }
        }
        $this->render('update_room', array(
            'model' => $model,
            'rooms' => $rooms,
        ));
    }


    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdateTour($id)
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('tour_booking', 'booking_tour_manager') => Yii::app()->createUrl('/tour/booking/indextour'),
            Yii::t('tour_booking', 'booking_tour_update') => Yii::app()->createUrl('/tour/booking/updateTour', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);
        if ($model->site_id != $this->site_id) {
            $this->sendResponse(404);
        }
        //
        $tours = TourBookingTour::getToursDetailInBooking($id);
        //
        if (isset($_POST['TourBooking'])) {
            $model->status = $_POST['TourBooking']['status'];
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl('tour/booking/indextour'));
            }
        }
        $this->render('update_tour', array(
            'model' => $model,
            'tours' => $tours,
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
    public function actionIndexroom()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('tour_booking', 'booking_room_manager') => Yii::app()->createUrl('/tour/booking/indexroom'),
        );
        //
        $model = new TourBooking('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TourBooking'])) {
            $model->attributes = $_GET['TourBooking'];
        }
        $model->type = TourBooking::TYPE_BOOKING_ROOM;
        $model->site_id = Yii::app()->controller->site_id;

        $this->render('index_room', array(
            'model' => $model,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndextour()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('tour_booking', 'booking_tour_manager') => Yii::app()->createUrl('/tour/booking/indextour'),
        );
        //
        $model = new TourBooking('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TourBooking'])) {
            $model->attributes = $_GET['TourBooking'];
        }
        $model->type = TourBooking::TYPE_BOOKING_TOUR;
        $model->site_id = Yii::app()->controller->site_id;

        $this->render('index_tour', array(
            'model' => $model,
        ));
    }

    /**
     * quangTS
     * export order to csv
     */
    public function actionExportcsv()
    {
        $arrFields = array('Khách hàng', 'Số điện thoại', 'Email', 'Địa chỉ', 'Số hộ chiếu', 'Số máy bay', 'Kiểu tour', 'Hạng khách sạn', 'Địa điểm muốn đến', 'Số lượng người lớn', 'Số lượng trẻ em', 'Tổng chi phí');
        $string = implode("\t", $arrFields) . "\n";

//        $orders = Yii::app()->db->createCommand()
//            ->select('t.billing_name, t.billing_phone, t.billing_email, t.created_time, t.order_status, t.payment_method, r.product_qty, r.product_price, p.name, p.code')
//            ->from('orders t')
//            ->join('order_products r', 'r.order_id = t.order_id')
//            ->join('product p', 'p.id = r.product_id')
//            ->where('t.site_id=:site_id', array(':site_id' => Yii::app()->controller->site_id))
//            ->order('t.order_id DESC')
//            ->queryAll();
        $bookings = Yii::app()->db->createCommand()
            ->select('name, phone, email, address, passport, flight_number, tour_style, star_rating, places_to_visit, adults, children, booking_total')
            ->from('tour_booking')
            ->where('site_id=:site_id', array(':site_id' => Yii::app()->controller->site_id))
            ->order('booking_id DESC')
            ->queryAll();
        foreach ($bookings as $booking) {
            $places_to_visit_id = explode(" ", $booking['places_to_visit']);
            $i = 0;
            $places_to_visit1 = "";
            foreach ($places_to_visit_id as $value) {
                $i++;
                $places_to_visit = TourTouristDestinations::model()->findByPk($value);
                $places_to_visit1 .= $places_to_visit['name'] . " ";
            }
            $star_rating = TourHotelGroup::model()->findByPk($booking['star_rating'])['name'];
            $tour_style = TourStyle::model()->findByPk($booking['tour_style'])['name'];
            $arr = array(
                $booking['name'],
                $booking['phone'],
                $booking['email'],
                $booking['address'],
                $booking['passport'],
                $booking['flight_number'],
                $tour_style,
                $star_rating.' sao',
                $places_to_visit1,
                $booking['adults'],
                $booking['children'],
                $booking['booking_total'],
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

        $string = chr(255) . chr(254) . mb_convert_encoding($string, 'UTF-8', 'UTF-8');


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
        $model = TourBooking::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
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
