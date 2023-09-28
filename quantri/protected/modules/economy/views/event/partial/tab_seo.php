<div class="form-group no-margin-left">
    <?php echo $form->labelEx($eventInfo, 'meta_title', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($eventInfo, 'meta_title', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($eventInfo, 'meta_title'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($eventInfo, 'meta_keywords', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($eventInfo, 'meta_keywords', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($eventInfo, 'meta_keywords'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($eventInfo, 'meta_description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($eventInfo, 'meta_description', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($eventInfo, 'meta_description'); ?>
    </div>
</div>