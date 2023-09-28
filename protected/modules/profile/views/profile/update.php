<h3 class="username-title"><?php echo Yii::t('user', 'user_update_profile'); ?></h3>
<?php
$this->renderPartial('_form', array(
    'model' => $model,
    'listprivince' => $listprivince,
    'listdistrict' => $listdistrict,
        )
);
?>