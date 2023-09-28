<?php
/* @var $this LibDistrictsController */
/* @var $model LibDistricts */

$this->breadcrumbs=array(
	'Lib Districts'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List LibDistricts', 'url'=>array('index')),
	array('label'=>'Create LibDistricts', 'url'=>array('create')),
	array('label'=>'Update LibDistricts', 'url'=>array('update', 'id'=>$model->district_id)),
	array('label'=>'Delete LibDistricts', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->district_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LibDistricts', 'url'=>array('admin')),
);
?>

<h1>View LibDistricts #<?php echo $model->district_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'district_id',
		'name',
		'type',
		'latlng',
		'province_id',
	),
)); ?>
