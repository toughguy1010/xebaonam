<div class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'position'); ?>
		<?php echo $form->textField($model,'position'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'trade_id'); ?>
		<?php echo $form->textField($model,'trade_id',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'provinces'); ?>
		<?php echo $form->textField($model,'provinces',array('size'=>60,'maxlength'=>255)); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->