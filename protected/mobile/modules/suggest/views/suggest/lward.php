<?php
$t = Yii::app()->request->getParam('t');
if ($t && $t == 'filter' or !$t) {
    ?>
    <option value=""><?php echo Yii::t('common', 'undefined'); ?></option>
<?php } ?>
<?php
foreach ($listward as $ward) {
    ?>
    <option value="<?php echo $ward['ward_id'] ?>" latlng="<?php echo $ward['latlng'];?>"><?php echo $ward['name']; ?></option>
<?php } ?>
