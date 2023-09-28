<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'policy', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'policy', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'policy'); ?>
    </div>
</div>