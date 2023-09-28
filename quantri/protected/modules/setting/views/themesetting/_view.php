<?php
/* @var $this ThemesettingController */
/* @var $data Themes */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('theme_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->theme_id), array('view', 'id'=>$data->theme_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('theme_name')); ?>:</b>
	<?php echo CHtml::encode($data->theme_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rules')); ?>:</b>
	<?php echo CHtml::encode($data->rules); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_time')); ?>:</b>
	<?php echo CHtml::encode($data->created_time); ?>
	<br />


</div>