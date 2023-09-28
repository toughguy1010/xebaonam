<?php if (isset($data) && $data) { ?>
    <div class="result-group">
       <?php echo Yii::t('tour', 'tour_category'); ?>
    </div>
    <?php
    $this->renderPartial('result_item', array('data' => $data));
    ?>
<?php } ?>