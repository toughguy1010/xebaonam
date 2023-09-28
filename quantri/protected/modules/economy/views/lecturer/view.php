<?php
/* @var $this LecturerController */
/* @var $model Lecturer */

$this->breadcrumbs=array(
	'Lecturers'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Lecturer', 'url'=>array('index')),
	array('label'=>'Create Lecturer', 'url'=>array('create')),
	array('label'=>'Update Lecturer', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Lecturer', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Lecturer', 'url'=>array('admin')),
);
?>

<h1>View Lecturer #<?php echo $model->id; ?></h1>

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
