<?php
$comforts = TourHotel::getAllComfortsHotel();
$ary_comfort = explode(',', $model->comforts_ids);
?>

<?php if (count($comforts)) { ?>
    <div class="col-xs-12">
        <label class="control-label bolder blue"><?php echo Yii::t('tour', 'choose_comforts'); ?></label>
    </div>
    <div style="margin-top: 10px;" class="col-xs-12">
        <a href="javascript:void(0)" class="checkall">Chọn tất cả</a> ----
        <a href="javascript:void(0)" class="uncheckall">Bỏ chọn tất cả</a>
    </div>
    <?php foreach ($comforts as $comfort) { ?>
        <div class="col-xs-4 checkbox">
            <label>
                <input <?php echo in_array($comfort['id'], $ary_comfort) ? 'checked' : '' ?> name="TourHotel[comforts][]" value="<?php echo $comfort['id'] ?>" class="ace ace-checkbox-2" type="checkbox">
                <span class="lbl"> <?php echo $comfort['name'] ?></span>
            </label>
        </div>
    <?php } ?>
<?php } ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('.checkall').click(function () {
            $('.ace-checkbox-2').prop('checked', true);
        });
        $('.uncheckall').click(function () {
            $('.ace-checkbox-2').prop('checked', false);
        });
    });
</script>