<div class="widget widget-box">
    <div class="widget-header">
        <h4><?php echo Yii::t('product', 'product_update_warranty'); ?></h4>
        <div class="widget-toolbar no-border">
            <a class="btn btn-xs btn-primary" id="saveevent" onclick="submit_warranty_form()">
                <i class="icon-ok"></i>
                <?php echo Yii::t('common', 'save') ?>
            </a>
        </div>
    </div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <?php $this->renderPartial('_form', array('model' => $model, 'form' => $form, 'option_product' => $option_product)); ?>
        </div>
    </div>
</div>
<script>
    function submit_warranty_form() {
        document.getElementById("warranty-form").submit();
        return false;
    }
</script>