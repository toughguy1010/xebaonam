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
                <?php echo $form->dropDownlist($model, 'payment_type', array('baokim'=>'baokim'), array('class' => 'span12 col-sm-12')); ?>
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
            <?php echo $form->labelEx($model, 'secure_pass', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'secure_pass', array('class' => 'span9 col-sm-12')); ?>
                <span class="help-inline">
                    <?php echo $form->error($model, 'secure_pass'); ?>
                </span>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'pri_key', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'pri_key', array('class' => 'span12 col-sm-12','rows'=>10)); ?>
                <?php echo $form->error($model, 'pri_key'); ?>
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

        <?php $this->endWidget(); ?>
    </div>
</div>