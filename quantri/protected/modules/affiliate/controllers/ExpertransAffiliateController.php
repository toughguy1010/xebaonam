<?php

/**
 * @author hungtm <hungtm.0712@gmail.com>
 */
class ExpertransAffiliateController extends BackController
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/main';

    /**
     * Lists all models.
     */
    public function actionUsers()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('affiliate', 'manager_users') => Yii::app()->createUrl('affiliate/expertransAffiliate/users'),
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
    public function actionAffLink($user_id)
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('affiliate', 'manager_users') => Yii::app()->createUrl('affiliate/expertransAffiliate/users'),
        );
        //
        $this->breadcrumbs = array(
            Yii::t('user', 'manager_user') => Yii::app()->createUrl('content/users'),
        );
        $model = new AffiliateLink('search');
        $model->unsetAttributes();
        $model->site_id = $this->site_id;
        $model->user_id = $user_id;
        //
        $this->render('afflink', array(
            'model' => $model,
        ));
    }

    public function actionUpdateUser($id)
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('affiliate', 'manager_users') => Yii::app()->createUrl('affiliate/expertransAffiliate/users'),
            Yii::t('affiliate', 'user_update') => Yii::app()->createUrl('affiliate/expertransAffiliate/updateUser', array('id' => $id)),
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

    public function actionViewUser($id)
    {
        //
        $user = $this->loadModelUser($id);
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('affiliate', 'manager_users') => Yii::app()->createUrl('affiliate/expertransAffiliate/users'),
            $user->name => Yii::app()->createUrl('affiliate/expertransAffiliate/viewUser', array('id' => $id)),
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
        //
        // get date ranges
        list($sd, $sm, $sy) = explode('-', $start_date);
        list($ed, $em, $ey) = explode('-', $end_date);
        $stemp = implode('-', [$sy, $sm, $sd]);
        $etemp = implode('-', [$ey, $em, $ed]);
        $dateRanges = ClaDateTime::date_range($stemp, $etemp, '+1 day', 'd-m-Y');


        $user_id = $id;
        // Số click
        $clickCount = AffiliateClick::countClick($user_id, $options);
        // Đơn hàng chờ
        $options['type'] = AffiliateOrder::TYPE_TRANSLATE;
        $orderWaitingCount = AffiliateOrder::countOrderExpertrans(TranslateOrder::ORDER_WAITFORPROCESS, $user_id, $options);
        // Đơn hàng hoàn thành
        $orderCompleteCount = AffiliateOrder::countOrderExpertrans(TranslateOrder::ORDER_COMPLETE, $user_id, $options);
        // Đơn hàng hủy
        $orderDestroyCount = AffiliateOrder::countOrderExpertrans(TranslateOrder::ORDER_DESTROY, $user_id, $options);
        //

        $options['type'] = AffiliateOrder::TYPE_BPO;
        $orderBpoWaitingCount = AffiliateOrder::countOrderExpertrans(BpoForm::ORDER_WAITFORPROCESS, $user_id, $options);
        // Đơn hàng hoàn thành
        $orderBpoCompleteCount = AffiliateOrder::countOrderExpertrans(BpoForm::ORDER_COMPLETE, $user_id, $options);
        // Đơn hàng hủy
        $orderBpoDestroyCount = AffiliateOrder::countOrderExpertrans(BpoForm::ORDER_COMPLETE, $user_id, $options);

        $options['type'] = AffiliateOrder::TYPE_CONTACT;
        $orderContactWaitingCount = AffiliateOrder::countOrderExpertrans(ExpertransContactFormModel::STATUS_WAITING, $user_id, $options);
        // Đơn hàng hoàn thành
        $orderContactCompleteCount = AffiliateOrder::countOrderExpertrans(ExpertransContactFormModel::STATUS_ACTIVED, $user_id, $options);
        // Đơn hàng hủy
        $orderContactDestroyCount = AffiliateOrder::countOrderExpertrans(ExpertransContactFormModel::STATUS_DEACTIVED, $user_id, $options);

        $options['type'] = AffiliateOrder::TYPE_INTERPRETATION;
        $orderInterWaitingCount = AffiliateOrder::countOrderExpertrans(InterpretationOrder::ORDER_WAITFORPROCESS, $user_id, $options);
        // Đơn hàng hoàn thành
        $orderInterCompleteCount = AffiliateOrder::countOrderExpertrans(InterpretationOrder::ORDER_COMPLETE, $user_id, $options);
        // Đơn hàng hủy
        $orderInterDestroyCount = AffiliateOrder::countOrderExpertrans(InterpretationOrder::ORDER_DESTROY, $user_id, $options);


        $rate = ($orderWaitingCount + $orderCompleteCount) / ($clickCount / 100);
        // Get commission order success
        $commission = AffiliateOrder::calculatorCommissionExpertrans($user_id, $options);
        //
        $ordertrans = new TranslateOrder();
        $ordertrans->unsetAttributes();
        $ordertrans->affiliate_user = Yii::app()->user->id;
        $ordertrans->site_id = Yii::app()->controller->site_id;
        //
        $bpo = new BpoForm();
        $bpo->unsetAttributes();
        $bpo->affiliate_user = Yii::app()->user->id;
        $bpo->site_id = Yii::app()->controller->site_id;
        //
        $interpretation = new InterpretationOrder();
        $interpretation->unsetAttributes();
        $interpretation->affiliate_user = Yii::app()->user->id;
        $interpretation->site_id = Yii::app()->controller->site_id;
        //
        $intro = new ExpertransContactFormModel();
        $intro->unsetAttributes();
        $intro->affiliate_user = Yii::app()->user->id;
        $intro->site_id = Yii::app()->controller->site_id;
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
            $data[$day]['click']++;
        }
        $dataOrder = AffiliateOrder::getAllOrder($user_id, $options);
        foreach ($dataOrder as $order) {
            $day = date('d-m-Y', $order['created_time']);
            $data[$day]['order']++;
        }

        // Get orders items
        $this->render('view_user', array(
            'clickCount' => $clickCount,
            'orderWaitingCount' => $orderWaitingCount,
            'orderCompleteCount' => $orderCompleteCount,
            'orderDestroyCount' => $orderDestroyCount,
            'orderBpoWaitingCount' => $orderBpoWaitingCount,
            'orderBpoCompleteCount' => $orderBpoCompleteCount,
            'orderBpoDestroyCount' => $orderBpoDestroyCount,
            'orderContactWaitingCount' => $orderContactWaitingCount,
            'orderContactCompleteCount' => $orderContactCompleteCount,
            'orderContactDestroyCount' => $orderContactDestroyCount,
            'orderInterWaitingCount' => $orderInterWaitingCount,
            'orderInterCompleteCount' => $orderInterCompleteCount,
            'orderInterDestroyCount' => $orderInterDestroyCount,
            'rate' => $rate,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'ordertrans' => $ordertrans,
            'commission' => $commission,
            'bpo' => $bpo,
            'interpretation' => $interpretation,
            'intro' => $intro,
            'data' => $data,
        ));
    }

    public function loadModelUser($id)
    {
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
