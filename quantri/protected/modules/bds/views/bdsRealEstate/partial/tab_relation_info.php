<style type="text/css">
    .wrap_relation{
        border: 1px solid #eeeeee;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
</style>
<?php
/**
 * Chọn những tiện ích có sẵn trong bất động sản đăng
 */
$comforts = BdsComforts::getAllComforts();
$ary_comfort = explode(',', $model->comforts);
?>
<?php if (count($comforts)) { ?>
    <div class="wrap_relation clearfix">
        <div class="col-xs-12">
            <label class="control-label bolder blue"><?php echo Yii::t('bds_real_estate', 'choose_comforts'); ?></label>
        </div>
        <div style="margin-top: 10px;" class="col-xs-12">
            <a href="javascript:void(0)" class="checkall_comforts">Chọn tất cả</a> ----
            <a href="javascript:void(0)" class="uncheckall_comforts">Bỏ chọn tất cả</a>
        </div>
        <?php foreach ($comforts as $comfort) { ?>
            <div class="col-xs-4 checkbox">
                <label>
                    <input <?php echo in_array($comfort['id'], $ary_comfort) ? 'checked' : '' ?> name="BdsRealEstate[comforts][]" value="<?php echo $comfort['id'] ?>" class="ace ace-checkbox-2 checkbox-comfort" type="checkbox">
                    <span class="lbl"> <?php echo $comfort['name'] ?></span>
                </label>
            </div>
        <?php } ?>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.checkall_comforts').click(function () {
                $('.checkbox-comfort').prop('checked', true);
            });
            $('.uncheckall_comforts').click(function () {
                $('.checkbox-comfort').prop('checked', false);
            });
        });
    </script>
<?php } ?>


<?php
/**
 * Chọn môi trường xung quanh bất động sản
 */
$environments = BdsEnvironment::getAllEnvironments();
$ary_environment = explode(',', $model->environments);
?>
<?php if (count($environments)) { ?>
    <div class="wrap_relation clearfix">
        <div class="col-xs-12">
            <label class="control-label bolder blue"><?php echo Yii::t('bds_real_estate', 'choose_environments'); ?></label>
        </div>
        <div style="margin-top: 10px;" class="col-xs-12">
            <a href="javascript:void(0)" class="checkall_environment">Chọn tất cả</a> ----
            <a href="javascript:void(0)" class="uncheckall_environment">Bỏ chọn tất cả</a>
        </div>
        <?php foreach ($environments as $environment) { ?>
            <div class="col-xs-4 checkbox">
                <label>
                    <input <?php echo in_array($environment['id'], $ary_environment) ? 'checked' : '' ?> name="BdsRealEstate[environments][]" value="<?php echo $environment['id'] ?>" class="ace ace-checkbox-2 checkbox-environment" type="checkbox">
                    <span class="lbl"> <?php echo $environment['name'] ?></span>
                </label>
            </div>
        <?php } ?>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.checkall_environment').click(function () {
                $('.checkbox-environment').prop('checked', true);
            });
            $('.uncheckall_environment').click(function () {
                $('.checkbox-environment').prop('checked', false);
            });
        });
    </script>
<?php } ?>

<?php
/**
 * Chọn thiết bị có sẵn
 */
$equipments = BdsEquipment::getAllEquipments();
$ary_equipment = explode(',', $model->equipments);
?>
<?php if (count($equipments)) { ?>
    <div class="wrap_relation clearfix">
        <div class="col-xs-12">
            <label class="control-label bolder blue"><?php echo Yii::t('bds_real_estate', 'choose_equipments'); ?></label>
        </div>
        <div style="margin-top: 10px;" class="col-xs-12">
            <a href="javascript:void(0)" class="checkall_equipment">Chọn tất cả</a> ----
            <a href="javascript:void(0)" class="uncheckall_equipment">Bỏ chọn tất cả</a>
        </div>
        <?php foreach ($equipments as $equipment) { ?>
            <div class="col-xs-4 checkbox">
                <label>
                    <input <?php echo in_array($equipment['id'], $ary_equipment) ? 'checked' : '' ?> name="BdsRealEstate[equipments][]" value="<?php echo $equipment['id'] ?>" class="ace ace-checkbox-2 checkbox-equipment" type="checkbox">
                    <span class="lbl"> <?php echo $equipment['name'] ?></span>
                </label>
            </div>
        <?php } ?>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.checkall_equipment').click(function () {
                $('.checkbox-equipment').prop('checked', true);
            });
            $('.uncheckall_equipment').click(function () {
                $('.checkbox-equipment').prop('checked', false);
            });
        });
    </script>
<?php } ?>




