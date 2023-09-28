<?php
/* @var $this MenuController */
/* @var $model Menus */

$this->breadcrumbs=array(
	'Menuses'=>array('index'),
	$model->menu_id,
);

$this->menu=array(
	array('label'=>'List Menus', 'url'=>array('index')),
	array('label'=>'Create Menus', 'url'=>array('create')),
	array('label'=>'Update Menus', 'url'=>array('update', 'id'=>$model->menu_id)),
	array('label'=>'Delete Menus', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->menu_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Menus', 'url'=>array('admin')),
);
?>

<h1>View Menus #<?php echo $model->menu_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'menu_id',
		'site_id',
		'user_id',
		'menu_title',
		'parent_id',
		'menu_linkto',
		'menu_link',
		'menu_basepath',
		'menu_pathparams',
		'menu_order',
		'alias',
		'status',
		'menu_target',
		'created_time',
		'modified_time',
		'modified_by',
	),
)); ?>
