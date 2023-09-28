<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('sms', 'payment').' - '.Yii::t('sms', 'payment_online'); ?>
        </h4>        
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'sms-payment-form',
                        'htmlOptions' => array('class' => 'form-horizontal'),
                        'enableAjaxValidation' => false,
                    ));
                    ?>                                        
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model,'order_total', array('class' =>'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-3">
                            <?php echo $form->textField($model, 'order_total', array('class' => 'numberFormat span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'order_total'); ?>
                        </div>
                        <div class="controls col-sm-3 buttons">
                            <?php echo CHtml::submitButton(Yii::t('sms', 'payment_sms'), array('class' => 'btn btn-primary', 'id' => 'btnAddCate','style'=>'padding:0 10px;')); ?>                            
                        </div>
                    </div>                                        
                    <div class="control-group form-group sms_payment">
                        <?php $this->renderPartial('partial/online_payment_baokim',array('model'=>$model)); ?>                        
                    </div>
                    <?php
                    $this->endWidget();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('#sms-payment-form').on('submit',function(){
            if(payment.method_child == 0){
                alert("Bạn chưa chọn Ngân hàng bạn muốn sử dụng thanh toán");
                return false;
            }
        });
    });        
</script>