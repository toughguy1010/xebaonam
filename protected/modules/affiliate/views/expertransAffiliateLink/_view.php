<?php
/* @var $this AffiliateLinkController */
/* @var $data AffiliateLink */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('url')); ?>:</b>
	<?php echo CHtml::encode($data->url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('link')); ?>:</b>
	<?php echo CHtml::encode($data->link); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('link_short')); ?>:</b>
	<?php echo CHtml::encode($data->link_short); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('campaign_source')); ?>:</b>
	<?php echo CHtml::encode($data->campaign_source); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('aff_type')); ?>:</b>
	<?php echo CHtml::encode($data->aff_type); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('campaign_name')); ?>:</b>
	<?php echo CHtml::encode($data->campaign_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('campaign_content')); ?>:</b>
	<?php echo CHtml::encode($data->campaign_content); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_time')); ?>:</b>
	<?php echo CHtml::encode($data->created_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_time')); ?>:</b>
	<?php echo CHtml::encode($data->modified_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('site_id')); ?>:</b>
	<?php echo CHtml::encode($data->site_id); ?>
	<br />

	*/ ?>

</div>