<?php
/* @var $this LibProvincesController */
/* @var $model LibProvinces */

$this->breadcrumbs=array(
	'Lib Provinces'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List LibProvinces', 'url'=>array('index')),
	array('label'=>'Create LibProvinces', 'url'=>array('create')),
	array('label'=>'Update LibProvinces', 'url'=>array('update', 'id'=>$model->province_id)),
	array('label'=>'Delete LibProvinces', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->province_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LibProvinces', 'url'=>array('admin')),
);
?>

<h1>View LibProvinces #<?php echo $model->province_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'province_id',
		'name',
		'type',
		'latlng',
	),
)); ?>
