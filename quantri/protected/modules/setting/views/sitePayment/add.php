<div class="widget widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('common', 'setting_payment'); ?>
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
                        <?php echo $form->labelEx($model, 'payment_type', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->dropDownList($model, 'payment_type', SitePayment::typeArr(), array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'payment_type'); ?>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'email_bussiness', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'email_bussiness', array('class' => 'span9 col-sm-12')); ?>
                            <span class="help-inline">
                                <?php echo $form->error($model, 'email_bussiness'); ?>
                            </span>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'receive_account', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'receive_account', array('class' => 'span9 col-sm-12')); ?>
                            <span class="help-inline">
                                <?php echo $form->error($model, 'receive_account'); ?>
                            </span>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'url_request', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'url_request', array('class' => 'span9 col-sm-12')); ?>
                            <span class="help-inline">
                                <?php echo $form->error($model, 'url_request'); ?>
                            </span>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'url_return', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'url_return', array('class' => 'span9 col-sm-12')); ?>
                            <span class="help-inline">
                                <?php echo $form->error($model, 'url_return'); ?>
                            </span>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'merchan_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'merchan_id', array('class' => 'span9 col-sm-12')); ?>
                            <span class="help-inline">
                                <?php echo $form->error($model, 'merchan_id'); ?>
                            </span>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'api_user', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'api_user', array('class' => 'span9 col-sm-12')); ?>
                            <span class="help-inline">
                                <?php echo $form->error($model, 'api_user'); ?>
                            </span>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'api_password', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'api_password', array('class' => 'span9 col-sm-12')); ?>
                            <span class="help-inline">
                                <?php echo $form->error($model, 'api_password'); ?>
                            </span>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'access_code', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'access_code', array('class' => 'span9 col-sm-12')); ?>
                            <span class="help-inline">
                                <?php echo $form->error($model, 'access_code'); ?>
                            </span>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'secure_pass', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->passwordField($model, 'secure_pass', array('class' => 'span9 col-sm-12')); ?>
                            <span class="help-inline">
                                <?php echo $form->error($model, 'secure_pass'); ?>
                            </span>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'pri_key', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textArea($model, 'pri_key', array('class' => 'span12 col-sm-12', 'rows' => 10)); ?>
                            <?php echo $form->error($model, 'pri_key'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'client_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'client_id', array('class' => 'span9 col-sm-12')); ?>
                            <span class="help-inline">
                                <?php echo $form->error($model, 'client_id'); ?>
                            </span>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'secret', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->passwordField($model, 'secret', array('class' => 'span9 col-sm-12')); ?>
                            <span class="help-inline">
                                <?php echo $form->error($model, 'secret'); ?>
                            </span>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'api_key', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'api_key', array('class' => 'span9 col-sm-12')); ?>
                            <span class="help-inline">
                                <?php echo $form->error($model, 'api_key'); ?>
                            </span>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'encrypt_key', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'encrypt_key', array('class' => 'span9 col-sm-12')); ?>
                            <span class="help-inline">
                                <?php echo $form->error($model, 'encrypt_key'); ?>
                            </span>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'checksum', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'checksum', array('class' => 'span9 col-sm-12')); ?>
                            <span class="help-inline">
                                <?php echo $form->error($model, 'checksum'); ?>
                            </span>
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