<?php
/* @var $this WidgetController */
/* @var $model Widgets */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'widgets-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'widget_key'); ?>
		<?php echo $form->textField($model,'widget_key',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'widget_key'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'widget_name'); ?>
		<?php echo $form->textField($model,'widget_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'widget_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'widget_title'); ?>
		<?php echo $form->textField($model,'widget_title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'widget_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'widget_status'); ?>
		<?php echo $form->textField($model,'widget_status'); ?>
		<?php echo $form->error($model,'widget_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'widget_template'); ?>
		<?php echo $form->textArea($model,'widget_template',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'widget_template'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'widget_right'); ?>
		<?php echo $form->textField($model,'widget_right'); ?>
		<?php echo $form->error($model,'widget_right'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'alias'); ?>
		<?php echo $form->textField($model,'alias',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'alias'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_time'); ?>
		<?php echo $form->textField($model,'created_time'); ?>
		<?php echo $form->error($model,'created_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'modified_time'); ?>
		<?php echo $form->textField($model,'modified_time'); ?>
		<?php echo $form->error($model,'modified_time'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->