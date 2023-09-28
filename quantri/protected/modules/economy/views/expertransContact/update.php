<?php
/* @var $this ContactsController */
/* @var $model Contacts */

//$this->menu=array(
//	array('label'=>'List Contacts', 'url'=>array('index')),
//	array('label'=>'Create Contacts', 'url'=>array('create')),
//	array('label'=>'View Contacts', 'url'=>array('view', 'id'=>$model->contact_id)),
//	array('label'=>'Manage Contacts', 'url'=>array('admin')),
//);
?>

<h1>Cập nhập thông tin liên hệ #<?php echo $model->id; ?></h1>
<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'name',
        'phone',
        'email',
        'company',
        'company_name',
        'service',
        'note',
        'modified_time' => array(
            'name' => 'modified_time',
            'value' => function ($model) {
                return date('d/m/Y', $model->modified_time);
            },
        )
    , 'created_time' => array(
            'name' => 'created_time',
            'value' => function ($model) {
                return date('d/m/Y', $model->created_time);
            },
        ),
        'site_id', 'company'
    ),
)); ?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>