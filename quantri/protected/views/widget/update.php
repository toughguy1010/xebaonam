<?php
/* @var $this WidgetController */
/* @var $model Widgets */

$this->breadcrumbs=array(
	'Widgets'=>array('index'),
	$model->widget_id=>array('view','id'=>$model->widget_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Widgets', 'url'=>array('index')),
	array('label'=>'Create Widgets', 'url'=>array('create')),
	array('label'=>'View Widgets', 'url'=>array('view', 'id'=>$model->widget_id)),
	array('label'=>'Manage Widgets', 'url'=>array('admin')),
);
?>

<h1>Update Widgets <?php echo $model->widget_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>