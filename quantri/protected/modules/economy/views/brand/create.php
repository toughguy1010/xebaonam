<div class="widget widget-box">
    <div class="widget-header">
        <h4><?php echo Yii::t('brand', 'brand_create'); ?></h4>
        <div class="widget-toolbar no-border">
            <a class="btn btn-xs btn-primary" id="savebrand" onclick="submit_brand_form()">
                <i class="icon-ok"></i>
                <?php echo Yii::t('common', 'save') ?>
            </a>
        </div>
    </div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <?php 
            $this->renderPartial('_form', array(
                'model' => $model, 
            )); 
            ?>
        </div>
    </div>
</div>
<script>
    function submit_brand_form() {
        document.getElementById("brand-form").submit();
        return false;
    }
</script>