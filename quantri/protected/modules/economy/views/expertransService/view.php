<?php
/* @var $this OrderController */
/* @var $model Orders */

$this->breadcrumbs = array(
    'Orders' => array('index'),
    $model->id,
);
//
?>

<h1>Yêu cầu BPO #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'name',
        'phone',
        'email',
        'country' => array(
            'name' => 'created_time',
            'value' => function ($model) {
                return date('d/m/Y', $model->created_time);
            },
        ),
        'service',
        'currency',
        'payment_method',
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
        'company'
    ),
)); ?>
