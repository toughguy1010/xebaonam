<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'meta_title', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'meta_title', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'meta_title'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'meta_keywords', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'meta_keywords', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'meta_keywords'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'meta_description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'meta_description', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'meta_description'); ?>
    </div>
</div>