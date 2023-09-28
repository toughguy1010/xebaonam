<div class="form-group no-margin-left">
    <?php echo $form->labelEx($tourInfo, 'meta_title', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($tourInfo, 'meta_title', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($tourInfo, 'meta_title'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($tourInfo, 'meta_keywords', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <label style="font-size: 12px;font-style: italic"><?php echo Yii::t('common', 'tags_description') ?></label>
        <?php echo $form->textArea($tourInfo, 'meta_keywords', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($tourInfo, 'meta_keywords'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($tourInfo, 'meta_description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($tourInfo, 'meta_description', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($tourInfo, 'meta_description'); ?>
    </div>
</div>