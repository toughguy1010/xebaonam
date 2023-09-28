<div class="widget widget-box">
    <div class="widget-header"><span class="title"><?php echo Yii::t('common','setting_footer'); ?></span></div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <?php $this->renderPartial('_form', array('model' => $model)); ?>
        </div>
    </div>
</div>