<h1>View TranslateOption #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'name',
        'description',
    ),
)); ?>
<div style="padding: 10px 0">
    <a href="<?php echo Yii::app()->createUrl('economy/translateOption/') ?>">
        <button class="btn btn-sm btn-info">Về trang danh mục</button>
    </a>
    <a href="<?php echo Yii::app()->createUrl('economy/translateOption/update', array('id' => $model->id)) ?>">
        <button class="btn btn-sm btn-info">Sửa</button>
    </a>
</div>
