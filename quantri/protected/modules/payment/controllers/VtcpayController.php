<?php

class VtcpayController extends BackController {

    public function actionPullstatus() {
        if (Yii::app()->request->isAjaxRequest) {
            $order_id = Yii::app()->request->getParam('order_id', 0);
            if ($order_id) {
                $config = SitePayment::getPaymentType(SitePayment::TYPE_VTCPAY);
                $data = LogVtcpay::model()->findByPk($order_id);
                $website_id = $data->website_id;
                $order_code = $data->order_code;
                $receiver_acc = $config->receive_account;
                $sign = $data->sign;
                //
                $fields = array(
                    'website_id' => urlencode($website_id),
                    'order_code' => urlencode($order_code),
                    'receiver_acc' => urlencode($receiver_acc),
                    'sign' => urlencode($sign),
                );
                //url-ify the data for the POST
                foreach ($fields as $key => $value) {
                    $fields_string .= $key . '=' . $value . '&';
                }
                rtrim($fields_string, '&');
                //
                $ch = curl_init();
                //set the url, number of POST vars, POST data
                curl_setopt($ch, CURLOPT_URL, 'http://sandbox1.vtcebank.vn/pay.vtc.vn/gate/WSCheckTrans.asmx');
                curl_setopt($ch, CURLOPT_POST, count($fields));
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
                //execute post
                $result = curl_exec($ch);
                //close connection
                curl_close($ch);
                $this->jsonResponse(200, array(
                    'result' => $result
                ));
            }
        }
    }

}
