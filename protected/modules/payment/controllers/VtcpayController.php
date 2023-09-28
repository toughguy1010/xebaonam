<?php

class VtcpayController extends PublicController {

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionReceive($id) {
        $this->render('receive', array(
        ));
    }
    
    public function actionPayment() {
        $config = SitePayment::getPaymentType(SitePayment::TYPE_VTCPAY);
        $this->render('payment', array(
            'config' => $config
        ));
    }

}
