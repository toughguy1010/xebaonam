<?php if (isset($data) && $data) { ?>
    <div class="result-group">
        <?php echo Yii::t('product', 'product'); ?>
    </div>
    <?php
    $this->renderPartial('result_item', array('data' => $data));
    ?>
<?php } ?>