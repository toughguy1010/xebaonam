<div class="widget widget-box">
    <div class="widget-header">
        <h4>
            Cấu hình tin nhắn khi có đơn hàng đơn hàng
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
                        <?php echo $form->labelEx($model, 'content', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textArea($model, 'content', array('class' => 'span9 col-sm-12')); ?>
                            <div class="clearfix"></div>
                            <div>
                                <ul style="padding-top: 10px; display: block">
                                    <li>{user_name} => Tên khách hàng</li>
                                    <li>{user_phone} => Số điện thoại khách hàng</li>
                                    <li>{user_email} => Email khách hàng</li>
                                    <li>{order_total} => Giá trị đơn hàng</li>
                                </ul>
                            </div>
                            <span class="help-inline">
                                <?php echo $form->error($model, 'content'); ?>
                            </span>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'phone_admin', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'phone_admin', array('class' => 'span9 col-sm-12')); ?>
                            <div><span style="font-style: italic; display: inline-block; padding-top: 5px;">Hỗ trợ nhiều số điện thoại, cách nhau bởi dấu ,</span></div>
                            <span class="help-inline">
                                <?php echo $form->error($model, 'phone_admin'); ?>
                            </span>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'send_admin', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <label>
                                <?php echo $form->checkBox($model, 'send_admin', array('class' => 'ace ace-switch ace-switch-6')); ?>
                                <span class="lbl"></span>
                            </label>
                        </div>
                    </div>
                    
                    
                    
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'content_customer', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textArea($model, 'content_customer', array('class' => 'span9 col-sm-12')); ?>
                            <div class="clearfix"></div>
                            <div>
                                <ul style="padding-top: 10px; display: block">
                                    <li>{user_name} => Tên khách hàng</li>
                                    <li>{user_phone} => Số điện thoại khách hàng</li>
                                    <li>{user_email} => Email khách hàng</li>
                                    <li>{order_total} => Giá trị đơn hàng</li>
                                </ul>
                            </div>
                            <span class="help-inline">
                                <?php echo $form->error($model, 'content_customer'); ?>
                            </span>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'send_customer', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <label>
                                <?php echo $form->checkBox($model, 'send_customer', array('class' => 'ace ace-switch ace-switch-6')); ?>
                                <span class="lbl"></span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'loaisp', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->dropDownList($model, 'loaisp', Sms::loaispArr(), array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'loaisp'); ?>
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