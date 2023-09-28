<?php
/* @var $this WidgetController */
/* @var $model Widgets */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'widget_id'); ?>
		<?php echo $form->textField($model,'widget_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'widget_key'); ?>
		<?php echo $form->textField($model,'widget_key',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'widget_name'); ?>
		<?php echo $form->textField($model,'widget_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'widget_title'); ?>
		<?php echo $form->textField($model,'widget_title',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'widget_status'); ?>
		<?php echo $form->textField($model,'widget_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'widget_template'); ?>
		<?php echo $form->textArea($model,'widget_template',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'widget_right'); ?>
		<?php echo $form->textField($model,'widget_right'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'alias'); ?>
		<?php echo $form->textField($model,'alias',array('size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_time'); ?>
		<?php echo $form->textField($model,'created_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'modified_time'); ?>
		<?php echo $form->textField($model,'modified_time'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->