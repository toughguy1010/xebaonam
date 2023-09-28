<?php
if (isset($allownull) && $allownull) {
    ?>
    <option value="all"><?php echo Yii::t('common', 'choose_all'); ?></option>
<?php } ?>
<?php
foreach ($listward as $ward) {
    ?>
    <option value="<?php echo $ward['ward_id'] ?>" latlng="<?php echo $ward['latlng']; ?>"><?php echo $ward['name']; ?></option>
<?php } ?>
