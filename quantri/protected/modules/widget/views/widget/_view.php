<?php
/* @var $this WidgetController */
/* @var $data Widgets */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('widget_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->widget_id), array('view', 'id'=>$data->widget_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('widget_key')); ?>:</b>
	<?php echo CHtml::encode($data->widget_key); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('widget_name')); ?>:</b>
	<?php echo CHtml::encode($data->widget_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('widget_title')); ?>:</b>
	<?php echo CHtml::encode($data->widget_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('widget_status')); ?>:</b>
	<?php echo CHtml::encode($data->widget_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('widget_template')); ?>:</b>
	<?php echo CHtml::encode($data->widget_template); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('widget_right')); ?>:</b>
	<?php echo CHtml::encode($data->widget_right); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('alias')); ?>:</b>
	<?php echo CHtml::encode($data->alias); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_time')); ?>:</b>
	<?php echo CHtml::encode($data->created_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_time')); ?>:</b>
	<?php echo CHtml::encode($data->modified_time); ?>
	<br />

	*/ ?>

</div>