<div class="widget widget-box">
    <div class="widget-header">
        <h4><?php echo Yii::t('product', 'product_edit'); ?></h4>
        <div class="widget-toolbar no-border">
            <a style="margin-right: 20px;" class="btn btn-xs btn-primary" id="saveproduct" href="#" validate="<?php echo Yii::app()->createUrl('economy/product/validate'); ?>">
                <i class="icon-ok"></i>
                <?php echo Yii::t('common', 'save') ?>
            </a>
        </div>
    </div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <?php $this->renderPartial('_form', array('model' => $model, 'category' => $category, 'manufacturerCategory' => $manufacturerCategory, 'productInfo' => $productInfo, 'attributes_cf' => $attributes_cf, 'attributes_changeprice' => $attributes_changeprice, 'shop_store' => $shop_store)); ?>
        </div>
    </div>
</div>