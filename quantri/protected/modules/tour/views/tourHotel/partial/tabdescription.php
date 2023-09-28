<div class="form-group no-margin-left">
    <?php echo $form->labelEx($hotelInfo, 'policy', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($hotelInfo, 'policy', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($hotelInfo, 'policy'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($hotelInfo, 'description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($hotelInfo, 'description', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($hotelInfo, 'description'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($hotelInfo, 'meta_title', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($hotelInfo, 'meta_title', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($hotelInfo, 'meta_title'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($hotelInfo, 'meta_keywords', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <label style="font-size: 12px;font-style: italic"><?php echo Yii::t('common', 'tags_description') ?></label>
        <?php echo $form->textArea($hotelInfo, 'meta_keywords', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($hotelInfo, 'meta_keywords'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($hotelInfo, 'meta_description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($hotelInfo, 'meta_description', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($hotelInfo, 'meta_description'); ?>
    </div>
</div>