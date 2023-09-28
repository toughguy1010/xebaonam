<?php
/* @var $this LibWardsController */
/* @var $model LibWards */

$this->breadcrumbs=array(
	'Lib Wards'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List LibWards', 'url'=>array('index')),
	array('label'=>'Create LibWards', 'url'=>array('create')),
	array('label'=>'Update LibWards', 'url'=>array('update', 'id'=>$model->ward_id)),
	array('label'=>'Delete LibWards', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->ward_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LibWards', 'url'=>array('admin')),
);
?>

<h1>View LibWards #<?php echo $model->ward_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'ward_id',
		'name',
		'type',
		'latlng',
		'district_id',
	),
)); ?>
