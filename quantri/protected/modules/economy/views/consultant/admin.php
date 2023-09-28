<?php
/* @var $this ConsultantController */
/* @var $model Consultant */

$this->breadcrumbs=array(
	'Consultants'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Consultant', 'url'=>array('index')),
	array('label'=>'Create Consultant', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#consultant-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Consultants</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'consultant-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'bod',
		'status',
		'subject',
		'level_of_education',
		/*
		'avatar_path',
		'avatar_name',
		'description',
		'gender',
		'add',
		'phone',
		'experience',
		'facebook',
		'email',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
