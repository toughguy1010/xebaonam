<?php
class SmsPaymentController extends BackController {
    
    public function actionIndex(){                        
        $this->render('index', array(                
            ));        
    }
    
    public function actionTranfer() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('sms', 'payment_sms') => Yii::app()->createUrl('/sms/smsPayment/index'),
            Yii::t('sms', 'payment_tranfer_direct') => Yii::app()->createUrl('/sms/smsPayment/tranfer'),
        );
        $model = new SmsOrder('tranfer'); 
        $bank_list = SmsOrder::$bank_list;
        $bank_option = array();
            foreach($bank_list as $key=>$value){
                $bank_option[$key] = $value['name'];
            }
        $post = Yii::app()->request->getPost('SmsOrder');
        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            $model->order_total = isset($post['order_total'])?(int)$post['order_total'] : 0;              
            $model->site_id = $this->site_id;
            $model->user_id = Yii::app()->user->id;
            $model->type_user = SmsMoney::TYPE_USER_ADMIN;
            $model->payment_method = SmsOrder::PAYMENT_METHOD_TRANFER; // chuyen khoan truc tiep            
            $model->multitext = ($model->multitext)?CJSON::encode($model->multitext):null;
            $useradmin = UsersAdmin::model()->findByPk(Yii::app()->user->id);            
            if($useradmin){
                $model->billing_name = $useradmin->user_name;
                $model->billing_email = $useradmin->email;                
            }                                    
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl('/sms/smsPayment/success',array('order_id'=>$model->id)));
            }else{
                $model->multitext = ($model->multitext)?CJSON::decode($model->multitext):null;
            }
        }
        
        $this->render('tranfer', array(
            'model' => $model,
            'bank_list' => $bank_list,
            'bank_option' => $bank_option,            
        ));
    }
    
    public function actionOnline() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('sms', 'payment_sms') => Yii::app()->createUrl('/sms/smsPayment/index'),
            Yii::t('sms', 'payment_online') => Yii::app()->createUrl('/sms/smsPayment/online'),
        );
        $model = new SmsOrder();        
        
        $post = Yii::app()->request->getPost('SmsOrder');
        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            $model->order_total = isset($post['order_total'])?(int)$post['order_total'] : 0;              
            $model->site_id = $this->site_id;
            $model->user_id = Yii::app()->user->id;
            $model->type_user = SmsMoney::TYPE_USER_ADMIN;
            $model->payment_method = SmsOrder::PAYMENT_METHOD_ONLINE; // thanh toan atm internet banking            
            $useradmin = UsersAdmin::model()->findByPk(Yii::app()->user->id);
            if($useradmin){
                $model->billing_name = $useradmin->user_name;
                $model->billing_email = $useradmin->email;                
            }                                    
            if ($model->save()) {                
                $payonline = BaokimHelper::helper()->paymentOnline($model,'SMS');
                if(isset($payonline['pmbk_error'])){
                    Yii::app()->user->setFlash('error', "Thanh toán lỗi : ".$payonline['pmbk_error'].". Chúng tôi đã lưu đơn hàng của bạn vào hệ thống. Rất xin lỗi vì sự cố này.");
                }
            }
        }
        $this->render('online', array(
            'model' => $model,
        ));
    }

    public function actionBaokim() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('sms', 'payment_sms') => Yii::app()->createUrl('/sms/smsPayment/index'),
            Yii::t('sms', 'payment_baokim') => Yii::app()->createUrl('/sms/smsPayment/baokim'),
        );
        $model = new SmsOrder();        
        
        $post = Yii::app()->request->getPost('SmsOrder');
        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            $model->order_total = isset($post['order_total'])?(int)$post['order_total'] : 0;              
            $model->site_id = $this->site_id;
            $model->user_id = Yii::app()->user->id;
            $model->type_user = SmsMoney::TYPE_USER_ADMIN;
            $model->payment_method = SmsOrder::PAYMENT_METHOD_BAOKIM; // thanh toan bao kim
            $model->payment_method_child = 'baokim'; // thanh toan bao kim
            $useradmin = UsersAdmin::model()->findByPk(Yii::app()->user->id);
            if($useradmin){
                $model->billing_name = $useradmin->user_name;
                $model->billing_email = $useradmin->email;                
            }                                    
            if ($model->save()) {
                $baokim_url = BaokimHelper::helper()->createRequestUrl($model,'SMS');                
                echo "<script>window.location='".$baokim_url."'</script>";
            }
        }
        $this->render('baokim', array(
            'model' => $model,
        ));
    }        
    
    public function actionSuccess($order_id){
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('sms', 'payment_sms') => Yii::app()->createUrl('/sms/smsPayment/index'),
            Yii::t('sms', 'payment_success') => Yii::app()->createUrl('/sms/smsPayment/success'),
        );
        $model = SmsOrder::model()->findByPk($order_id);        
        if($model && $model->user_id == Yii::app()->user->id){            
            $this->render('success', array(
                'model' => $model,
            ));
        }else{
            Yii::app()->end();
        }        
    }
    
    public function actionNotVerify(){
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('sms', 'payment_sms') => Yii::app()->createUrl('/sms/smsPayment/index'),
            Yii::t('sms', 'payment_not_verify') => Yii::app()->createUrl('/sms/smsPayment/notVerify'),
        );
        $this->render('not_verify', array(            
        ));
    }
}
