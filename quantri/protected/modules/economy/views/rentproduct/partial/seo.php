<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'meta_keywords', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <label
            style="font-size: 12px;font-style: italic"><?php echo Yii::t('common', 'tags_description') ?></label>
            <?php echo $form->textArea($model, 'meta_keywords', array('class' => 'span12 col-sm-12')); ?>
            <?php echo $form->error($model, 'meta_keywords'); ?>
    </div>
    <div style="clear: both;"><br/></div>
    <?php echo $form->labelEx($model, 'meta_description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'meta_description', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'meta_description'); ?>
    </div>
    <div style="clear: both;"><br/></div>
    <?php echo $form->labelEx($model, 'meta_title', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'meta_title', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'meta_title'); ?>
    </div>
</div>