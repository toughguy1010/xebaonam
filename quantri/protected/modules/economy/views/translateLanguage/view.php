<h1>View TranslateLanguage #<?php echo $model->id; ?></h1>

<?php //$this->renderPartial('_form', array('model' => $model)); ?>
<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'from_lang',
        'to_lang',
        'price',
        'currency',
    ),
)); ?>
<div style="padding: 10px 0">
    <a href="<?php echo Yii::app()->createUrl('economy/translateLanguage/') ?>">
        <button class="btn btn-sm btn-info">Về trang danh mục</button>
    </a>
    <a href="<?php echo Yii::app()->createUrl('economy/translateLanguage/update', array('id' => $model->id)) ?>">
        <button class="btn btn-sm btn-info">Sửa</button>
    </a>
</div>
