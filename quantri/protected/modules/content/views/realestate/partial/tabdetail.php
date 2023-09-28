<div class="control-group form-group">
    <?php echo $form->labelEx($real_estate_project_info, 'description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($real_estate_project_info, 'description', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($real_estate_project_info, 'description'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($real_estate_project_info, 'target', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($real_estate_project_info, 'target', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($real_estate_project_info, 'target'); ?>
    </div>
</div>


