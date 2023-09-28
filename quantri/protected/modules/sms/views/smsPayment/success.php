<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('sms', 'payment_sms_success'); ?>
        </h4>        
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">                                       
                    <div class="control-group form-group">
                        <p style="margin: 10px;">
                            <?php 
                                if($model->payment_method == SmsOrder::PAYMENT_METHOD_TRANFER){
                                    echo "Hệ thống sẽ kiểm tra thông tin và cập nhật tiền vào tài khoản của bạn trong thời gian sớm nhất.";
                                }elseif($model->payment_method == SmsOrder::PAYMENT_METHOD_ONLINE){
                                    echo "Nạp tiền thành công! Hệ thống sẽ cập nhật tài khoản của bạn sau ít phút.";
                                }elseif($model->payment_method == SmsOrder::PAYMENT_METHOD_BAOKIM){
                                    if($model->status == SmsOrder::ORDER_STATUS_PAID){
                                        echo "Nạp tiền thành công! Hệ thống sẽ cập nhật tài khoản của bạn sau ít phút.";
                                    }else{
                                        echo "Đơn hàng đang được xử lý! Vui lòng quay trở lại sau";
                                    }
                                }else{
                                    echo "Đơn hàng đang được xử lý! Vui lòng quay trở lại sau";
                                }
                            ?>
                        </p>
                    </div>                                        
                </div>
            </div>
        </div>
    </div>
</div>