<div class="widget widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('affiliate', 'setting_affiliate'); ?>
        </h4>
    </div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'site-settings-form',
                        'htmlOptions' => array('class' => 'form-horizontal'),
                        'enableAjaxValidation' => false,
                    ));
                    ?>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'cookie_expire', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'cookie_expire', array('class' => 'span9 col-sm-12')); ?>
                            <span class="help-inline">
                                <?php echo $form->error($model, 'cookie_expire'); ?>
                            </span>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'commission_order', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'commission_order', array('class' => 'span9 col-sm-12')); ?>
                            <span class="help-inline">
                                <?php echo $form->error($model, 'commission_order'); ?>
                            </span>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'min_price', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'min_price', array('class' => 'span9 col-sm-12')); ?>
                            <span class="help-inline">
                                <?php echo $form->error($model, 'min_price'); ?>
                            </span>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'change_phone', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <label>
                                <?php echo $form->checkBox($model, 'change_phone', array('class' => 'ace ace-switch ace-switch-6')); ?>
                                <span class="lbl"></span>
                            </label>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <label>
                                <?php echo $form->checkBox($model, 'status', array('class' => 'ace ace-switch ace-switch-6')); ?>
                                <span class="lbl"></span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="control-group form-group buttons">
                        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'update') : Yii::t('common', 'update'), array('class' => 'btn btn-info')); ?>
                    </div>
                    <?php
                    $this->endWidget();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>