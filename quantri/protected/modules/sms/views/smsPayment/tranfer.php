<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('sms', 'payment').' - '.Yii::t('sms', 'payment_tranfer_direct'); ?>
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
                        <?php echo $form->labelEx($model,'bank_code', array('class' =>'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-4">
                            <div class="input-group">
                                <?php echo $form->dropDownList($model,'bank_code', $bank_option, array('empty'=>'-- Chọn Ngân hàng --','class' => 'span10 col-sm-12','id'=>'bank_tranfer')); ?>                                
                                <?php echo $form->error($model, 'bank_code'); ?>
                            </div>                            
                        </div>
                        <div class="controls col-sm-6 infor_bank" style="display:none;">
                            <p><strong>Tài khoản nhận tiền của nanoweb</strong></p>
                            <p><span class="recive_logo"></span></p>
                            <p><span>Số tài khoản : </span><span class="recive_account" style="font-weight: bold;"></span></p>
                            <p><span>Chủ Tài khoản : </span><span class="recive_owner" style="font-weight: bold;"></span></p>                                          
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model,'order_total', array('class' =>'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-4">
                            <?php echo $form->textField($model, 'order_total', array('class' => 'numberFormat span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'order_total'); ?>
                        </div>                        
                    </div>  
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model,'bank_source_account', array('class' =>'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-4">
                            <?php echo $form->textField($model, 'bank_source_account', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'bank_source_account'); ?>
                        </div>                        
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model,'bank_source_owner', array('class' =>'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-4">
                            <?php echo $form->textField($model, 'bank_source_owner', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'bank_source_owner'); ?>
                        </div>                        
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model,'bank_source_time', array('class' =>'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-4">
                            <?php echo $form->textField($model, 'bank_source_time', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'bank_source_time'); ?>
                        </div>                        
                    </div>
                    <div class="control-group form-group buttons">
                        <div class="controls col-sm-2"></div>
                        <div class="controls col-sm-4">
                            <?php echo CHtml::submitButton(Yii::t('sms', 'send_notice'), array('class' => 'btn btn-primary', 'id' => 'btnAddCate','style'=>'padding:0 10px;')); ?>                            
                        </div>
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
    var bank_list = <?php echo json_encode($bank_list); ?>;
    jQuery(document).ready(function() {
        jQuery('#bank_tranfer').on('change',function(){
            if(jQuery('#bank_tranfer').val()){                
                var key = jQuery('#bank_tranfer').val();
                jQuery('.recive_logo').html('<img src="'+bank_list[key].logo+'" width="100"/>');
                jQuery('.recive_account').html(bank_list[key].account);
                jQuery('.recive_owner').html(bank_list[key].owner);
                jQuery('.infor_bank').show();
            }else{
                jQuery('.infor_bank').hide();
            }
        });
        jQuery('#sms-payment-form').on('submit',function(){
            if(!jQuery('#bank_tranfer').val()){
                alert("Vui lòng chọn ngân hàng");
                return false;
            }
        });
    });   
</script>