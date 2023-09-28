<?php
/* @var $this LibWardsController */
/* @var $data LibWards */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ward_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ward_id), array('view', 'id'=>$data->ward_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('latlng')); ?>:</b>
	<?php echo CHtml::encode($data->latlng); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('district_id')); ?>:</b>
	<?php echo CHtml::encode($data->district_id); ?>
	<br />


</div>