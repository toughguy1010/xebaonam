<?php
/* @var $this OrderController */
/* @var $model Orders */

$this->breadcrumbs=array(
	'Orders'=>array('index'),
	$model->order_id,
);

$this->menu=array(
	array('label'=>'List Orders', 'url'=>array('index')),
	array('label'=>'Create Orders', 'url'=>array('create')),
	array('label'=>'Update Orders', 'url'=>array('update', 'id'=>$model->order_id)),
	array('label'=>'Delete Orders', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->order_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Orders', 'url'=>array('admin')),
);
?>

<h1>View Orders #<?php echo $model->order_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'order_id',
		'user_id',
		'site_id',
		'shipping_name',
		'shipping_email',
		'shipping_address',
		'shipping_phone',
		'shipping_city',
		'billing_name',
		'billing_email',
		'billing_address',
		'billing_phone',
		'billing_city',
		'payment_method',
		'transport_method',
		'coupon_code',
		'order_status',
		'order_total',
		'ip_address',
		'key',
		'created_time',
		'modified_time',
		'note',
		'transport_freight',
	),
)); ?>
