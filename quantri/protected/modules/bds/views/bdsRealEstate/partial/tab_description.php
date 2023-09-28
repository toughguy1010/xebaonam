<div class="form-group no-margin-left">
    <?php echo $form->labelEx($real_estateInfo, 'short_description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($real_estateInfo, 'short_description', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($real_estateInfo, 'short_description'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($real_estateInfo, 'description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($real_estateInfo, 'description', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($real_estateInfo, 'description'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($real_estateInfo, 'history_build', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($real_estateInfo, 'history_build', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($real_estateInfo, 'history_build'); ?>
    </div>
</div>