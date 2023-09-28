<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'catalog_link', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'catalog_link', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'catalog_link'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($carInfo, 'attribute', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($carInfo, 'attribute', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($carInfo, 'attribute'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($carInfo, 'description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($carInfo, 'description', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($carInfo, 'description'); ?>
    </div>
</div>