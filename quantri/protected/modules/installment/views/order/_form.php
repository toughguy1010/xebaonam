<?php
/* @var $this OrderController */
/* @var $model Orders */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'orders-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'site_id'); ?>
		<?php echo $form->textField($model,'site_id'); ?>
		<?php echo $form->error($model,'site_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shipping_name'); ?>
		<?php echo $form->textField($model,'shipping_name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'shipping_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shipping_email'); ?>
		<?php echo $form->textField($model,'shipping_email',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'shipping_email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shipping_address'); ?>
		<?php echo $form->textField($model,'shipping_address',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'shipping_address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shipping_phone'); ?>
		<?php echo $form->textField($model,'shipping_phone',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'shipping_phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shipping_city'); ?>
		<?php echo $form->textField($model,'shipping_city',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'shipping_city'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'billing_name'); ?>
		<?php echo $form->textField($model,'billing_name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'billing_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'billing_email'); ?>
		<?php echo $form->textField($model,'billing_email',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'billing_email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'billing_address'); ?>
		<?php echo $form->textField($model,'billing_address',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'billing_address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'billing_phone'); ?>
		<?php echo $form->textField($model,'billing_phone',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'billing_phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'billing_city'); ?>
		<?php echo $form->textField($model,'billing_city',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'billing_city'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_method'); ?>
		<?php echo $form->textField($model,'payment_method',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'payment_method'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'transport_method'); ?>
		<?php echo $form->textField($model,'transport_method',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'transport_method'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'coupon_code'); ?>
		<?php echo $form->textField($model,'coupon_code',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'coupon_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_status'); ?>
		<?php echo $form->textField($model,'order_status'); ?>
		<?php echo $form->error($model,'order_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_total'); ?>
		<?php echo $form->textField($model,'order_total'); ?>
		<?php echo $form->error($model,'order_total'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ip_address'); ?>
		<?php echo $form->textField($model,'ip_address',array('size'=>60,'maxlength'=>96)); ?>
		<?php echo $form->error($model,'ip_address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'key'); ?>
		<?php echo $form->textField($model,'key',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'key'); ?>
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

	<div class="row">
		<?php echo $form->labelEx($model,'note'); ?>
		<?php echo $form->textField($model,'note',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'note'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'transport_freight'); ?>
		<?php echo $form->textField($model,'transport_freight'); ?>
		<?php echo $form->error($model,'transport_freight'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->