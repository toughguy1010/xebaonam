<div class="w3n-request">
    <h2><?php echo Yii::t('request', 'request_text'); ?></h2>
    <p class="reqest-notice"><?php echo Yii::t('request', 'request_notice'); ?></p>
    <?php
    $this->renderPartial('_form', array(
        'model' => $model,
    ));
    ?>
</div>