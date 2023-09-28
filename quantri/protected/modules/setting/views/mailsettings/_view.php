<?php
/* @var $this MailsettingsController */
/* @var $data MailSettings */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('mail_key')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->mail_key), array('view', 'id'=>$data->mail_key)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mail_title')); ?>:</b>
	<?php echo CHtml::encode($data->mail_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mail_subject')); ?>:</b>
	<?php echo CHtml::encode($data->mail_subject); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mail_msg')); ?>:</b>
	<?php echo CHtml::encode($data->mail_msg); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mail_attribute')); ?>:</b>
	<?php echo CHtml::encode($data->mail_attribute); ?>
	<br />


</div>