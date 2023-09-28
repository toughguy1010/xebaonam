<?php
/* @var $this AffiliateLinkController */
/* @var $model AffiliateLink */

$this->breadcrumbs=array(
	'Affiliate Links'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List AffiliateLink', 'url'=>array('index')),
	array('label'=>'Create AffiliateLink', 'url'=>array('create')),
	array('label'=>'Update AffiliateLink', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AffiliateLink', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AffiliateLink', 'url'=>array('admin')),
);
?>

<h1>View AffiliateLink #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'url',
		'link',
		'link_short',
		'campaign_source',
		'aff_type',
		'campaign_name',
		'campaign_content',
		'created_time',
		'modified_time',
		'site_id',
	),
)); ?>
