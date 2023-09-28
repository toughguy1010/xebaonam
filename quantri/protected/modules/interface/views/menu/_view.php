<?php
/* @var $this MenuController */
/* @var $data Menus */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('menu_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->menu_id), array('view', 'id'=>$data->menu_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('site_id')); ?>:</b>
	<?php echo CHtml::encode($data->site_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('menu_title')); ?>:</b>
	<?php echo CHtml::encode($data->menu_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('parent_id')); ?>:</b>
	<?php echo CHtml::encode($data->parent_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('menu_linkto')); ?>:</b>
	<?php echo CHtml::encode($data->menu_linkto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('menu_link')); ?>:</b>
	<?php echo CHtml::encode($data->menu_link); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('menu_basepath')); ?>:</b>
	<?php echo CHtml::encode($data->menu_basepath); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('menu_pathparams')); ?>:</b>
	<?php echo CHtml::encode($data->menu_pathparams); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('menu_order')); ?>:</b>
	<?php echo CHtml::encode($data->menu_order); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alias')); ?>:</b>
	<?php echo CHtml::encode($data->alias); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('menu_target')); ?>:</b>
	<?php echo CHtml::encode($data->menu_target); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_time')); ?>:</b>
	<?php echo CHtml::encode($data->created_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_time')); ?>:</b>
	<?php echo CHtml::encode($data->modified_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_by')); ?>:</b>
	<?php echo CHtml::encode($data->modified_by); ?>
	<br />

	*/ ?>

</div>