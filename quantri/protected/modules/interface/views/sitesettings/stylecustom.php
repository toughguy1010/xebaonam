<div class="widget widget-box">
    <div class="widget-header">
        <h5 class="title"><?php echo Yii::t('site', 'stylecustom'); ?></h5>
        <div class="widget-toolbar">
            <?php
            if (ClaSite::isMultiLanguage())
                $this->widget('application.widgets.translate.translate', array('baseUrl' => 'interface/sitesettings/stylecustom', 'params' => array(), 'iconClass' => 'bigger-125'));
            ?>
        </div>
    </div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <p class="text-danger">
                <?php echo Yii::t('site', 'stylecustomwarning'); ?>
            </p>
            <?php $this->renderPartial('_stylecustomform', array('model' => $model)); ?>
        </div>
    </div>
</div>