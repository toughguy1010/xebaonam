<div class="widget widget-box">
    <div class="widget-header">
        <h5 class="title"><?php echo Yii::t('common', 'setting_footer'); ?></h5>
        <div class="widget-toolbar">
            <?php
            if (ClaSite::isMultiLanguage())
                $this->widget('application.widgets.translate.translate', array('baseUrl' => 'interface/sitesettings/footersetting', 'params' => array(), 'iconClass' => 'bigger-125'));
            ?>
        </div>
    </div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <?php $this->renderPartial('_footerform', array('model' => $model)); ?>
        </div>
    </div>
</div>