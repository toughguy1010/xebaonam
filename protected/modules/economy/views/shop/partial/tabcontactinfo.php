<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'contact', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'contact', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'contact'); ?>
    </div>
</div>