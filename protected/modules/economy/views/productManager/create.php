<div class="widget widget-box">
    <div class="widget-header">
        <h4><?php echo Yii::t('product', 'product_create'); ?></h4>
        <div class="widget-toolbar no-border">
            <a style="" class="btn btn-xs btn-primary" id="saveproduct" href="#" validate="<?php echo Yii::app()->createUrl('economy/productManager/validate'); ?>">
                <i class="icon-ok"></i>
                <?php echo Yii::t('common', 'save') ?>
            </a>
        </div>
    </div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <?php $this->renderPartial('_form', array('model' => $model, 'category' => $category, 'productInfo' => $productInfo)); ?>
        </div>
    </div>
</div>