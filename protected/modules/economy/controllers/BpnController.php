<?php

class BpnController extends PublicController {
    
    public function actionIndex() {        
        
        $req = http_build_query($_POST); 
        
        //Log File
        $logFile = Yii::app()->getBasePath().DS.'runtime'.DS.'bpn.log';                
        if(!file_exists($logFile)){
            $fh = fopen($logFile, 'x') or die("can't create file");
        }else{
            $fh = fopen($logFile, 'a') or die("can't open file");
        }
        //thuc hien  ghi log cac tin nhan BPN
        $reqLog = "\n".date('Y-m-d H:i:s').($_POST?' - Params : '.$req:' - No param'); 
        fwrite($fh, $reqLog);
            
        //Log db
        $modelLog = new LogBpnBaokim();
        $modelLog->attributes = $_POST;
        $modelLog->id = null;        
        try {
            $modelLog->save();
        } catch (Exception $e) {
            fwrite($fh, ' Error Log db : '.$e->message);            
        }
        
        //Veryfy code        
        $url = Yii::app()->params['baokim']['host'].Yii::app()->params['baokim']['url_verify'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);               
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        $result = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $errorCurl = curl_error($ch);
        if ($result != '' && strstr($result, 'VERIFIED') && $status == 200) {
            fwrite($fh, " =>VERIFIED");
            /**
             * Neu co thi update thong tin thanh toan vao
             */
            //update thong tin thanh toan! trang thai transaction_status
            //kiem tra trang thai giao dich
            $transaction_status = $_POST['transaction_status'];
            if ($transaction_status == 4) {
                //thuc hien update hoa don
                $order_id = $_POST['order_id'];
                $transaction_id = $_POST['transaction_id'];
                //Mot so thong tin khach hang khac
                $customer_name = $_POST['customer_name'];
                $customer_email = $_POST['customer_email'];
                $total_amount = $_POST['total_amount'];
                $net_amount = $_POST['net_amount'];
                
                if(is_string($order_id) && substr($order_id, 0, 3) === 'SMS'){                    
                    $order_sms_id = (int)substr($order_id,3);
                    $order = SmsOrder::model()->findByPk($order_sms_id);
                    if ($order) {
                        $order->order_total_paid = (int)$net_amount;                        
                        $order->status = SmsOrder::ORDER_STATUS_PAID;
                        $order->status_money = 1; // tien co the use
                        if($order->save()){
                            // chuyen tien vao trong tk
                            SmsMoney::model()->addMoneyViaOrder($order);
                        }                        
                    } else {
                        fwrite($fh, ' =>SMS No order');
                    }
                }elseif(is_string($order_id) && substr($order_id, 0, 3) === 'PRO'){                       
                    $order_id = (int)substr($order_id,3);
                    $order = Orders::model()->findByPk($order_id);                    
                    if ($order) {
                        $order->order_total_paid = (float)$net_amount;                    
                        $order->payment_status = Orders::ORDER_PAYMENT_STATUS_PAID;
                        $order->save();
                    } else {
                        fwrite($fh, ' =>Pro No order');
                    }
                }else{
                    fwrite($fh, " => NOT found Order");
                }
                fwrite($fh, " =>COMPLETE\n");
            }
        } else {
            fwrite($fh, " =>INVALID");
        }
        if ($errorCurl) {
            fwrite($fh, ' - Error Curl : '.$errorCurl);
        }
        fclose($fh);
        curl_close($ch);
    }
}