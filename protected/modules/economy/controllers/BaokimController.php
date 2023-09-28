<?php

class BaokimController extends PublicController {
    
    public function actionSuccess() {        
        BaokimHelper::helper()->logFileResponse($_GET,'baokim_success.log');
        $config = SitePayment::model()->getConfigPayment('baokim');
        if($config){
            BaokimHelper::helper()->mergeConfig($config);
        }
        $type = (isset($_GET['order_id']) && is_string($_GET['order_id']))?substr($_GET['order_id'],0,3):'';        
        $order_id = (isset($_GET['order_id']) && is_string($_GET['order_id']))?(int)substr($_GET['order_id'],3):0;
        if($type == 'SMS'){                        
            if(BaokimHelper::helper()->verifyResponseUrl($_GET)){                
                if(isset($_GET['transaction_status']) && $_GET['transaction_status'] == 4){                    
                    $model = SmsOrder::model()->findByPk($order_id);
                    if($model){
                        $model->status = SmsOrder::ORDER_STATUS_PAID;
                        $model->save();
                    }
                    $this->redirect(Yii::app()->createUrl('quantri/sms/smsPayment/success',array('order_id'=>$order_id)));
                }                      
            }else{
                $this->redirect(Yii::app()->createUrl('quantri/sms/smsPayment/notverify'));
            }
        }elseif($type == 'TOU'){
            if(BaokimHelper::helper()->verifyResponseUrl($_GET)){                
                if(isset($_GET['transaction_status']) && $_GET['transaction_status'] == 4){                    
                    $model = TourBooking::model()->findByPk($order_id);
                    if($model){
                        $model->status_payment = TourBooking::STATUS_SUCCESS_PAYMENT;
                        $model->save();
                    }
                    $this->redirect(Yii::app()->createUrl('tour/bookRoom/success',array('order_id'=>$order_id)));
                }                      
            }else{
                $this->redirect(Yii::app()->createUrl('tour/bookRoom/create'));
            }
        }else {
            if(BaokimHelper::helper()->verifyResponseUrl($_GET)){                
                if(isset($_GET['transaction_status']) && $_GET['transaction_status'] == 4){                    
                   $key = Yii::app()->request->getParam('key');                   
                   $url_redirect = Yii::app()->createUrl('/economy/shoppingcart/order',array('id'=>$order_id,'key'=>$key));
                   $this->redirect($url_redirect);                    
                }                      
            }else{
                $this->redirect(Yii::app()->getBaseUrl(true));
            }            
        } 
        echo "Success Not Complete"; 
        Yii::app()->end();
    }
    public function actionCancel() {        
        echo "Cancel";
        BaokimHelper::helper()->logFileResponse($_GET,'baokim_cancel.log');
        Yii::app()->end();
    }
}