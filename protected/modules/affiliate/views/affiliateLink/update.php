<?php
/* @var $this AffiliateLinkController */
/* @var $model AffiliateLink */

$this->breadcrumbs=array(
	'Affiliate Links'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AffiliateLink', 'url'=>array('index')),
	array('label'=>'Create AffiliateLink', 'url'=>array('create')),
	array('label'=>'View AffiliateLink', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AffiliateLink', 'url'=>array('admin')),
);
?>

<h1>Update AffiliateLink <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>