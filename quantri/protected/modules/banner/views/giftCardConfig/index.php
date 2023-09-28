<div class="widget widget-box">
    <div class="widget-header">
        <h4>Gift Card Config</h4>
        <div class="widget-toolbar">
            <?php
            if (ClaSite::showTranslateButton()) {
                $this->widget('application.widgets.translate.translate', array('baseUrl' => 'setting/setting/index', 'params' => array(), 'iconClass' => 'bigger-125'));
            }
            ?>
        </div>
    </div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <?php $this->renderPartial('_form', array('model' => $model, 'shop_store' => $shop_store)); ?>
        </div>
    </div>
</div>