<?php
/* @var $this ConsultantController */
/* @var $model Consultant */

$this->breadcrumbs=array(
	'Consultants'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Consultant', 'url'=>array('index')),
	array('label'=>'Create Consultant', 'url'=>array('create')),
	array('label'=>'View Consultant', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Consultant', 'url'=>array('admin')),
);
?>

<h1>Update Consultant <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>