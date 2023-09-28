<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('sms', 'payment'); ?>
        </h4>        
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">                                       
                    <div class="control-group form-group">
                        <p style="margin: 10px;">
                        <ul>
                            <li><a href="<?php echo Yii::app()->createUrl('sms/smsPayment/tranfer')?>" title="Nạp tiền bằng chuyển khoản trực tiếp" >Nạp tiền bằng chuyển khoản trực tiếp </a> </li>
                            <li><a href="<?php echo Yii::app()->createUrl('sms/smsPayment/online')?>" title="Nạp tiền bằng Thanh toán online" >Nạp tiền bằng Thanh toán online </a> </li>
                            <li><a href="<?php echo Yii::app()->createUrl('sms/smsPayment/baokim')?>" title="Nạp tiền bằng Tiền Bảo Kim" >Nạp tiền bằng Tiền Bảo Kim </a> </li>
                        </ul>
                        </p>
                    </div>                                        
                </div>
            </div>
        </div>
    </div>
</div>