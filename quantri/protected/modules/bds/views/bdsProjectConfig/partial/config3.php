<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'config3', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'config3', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'config3'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'config3_content', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'config3_content', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'config3_content'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'config3_image', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->hiddenField($model, 'config3_image', array('class' => 'span12 col-sm-12')); ?>
        <div id="BdsProjectconfig3_image" style="display: block; margin-top: 0px;">
            <div id="BdsProjectconfig3_image_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->config3_image) echo 'margin-right: 10px;'; ?>">  
                <?php if ($model->config3_image_path && $model->config3_image_name) { ?>
                    <img src="<?php echo ClaHost::getImageHost(), $model->config3_image_path, 's100_100/', $model->config3_image_name; ?>" style="width: 100%;" />
                <?php } ?>
            </div>
            <div id="BdsProjectconfig3_image_form" style="display: inline-block;">
                <?php echo CHtml::button(Yii::t('bds_project_config', 'btn_select_config3_image'), array('class' => 'btn  btn-sm')); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'config3_image'); ?>
    </div>
</div>