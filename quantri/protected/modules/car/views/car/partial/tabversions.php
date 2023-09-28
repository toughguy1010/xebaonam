<?php
$versions = CarVersions::getAllVersions($model->id, 'id, name, price, description');
?>

<style type="text/css">
    .wrap_versions{
        margin-bottom: 30px;
    }
    .item-version{
        margin-bottom: 30px;
        border: 1px solid #e3e3e3;
        padding: 20px;
        box-shadow: inset 0 1px 1px rgba(0,0,0,0.05);
    }
</style>
<div class="well well-lg clearfix">
    <h4 class="blue"><?php echo Yii::t('car', 'version'); ?></h4>

    <div class="wrap_versions clearfix">
        <?php
        if (count($versions)) {
            foreach ($versions as $version) {
                ?>
                <div class="item-version col-xs-12">
                    <div class="col-xs-3">
                        <label style="display: block">Tên phiên bản: </label> 
                        <input type="text" name="CarVersionsExist[<?php echo $version['id'] ?>][name]" value="<?php echo $version['name'] ?>" />
                    </div>
                    <div class="col-xs-3">
                        <label style="display: block">Giá: </label> 
                        <input class="numberFormat" type="text" name="CarVersionsExist[<?php echo $version['id'] ?>][price]" value="<?php echo number_format($version['price'], 0, '', '.'); ?>" />
                    </div>
                    <div class="col-xs-5">
                        <label style="display: block">Mô tả: </label> 
                        <textarea class="span12 col-sm-12" name="CarVersionsExist[<?php echo $version['id'] ?>][description]"><?php echo $version['description'] ?></textarea>
                    </div>
                    <div class="col-xs-1">
                        <label style="display: block;">&nbsp;</label>
                        <a onclick="removeOldVersion(this, <?php echo $version['id'] ?>)" class="btn btn-danger btn-sm">Xóa</a>
                    </div>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="item-version col-xs-12">
                <div class="col-xs-3">
                    <label style="display: block">Tên phiên bản: </label> 
                    <input type="text" name="CarVersions[1][name]" value="" />
                </div>
                <div class="col-xs-3">
                    <label style="display: block">Giá: </label> 
                    <input class="numberFormat" type="text" name="CarVersions[1][price]" value="" />
                </div>
                <div class="col-xs-5">
                    <label style="display: block">Mô tả: </label> 
                    <textarea class="span12 col-sm-12" name="CarVersions[1][description]"></textarea>
                </div>
                <div class="col-xs-1">
                    <label style="display: block;">&nbsp;</label>
                    <a onclick="removeNewVersion(this)" class="btn btn-danger btn-sm">Xóa</a>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="col-xs-12">
        <button type="button" class="btn btn-success" onclick="addversion()"><?php echo Yii::t('car', 'add_new_version') ?></button>
    </div>
</div>
<script type="text/javascript">
    var count_versions = $('.wrap_versions').children('.item-version').length;

    function addversion() {
        count_versions++;
        var html = "<div class='item-version col-xs-12'>";
        html += "<div class='col-xs-3'>";
        html += "<label style='display: block'>Tên phiên bản: </label> ";
        html += "<input type='text' name='CarVersions[" + count_versions + "][name]' value='' />";
        html += "</div>";
        html += "<div class='col-xs-3'>";
        html += "<label style='display: block'>Giá: </label>";
        html += "<input class='numberFormat' type='text' name='CarVersions[" + count_versions + "][price]' value='' />";
        html += "</div>";
        html += "<div class='col-xs-5'>";
        html += "<label style='display: block'>Mô tả: </label>";
        html += "<textarea class='span12 col-sm-12' name='CarVersions[" + count_versions + "][description]'></textarea>";
        html += "</div>";
        html += "<div class='col-xs-1'>";
        html += '<label style="display: block;">&nbsp;</label>';
        html += '<a onclick="removeNewVersion(this)" class="btn btn-danger btn-sm">Xóa</a>';
        html += "</div>";

        $('.wrap_versions').append(html);
        jQuery(".numberFormat").keypress(function (e) {
            return w3n.numberOnly(e);
        }).keyup(function (e) {
            var value = $(this).val();
            if (value != '') {
                var valueTemp = w3n.ToNumber(value);
                var formatNumber = w3n.FormatNumber(valueTemp);
                if (value != formatNumber)
                    $(this).val(formatNumber);
            }
        });
    }

    function removeNewVersion(_this) {
        $(_this).closest('.item-version').remove();
    }

    function removeOldVersion(_this, version_id) {
        if (confirm('Bạn có chắc muốn xóa?')) {
            $.getJSON(
                    '<?php echo Yii::app()->createUrl('car/car/deleteVersion') ?>',
                    {version_id: version_id},
                    function (data) {
                        if (data.code == 200) {
                            $(_this).closest('.item-version').remove();
                        }
                    }
            );
        }
    }

</script>