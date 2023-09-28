<style type="text/css">
    .options{
        margin-bottom: 30px;
        border: 1px solid #e3e3e3;
        padding: 20px;
        box-shadow: inset 0 1px 1px rgba(0,0,0,0.05);
    }
</style>
<div class="well well-lg clearfix">
    <h4 class="blue"><?php echo Yii::t('car', 'colors'); ?></h4>

    <div class="wrap_options_color">
        <?php
        $colors = CarColors::getAllColors($model->id);
        if (isset($colors) && count($colors)) {
            $i = 0;
            foreach ($colors as $color) {
                $i++;
                ?>
                <div class="options col-xs-12" data-fid="<?php echo $i ?>">
                    <div class="col-xs-3">
                        <label style="display: block">Màu: </label>
                        <input type="text" name="CarColorsExist[<?= $color['id'] ?>][name]" value="<?= $color['name'] ?>" />
                    </div>
                    <div class="col-xs-3">
                        <label style="display: block">Mã màu: </label>
                        <input type="text" name="CarColorsExist[<?= $color['id'] ?>][code_color]" value="<?= $color['code_color'] ?>" />
                    </div>
                    <div class="col-xs-3">
                        <label>Ảnh đại diện: </label>
                        <img style="width: 40px;margin: 0 0 0 20px;" src="<?= $color['avatar'] ?>" />
                        <input type="file" value="" name="CarColorsExist[<?= $color['id'] ?>]">
                    </div>
                    <button type="button" onclick="removeOldCarColor(this, <?= $color['id'] ?>)" class="btn btn-app btn-danger btn-xs">
                        Delete
                    </button>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="options col-xs-12" data-fid="1">
                <div class="col-xs-3">
                    <label style="display: block">Màu: </label>
                    <input type="text" name="CarColors[1][name]" value="" />
                </div>
                <div class="col-xs-3">
                    <label style="display: block">Mã màu: </label>
                    <input type="text" name="CarColors[1][code_color]" value="" />
                </div>
                <div class="col-xs-3">
                    <label>Ảnh đại diện: </label>
                    <input type="file" value="" name="CarColors[1]">
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <div class="col-xs-12">
        <button type="button" class="btn btn-success add_option_color" onclick="addhtmlcolor()"><?php echo Yii::t('car', 'create') ?></button>
    </div>

</div>

<script type="text/javascript">
    var count_tag = $('.wrap_options_color .options:last-child').attr('data-fid');
    function addhtmlcolor() {
        count_tag++;
        var html = "<div class='options col-xs-12' data-fid='" + count_tag + "'>";
        html += "<div class='col-xs-3'><label style='display: block'>Màu: </label> ";
        html += "<input type='text' name='CarColors[" + count_tag + "][name]' value='' />";
        html += "</div>";
        html += "<div class='col-xs-3'><label style='display: block'>Mã màu: </label> ";
        html += "<input type='text' name='CarColors[" + count_tag + "][code_color]' value='' />";
        html += "</div>";
        html += "<div class='col-xs-3'><label>Ảnh đại diện: </label>";
        html += "<input type='file' value='' name='CarColors[" + count_tag + "]'>";
        html += "</div>";

        $('.wrap_options_color').append(html);
    }

    function removeNewCarColor(_this) {
        $(_this).closest('.options').remove();
    }

    function removeOldCarColor(_this, color_id) {
        if (confirm('Bạn có chắc muốn xóa?')) {
            $.getJSON(
                    '<?php echo Yii::app()->createUrl('car/car/deleteColor') ?>',
                    {color_id: color_id},
                    function (data) {
                        if (data.code == 200) {
                            $(_this).closest('.options').remove();
                        }
                    }
            );
        }
    }
</script>