<?php
/* @var $this ThemesettingController */
/* @var $model Themes */

$this->breadcrumbs=array(
	'Themes'=>array('index'),
	$model->theme_id,
);

$this->menu=array(
	array('label'=>'List Themes', 'url'=>array('index')),
	array('label'=>'Create Themes', 'url'=>array('create')),
	array('label'=>'Update Themes', 'url'=>array('update', 'id'=>$model->theme_id)),
	array('label'=>'Delete Themes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->theme_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Themes', 'url'=>array('admin')),
);
?>

<h1>View Themes #<?php echo $model->theme_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'theme_id',
		'theme_name',
		'rules',
		'created_time',
	),
)); ?>
