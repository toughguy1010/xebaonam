<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'config5', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'config5', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'config5'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'config5_content', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'config5_content', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'config5_content'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'config5_image', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->hiddenField($model, 'config5_image', array('class' => 'span12 col-sm-12')); ?>
        <div id="BdsProjectconfig5_image" style="display: block; margin-top: 0px;">
            <div id="BdsProjectconfig5_image_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->config5_image) echo 'margin-right: 10px;'; ?>">  
                <?php if ($model->config5_image_path && $model->config5_image_name) { ?>
                    <img src="<?php echo ClaHost::getImageHost(), $model->config5_image_path, 's100_100/', $model->config5_image_name; ?>" style="width: 100%;" />
                <?php } ?>
            </div>
            <div id="BdsProjectconfig5_image_form" style="display: inline-block;">
                <?php echo CHtml::button(Yii::t('bds_project_config', 'btn_select_config5_image'), array('class' => 'btn  btn-sm')); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'config5_image'); ?>
    </div>
</div>