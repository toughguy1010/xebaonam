<?php
/* @var $this OrderController */
/* @var $data Orders */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->order_id), array('view', 'id'=>$data->order_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('site_id')); ?>:</b>
	<?php echo CHtml::encode($data->site_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shipping_name')); ?>:</b>
	<?php echo CHtml::encode($data->shipping_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shipping_email')); ?>:</b>
	<?php echo CHtml::encode($data->shipping_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shipping_address')); ?>:</b>
	<?php echo CHtml::encode($data->shipping_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shipping_phone')); ?>:</b>
	<?php echo CHtml::encode($data->shipping_phone); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('shipping_city')); ?>:</b>
	<?php echo CHtml::encode($data->shipping_city); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('billing_name')); ?>:</b>
	<?php echo CHtml::encode($data->billing_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('billing_email')); ?>:</b>
	<?php echo CHtml::encode($data->billing_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('billing_address')); ?>:</b>
	<?php echo CHtml::encode($data->billing_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('billing_phone')); ?>:</b>
	<?php echo CHtml::encode($data->billing_phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('billing_city')); ?>:</b>
	<?php echo CHtml::encode($data->billing_city); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_method')); ?>:</b>
	<?php echo CHtml::encode($data->payment_method); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('transport_method')); ?>:</b>
	<?php echo CHtml::encode($data->transport_method); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('coupon_code')); ?>:</b>
	<?php echo CHtml::encode($data->coupon_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_status')); ?>:</b>
	<?php echo CHtml::encode($data->order_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_total')); ?>:</b>
	<?php echo CHtml::encode($data->order_total); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ip_address')); ?>:</b>
	<?php echo CHtml::encode($data->ip_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('key')); ?>:</b>
	<?php echo CHtml::encode($data->key); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_time')); ?>:</b>
	<?php echo CHtml::encode($data->created_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_time')); ?>:</b>
	<?php echo CHtml::encode($data->modified_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('note')); ?>:</b>
	<?php echo CHtml::encode($data->note); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('transport_freight')); ?>:</b>
	<?php echo CHtml::encode($data->transport_freight); ?>
	<br />

	*/ ?>

</div>