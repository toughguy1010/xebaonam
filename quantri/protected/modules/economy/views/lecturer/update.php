<?php
/* @var $this LecturerController */
/* @var $model Lecturer */

$this->breadcrumbs=array(
	'Lecturers'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Lecturer', 'url'=>array('index')),
	array('label'=>'Create Lecturer', 'url'=>array('create')),
	array('label'=>'View Lecturer', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Lecturer', 'url'=>array('admin')),
);
?>

<h1>Update Lecturer <?php echo $model->id; ?></h1>

