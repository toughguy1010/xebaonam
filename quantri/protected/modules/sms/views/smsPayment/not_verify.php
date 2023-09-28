<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('sms', 'payment_sms_not_verify'); ?>
        </h4>        
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">                                       
                    <div class="control-group form-group">
                        <p style="margin:10px;">
                            Xác thực thanh toán không thành không! Vui lòng thực hiện lại <a href="<?php echo $this->createUrl('index');?>"> Nạp tiền </a>                          
                        </p>
                    </div>                                        
                </div>
            </div>
        </div>
    </div>
</div>