<?php
if (isset($allownull) && $allownull) {
    ?>
    <option value=""><?php echo Yii::t('service', 'choose_provider'); ?></option>
<?php } ?>
<?php
foreach ($providers as $provider) {
    ?>
    <option value="<?php echo $provider['id'] ?>"><?php echo $provider['name']; ?></option>
<?php } ?>
