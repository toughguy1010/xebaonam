<div class="form-group no-margin-left">
    <?php echo $form->labelEx($companyInfo, 'description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($companyInfo, 'description', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($companyInfo, 'description'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($companyInfo, 'field', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($companyInfo, 'field', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($companyInfo, 'field'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($companyInfo, 'contact', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($companyInfo, 'contact', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($companyInfo, 'contact'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($companyInfo, 'award', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($companyInfo, 'award', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($companyInfo, 'award'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($companyInfo, 'size', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($companyInfo, 'size', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($companyInfo, 'size'); ?>
    </div>
</div>