<div class="form-group no-margin-left">
    <?php echo $form->labelEx($productInfo, 'product_sortdesc', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <input name="us-ck" type="checkbox" id="ck-check" value="" style="">
        <label for="ck-check" style="font-size: 11px;color: blue;font-weight: bold">Sử dụng trình soạn thảo</label>
        <?php echo $form->textArea($productInfo, 'product_sortdesc', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($productInfo, 'product_sortdesc'); ?>
    </div>
</div>

<script>
    jQuery(document).ready(function () {
        $('#ck-check').on("click", function () {
            if (this.checked) {
                CKEDITOR.replace("ProductInfo_product_sortdesc", {
                    height: 400,
                    language: '<?php echo Yii::app()->language ?>'
                });
            } else {
                var a = CKEDITOR.instances['ProductInfo_product_sortdesc'];
                if (a) {
                    a.destroy(true);
                }

            }
        });
        $('#ck-check2').on("click", function () {
            if (this.checked) {
                CKEDITOR.replace("ProductInfo_product_note", {
                    height: 400,
                    language: '<?php echo Yii::app()->language ?>'
                });
            } else {
                var a = CKEDITOR.instances['ProductInfo_product_note'];
                if (a) {
                    a.destroy(true);
                }

            }
        });
    });
</script>


<div class="form-group no-margin-left">
    <?php echo $form->labelEx($productInfo, 'product_desc', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($productInfo, 'product_desc', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($productInfo, 'product_desc'); ?>
    </div>
</div>

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($productInfo, 'product_note', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <input name="us-ck" type="checkbox" id="ck-check2" value="" style="">
        <label for="ck-check2" style="font-size: 11px;color: blue;font-weight: bold">Sử dụng trình soạn thảo</label>
        <?php echo $form->textArea($productInfo, 'product_note', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($productInfo, 'product_note'); ?>
    </div>
</div>
