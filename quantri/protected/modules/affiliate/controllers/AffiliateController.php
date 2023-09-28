<?php

/**
 * @author hungtm <hungtm.0712@gmail.com>
 */
class AffiliateController extends BackController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/main';

    /**
     * Lists all models.
     */
    public function actionUsers() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('affiliate', 'manager_users') => Yii::app()->createUrl('affiliate/affiliate/users'),
        );
        //
        $this->breadcrumbs = array(
            Yii::t('user', 'manager_user') => Yii::app()->createUrl('content/users'),
        );
        $model = new Users('search');
        $model->unsetAttributes();
        //
        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionAffLink($id) {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('affiliate', 'manager_users') => Yii::app()->createUrl('affiliate/affiliate/users'),
        );
        //
        $this->breadcrumbs = array(
            Yii::t('user', 'manager_user') => Yii::app()->createUrl('content/users'),
        );
        $model = AffiliateLink::model()->findAllByAttributes(array('site_id' => $this->site_id));
        //
        $this->render('afflink', array(
            'model' => $model,
        ));
    }

    public function actionUpdateUser($id) {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('affiliate', 'manager_users') => Yii::app()->createUrl('affiliate/affiliate/users'),
            Yii::t('affiliate', 'user_update') => Yii::app()->createUrl('affiliate/affiliate/updateUser', array('id' => $id)),
        );
        //
        $model = $this->loadModelUser($id);
        //
        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            $user_introduce = Users::model()->findByAttributes(array(
                'site_id' => $this->site_id,
                'phone' => $model->phone_introduce,
            ));
            $model->user_introduce_id = $user_introduce->user_id;
            if ($model->save()) {
                $this->redirect(array('indexNormal'));
            }
        }

        $listprivince = LibProvinces::getListProvinceArr();
        if (!$model->province_id) {
            $first = array_keys($listprivince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $model->province_id = $firstpro;
        }
        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }

        $this->render('update_user', array(
            'model' => $model,
            'listprivince' => $listprivince,
            'listdistrict' => $listdistrict,
        ));
    }

    public function actionViewUser($id) {
        //
        $user = $this->loadModelUser($id);
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('affiliate', 'manager_users') => Yii::app()->createUrl('affiliate/affiliate/users'),
            $user->name => Yii::app()->createUrl('affiliate/affiliate/viewUser', array('id' => $id)),
        );
        //
        $options = [];
        $start_date = Yii::app()->request->getParam('start_date');
        $end_date = Yii::app()->request->getParam('end_date');
        //
        if ($start_date === NULL) {
            $start_date = date('d-m-Y', strtotime('-30 days'));
        }
        $options['start_date'] = $start_date;
        //
        if ($end_date === NULL) {
            $end_date = date('d-m-Y');
        }
        $options['end_date'] = $end_date;
        // get date ranges
        list($sd, $sm, $sy) = explode('-', $start_date);
        list($ed, $em, $ey) = explode('-', $end_date);
        $stemp = implode('-', [$sy, $sm, $sd]);
        $etemp = implode('-', [$ey, $em, $ed]);
        $dateRanges = ClaDateTime::date_range($stemp, $etemp, '+1 day', 'd-m-Y');
        //
        $user_id = $id;
        // Số click
        $clickCount = AffiliateClick::countClick($user_id, $options);
        // Đơn hàng chờ
        $orderWaitingCount = AffiliateOrder::countOrder(Orders::ORDER_WAITFORPROCESS, $user_id, $options);
        // Đơn hàng hoàn thành
        $orderCompleteCount = AffiliateOrder::countOrder(Orders::ORDER_COMPLETE, $user_id, $options);
        // Tỷ lệ đơn hàng / click
        $rate = ($orderWaitingCount + $orderCompleteCount) / ($clickCount / 100);
        // Data for chart
        $data = [];
        foreach ($dateRanges as $date) {
            $data[$date]['click'] = 0;
            $data[$date]['order'] = 0;
        }
        //
        $dataClick = AffiliateClick::getClick($user_id, $options);
        foreach ($dataClick as $click) {
            $day = date('d-m-Y', $click['created_time']);
            $data[$day]['click'] ++;
        }
        $dataOrder = AffiliateOrder::getAllOrder($user_id, $options);
        foreach ($dataOrder as $order) {
            $day = date('d-m-Y', $order['created_time']);
            $data[$day]['order'] ++;
        }
        // Get commission order success
        $order_items = AffiliateOrderItems::getAllOrderItem($user_id, $options);
        $commission = AffiliateOrderItems::calculatorCommission($order_items);
        //
        $this->render('view_user', [
            'user' => $user,
            'clickCount' => $clickCount,
            'orderWaitingCount' => $orderWaitingCount,
            'orderCompleteCount' => $orderCompleteCount,
            'rate' => $rate,
            'data' => $data,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'commission' => $commission
        ]);
    }

    public function loadModelUser($id) {
        //
        $user = Users::model()->findByPk($id);
        //
        if ($user === NULL) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if ($user->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $user;
    }

}
