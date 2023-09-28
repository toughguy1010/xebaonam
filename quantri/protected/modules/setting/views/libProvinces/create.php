<?php
/* @var $this LibProvincesController */
/* @var $model LibProvinces */

$this->breadcrumbs = array(
    'Lib Provinces' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'List LibProvinces', 'url' => array('index')),
    array('label' => 'Manage LibProvinces', 'url' => array('admin')),
);
?>

<h1>Create LibProvinces</h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>