<?php
/* @var $this WidgetController */
/* @var $model Widgets */

$this->breadcrumbs=array(
	'Widgets'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Widgets', 'url'=>array('index')),
	array('label'=>'Manage Widgets', 'url'=>array('admin')),
);
?>

<h1>Create Widgets</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>