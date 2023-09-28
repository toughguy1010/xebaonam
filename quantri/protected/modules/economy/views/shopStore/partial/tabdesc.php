<script>
    jQuery(document).ready(function () {
        CKEDITOR.replace("ShopStore_shop_store_desc", {
            height: 400,
            language: '<?php echo Yii::app()->language ?>'
        });
    });
</script>
<div class="form-group no-margin-left">
    <div class="controls col-sm-12">
        <?php echo $form->textArea($model, 'shop_store_desc', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'shop_store_desc'); ?>
    </div>
</div>