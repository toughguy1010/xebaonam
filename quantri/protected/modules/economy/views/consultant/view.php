<?php
/* @var $this ConsultantController */
/* @var $model Consultant */

$this->breadcrumbs=array(
	'Consultants'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Consultant', 'url'=>array('index')),
	array('label'=>'Create Consultant', 'url'=>array('create')),
	array('label'=>'Update Consultant', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Consultant', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Consultant', 'url'=>array('admin')),
);
?>

<h1>View Consultant #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'bod',
		'status',
		'subject',
		'level_of_education',
		'avatar_path',
		'avatar_name',
		'description',
		'gender',
		'add',
		'phone',
		'experience',
		'facebook',
		'email',
	),
)); ?>
