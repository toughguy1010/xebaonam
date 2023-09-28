<?php
/* @var $this AlbumController */
/* @var $data Albums */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('album_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->album_id), array('view', 'id'=>$data->album_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('album_name')); ?>:</b>
	<?php echo CHtml::encode($data->album_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('album_description')); ?>:</b>
	<?php echo CHtml::encode($data->album_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('album_type')); ?>:</b>
	<?php echo CHtml::encode($data->album_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('photocount')); ?>:</b>
	<?php echo CHtml::encode($data->photocount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alias')); ?>:</b>
	<?php echo CHtml::encode($data->alias); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('site_id')); ?>:</b>
	<?php echo CHtml::encode($data->site_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('meta_keywords')); ?>:</b>
	<?php echo CHtml::encode($data->meta_keywords); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('meta_description')); ?>:</b>
	<?php echo CHtml::encode($data->meta_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('avatar')); ?>:</b>
	<?php echo CHtml::encode($data->avatar); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_time')); ?>:</b>
	<?php echo CHtml::encode($data->created_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_time')); ?>:</b>
	<?php echo CHtml::encode($data->modified_time); ?>
	<br />

	*/ ?>

</div>