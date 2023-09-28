<div class="widget widget-box">
    <div class="widget-header">
        <h4><?php echo Yii::t('site', 'site_support'); ?></h4>
        <div class="widget-toolbar">
            <?php
            if (ClaSite::showTranslateButton())
                $this->widget('application.widgets.translate.translate', array('baseUrl' => 'setting/support/index', 'params' => array(), 'iconClass' => 'bigger-125'));
            ?>
        </div>
    </div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <?php $this->renderPartial('_form', array('model' => $model, 'data' => $data)); ?>
        </div>
    </div>
</div>