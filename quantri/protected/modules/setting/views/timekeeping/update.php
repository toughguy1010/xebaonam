<div class="widget widget-box">
    <div class="widget-header"><h4>Cập nhật chấm công: <?= $model->name ?></h4></div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <?php $this->renderPartial('_form', array('model' => $model)); ?>
        </div>
    </div>
</div>