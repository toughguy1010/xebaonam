<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'w3ncreate-form',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
        ));
?>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'name', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'phone', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'phone', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'phone'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'email', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'email', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'address', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'address', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'address'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'trade', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'trade', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'trade'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'website_reference', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'website_reference', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'website_reference'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'color', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'color', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'color'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'description', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>
</div>

<?php $this->endWidget(); ?>