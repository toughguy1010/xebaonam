<div class="widget widget-box">
    <div class="widget-header">
        <h4><?php echo Yii::t('site', 'audio'); ?></h4>
        <div class="widget-toolbar">
            <?php
            if (ClaSite::showTranslateButton())
                $this->widget('application.widgets.translate.translate', array('baseUrl' => '/setting/setting/audio', 'params' => array(), 'iconClass' => 'bigger-125'));
            ?>
        </div>
    </div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <?php $this->renderPartial('_form_audio', array('model' => $model,'options' => $options,)); ?>
        </div>
    </div>
</div>