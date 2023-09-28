<div class="control-group form-group">
    <?php echo $form->labelEx($config_mail, 'mail_name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($config_mail, 'mail_name', array('class' => 'span9 col-sm-12')); ?>
        <span class="help-inline">
            <?php echo $form->error($config_mail, 'mail_name'); ?>
        </span>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($config_mail, 'password', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($config_mail, 'password', array('class' => 'span9 col-sm-12')); ?>
        <span class="help-inline">
            <?php echo $form->error($config_mail, 'password'); ?>
        </span>
    </div>
</div>