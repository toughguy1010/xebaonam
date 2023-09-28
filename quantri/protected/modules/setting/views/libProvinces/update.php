<?php
/* @var $this LibProvincesController */
/* @var $model LibProvinces */

$this->breadcrumbs=array(
	'Lib Provinces'=>array('index'),
	$model->name=>array('view','id'=>$model->province_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LibProvinces', 'url'=>array('index')),
	array('label'=>'Create LibProvinces', 'url'=>array('create')),
	array('label'=>'View LibProvinces', 'url'=>array('view', 'id'=>$model->province_id)),
	array('label'=>'Manage LibProvinces', 'url'=>array('admin')),
);
?>

<h1>Update LibProvinces <?php echo $model->province_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>