<?php

class ExpertransAffiliateController extends PublicController {

    public $layout = '//layouts/affiliate';

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionIndex() {
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
        $user_id = Yii::app()->user->id;
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
//        $order_items = AffiliateOrderItems::getAllOrderItem($user_id, $options);
        $commission = AffiliateOrder::calculatorCommissionExpertrans($user_id, $options);
        //
        $this->render('index', array(
            'clickCount' => $clickCount,
            'orderWaitingCount' => $orderWaitingCount,
            'orderCompleteCount' => $orderCompleteCount,
            'rate' => $rate,
            'data' => $data,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'commission' => $commission
        ));
    }

    /**
     * Report Order
     */
    public function actionReportOrder() {
        $user_id = Yii::app()->user->id;
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
        $clickCount = AffiliateClick::countClick($user_id);
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

        // Get orders items
        $this->render('report_order', array(
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
        ));
    }

    public function actionExportReportOrder() {
        $user_id = Yii::app()->user->id;
        $options = [];
        //
        $orderItems = AffiliateOrderItems::getAllOrderItem($user_id, $options);

        $arrFields = array('STT', 'Thời gian', 'Thời gian Click', 'Trạng thái', 'Giá', 'Số lượng', 'Hoa hồng');
        $string = implode("\t", $arrFields) . "\n";
        //
        foreach ($orderItems as $item) {
            $arr = array(
                $item['id'],
                date('d-m-Y H:i', $item['created_time']),
                date('d-m-Y H:i', $item['click_time']),
                AffiliateOrder::getOrderStatusName($item['order_status']),
                $item['product_price'],
                $item['product_qty'],
                $item['commission'],
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
        $string = chr(255) . chr(254) . mb_convert_encoding($string, 'UTF-16LE', 'UTF-8');
        echo $string;
    }

    public function actionPaymentInfo() {
        $model = AffiliatePaymentInfo::model()->findByPk(Yii::app()->user->id);
        if ($model === NULL) {
            $model = new AffiliatePaymentInfo();
            $model->user_id = Yii::app()->user->id;
        }
        //
        if (isset($_POST['AffiliatePaymentInfo'])) {

            //
            $model->attributes = $_POST['AffiliatePaymentInfo'];
            //
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('status', 'update_success'));
            }
        }
        //
        $this->render('payment_info', [
            'model' => $model
        ]);
    }

    public function actionOrderTransferMoney() {
        $user_id = Yii::app()->user->id;
        //
        $config = AffiliateConfig::model()->findByPk(Yii::app()->controller->site_id);
        // Get commission order success
        $commission = AffiliateOrder::calculatorCommissionExpertrans($user_id);
        //
        $total_money_complete = $commission[Orders::ORDER_COMPLETE];
        $money_transfered = AffiliateTransferMoney::getTotalMoneyKeep(AffiliateTransferMoney::STATUS_TRANSFERED);
        $money_waiting = AffiliateTransferMoney::getTotalMoneyKeep(AffiliateTransferMoney::STATUS_WAITING);
        //
        $model = new AffiliateTransferMoney();
        if (isset($_POST['AffiliateTransferMoney']) && $_POST['AffiliateTransferMoney']) {
            $model->attributes = $_POST['AffiliateTransferMoney'];
            $model->user_id = $user_id;
            if ($model->money < $config['min_price']) {
                $model->addError('money', 'Số tiền phải lớn hơn ' . $config['min_price']);
            }
            $money_real = $total_money_complete - ($money_transfered + $money_waiting);
            if ($model->money > $money_real) {
                $model->addError('money', 'Số tiền phải nhỏ hơn ' . $money_real);
            }
            if (!$model->getErrors()) {
                if ($model->save()) {
                    $this->redirect(array('listTransferMoney'));
                }
            }
        }
        //
        $this->render('transfer_money', [
            'config' => $config,
            'commission' => $commission,
            'model' => $model,
            'money_transfered' => $money_transfered,
            'money_waiting' => $money_waiting
        ]);
    }

    public function actionListTransferMoney() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('affiliate', 'manager_affiliate') => Yii::app()->createUrl('/affiliate/hpFaculty'),
        );
        $user_id = Yii::app()->user->id;
        $model = new AffiliateTransferMoney();
        $model->site_id = $this->site_id;
        $model->user_id = $user_id;
        //
        $this->render('list_transfer_money', [
            'model' => $model
        ]);
    }

    /**
     * gioi thieu ve trang affiliate
     */
    function actionIntroduce() {
        $this->layoutForAction = '//layouts/affiliate_introduce';
        $this->render('introduce');
    }

    //
    public function beforeAction($action) {
        if (Yii::app()->user->isGuest && $action->id !== 'introduce') {
            $this->redirect(Yii::app()->createUrl('/login/login/login'));
        }
        //
        return parent::beforeAction($action);
    }

    public function actionOverview() {
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
        $user_id = Yii::app()->user->id;
        //
        $dataClick = AffiliateClick::getClick($user_id, $options);
        $dataClickOs = [];
        $dataClickCampaignSource = [];
        $dataClickAffType = [];
        $dataClickCampaignName = [];
        foreach ($dataClick as $item) {
            if (isset($dataClickOs[$item['operating_system']])) {
                $dataClickOs[$item['operating_system']] ++;
            } else {
                $dataClickOs[$item['operating_system']] = 1;
            }
            // nguồn chiến dịch
            if (isset($dataClickCampaignSource[$item['campaign_source']])) {
                $dataClickCampaignSource[$item['campaign_source']] ++;
            } else {
                $dataClickCampaignSource[$item['campaign_source']] = 1;
            }
            // cách tiếp thị
            if (isset($dataClickAffType[$item['aff_type']])) {
                $dataClickAffType[$item['aff_type']] ++;
            } else {
                $dataClickAffType[$item['aff_type']] = 1;
            }
            // Tên chiến dịch
            if (isset($dataClickCampaignName[$item['campaign_name']])) {
                $dataClickCampaignName[$item['campaign_name']] ++;
            } else {
                $dataClickCampaignName[$item['campaign_name']] = 1;
            }
        }
        //
        $dataOrder = AffiliateOrder::getAllOrder($user_id, $options);
        $dataOrderOs = [];
        $dataOrderCampaignSource = [];
        $dataOrderAffType = [];
        $dataOrderCampaignName = [];
        foreach ($dataOrder as $orderItem) {
            if (isset($dataOrderOs[$item['operating_system']])) {
                $dataOrderOs[$item['operating_system']] ++;
            } else {
                $dataOrderOs[$item['operating_system']] = 1;
            }
            // Nguồn chiến dịch
            if (isset($dataOrderCampaignSource[$item['campaign_source']])) {
                $dataOrderCampaignSource[$item['campaign_source']] ++;
            } else {
                $dataOrderCampaignSource[$item['campaign_source']] = 1;
            }
            // Cách tiếp thị
            if (isset($dataOrderAffType[$item['aff_type']])) {
                $dataOrderAffType[$item['aff_type']] ++;
            } else {
                $dataOrderAffType[$item['aff_type']] = 1;
            }
            // Tên chiến dịch
            if (isset($dataOrderCampaignName[$item['campaign_name']])) {
                $dataOrderCampaignName[$item['campaign_name']] ++;
            } else {
                $dataOrderCampaignName[$item['campaign_name']] = 1;
            }
        }
        //
        $this->render('overview', [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'dataClickOs' => $dataClickOs,
            'dataOrderOs' => $dataOrderOs,
            'dataClickCampaignSource' => $dataClickCampaignSource,
            'dataOrderCampaignSource' => $dataOrderCampaignSource,
            'dataClickAffType' => $dataClickAffType,
            'dataOrderAffType' => $dataOrderAffType,
            'dataClickCampaignName' => $dataClickCampaignName,
            'dataOrderCampaignName' => $dataOrderCampaignName,
        ]);
    }

}
