<div class="widget widget-box">
    <div class="widget-header"><h4><?php echo Yii::t('service', 'appointment_update'); ?></h4></div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <?php $this->renderPartial('_form', array('model' => $model)); ?>
        </div>
    </div>
</div>