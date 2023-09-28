<?php
/* @var $this AffiliateLinkController */
/* @var $model AffiliateLink */
/* @var $form CActiveForm */
?>


<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'affiliate-link-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
    'htmlOptions' => array('class' => 'form-horizontal'),
        ));
?>
<div class="form-group ">
    <?php echo $form->labelEx($model, 'url', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'url', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'url'); ?>
    </div>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'campaign_source', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'campaign_source', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'campaign_source'); ?>
    </div>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'aff_type', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'aff_type', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'aff_type'); ?>
    </div>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'campaign_name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'campaign_name', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'campaign_name'); ?>
    </div>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'campaign_content', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'campaign_content', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'campaign_content'); ?>
    </div>
</div>

<div class="form-group">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
</div>

<?php $this->endWidget(); ?>
