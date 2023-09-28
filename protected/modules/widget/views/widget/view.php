<?php
/* @var $this WidgetController */
/* @var $model Widgets */

$this->breadcrumbs=array(
	'Widgets'=>array('index'),
	$model->widget_id,
);

$this->menu=array(
	array('label'=>'List Widgets', 'url'=>array('index')),
	array('label'=>'Create Widgets', 'url'=>array('create')),
	array('label'=>'Update Widgets', 'url'=>array('update', 'id'=>$model->widget_id)),
	array('label'=>'Delete Widgets', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->widget_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Widgets', 'url'=>array('admin')),
);
?>

<h1>View Widgets #<?php echo $model->widget_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'widget_id',
		'widget_key',
		'widget_name',
		'widget_title',
		'widget_status',
		'widget_template',
		'widget_right',
		'alias',
		'created_time',
		'modified_time',
	),
)); ?>
