<?php
/* @var $this CourseController */
/* @var $model Course */

$this->breadcrumbs=array(
	'Courses'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Course', 'url'=>array('index')),
	array('label'=>'Create Course', 'url'=>array('create')),
	array('label'=>'Update Course', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Course', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Course', 'url'=>array('admin')),
);
?>

<h1>View Course #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'cat_id',
		'site_id',
		'name',
		'alias',
		'price',
		'price_market',
		'status',
		'order',
		'image_path',
		'image_name',
		'created_time',
		'modified_time',
		'viewed',
		'meta_keywords',
		'meta_description',
		'meta_title',
		'time_for_study',
		'number_of_students',
		'school_schedule',
		'course_open',
		'course_finish',
		'sort_description',
		'description',
	),
)); ?>
