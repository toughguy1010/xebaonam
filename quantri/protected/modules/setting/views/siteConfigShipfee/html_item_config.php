<div class="item_config clearfix">
    <div class="item item_province">
        <label>Thành phố:</label>
        <select name="SiteConfigShipfee[province_id][<?php echo $count_tag ?>]" id="SiteConfigShipfee_province_id_<?php echo $count_tag ?>">
            <?php foreach ($listprovince as $province_id => $province_name) { ?>
                <option value="<?php echo $province_id ?>"><?php echo $province_name ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="item item_district">
        <label class="label_district">Quận huyện:</label>
        <div class="wrap_value_district">
            <select name="SiteConfigShipfee[district_id][<?php echo $count_tag ?>][]" id="SiteConfigShipfee_district_id_<?php echo $count_tag ?>">
                <?php foreach ($listdistrict as $district_id => $district_name) { ?>
                    <option value="<?php echo $district_id; ?>"><?php echo $district_name; ?></option>
                <?php } ?>
            </select>
        </div>
        <a class="add_district_bonus add_district_bonus_<?php echo $count_tag ?>" href="javascript:void(0)"><i class="addattri icon-plus"></i></a>
    </div>
    <div class="item">
        <label>Phí:</label>
        <input name="SiteConfigShipfee[price][<?php echo $count_tag ?>]" value="0" class="numberFormat" type="text" maxlength="10">
    </div>
    <div class="item">
        <a class="remove_button remove_item_config_<?php echo $count_tag ?>" href="javascript:void(0)"><i class="removeattri icon-minus"></i></a>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        jQuery('.add_district_bonus_<?php echo $count_tag ?>').click(function () {
            var stt = $(this).prev('.wrap_value_district').attr('name');
            var html = '<select name="SiteConfigShipfee[district_id][<?php echo $count_tag ?>][]">';
            var option_select = $(this).prev('.wrap_value_district').children('select').first().html();
            html += option_select;
            html += '</select>';
            $(this).prev('.wrap_value_district').append(html);
        });
        
        jQuery('.remove_item_config_<?php echo $count_tag ?>').click(function () {
            if (confirm('Bạn có chắc muốn xóa cấu hình này?')) {
                jQuery(this).parents('.item_config').remove();
            }
        });
        
    });

    jQuery(document).on('change', '#SiteConfigShipfee_province_id_<?php echo $count_tag ?>', function () {
        jQuery.ajax({
            url: '<?php echo Yii::app()->createUrl('/setting/siteConfigShipfee/getdistrict') ?>',
            data: 'pid=' + jQuery('#SiteConfigShipfee_province_id_<?php echo $count_tag ?>').val(),
            dataType: 'JSON',
            beforeSend: function () {
                w3ShowLoading(jQuery('#SiteConfigShipfee_province_id_<?php echo $count_tag ?>'), 'right', 20, 0);
            },
            success: function (res) {
                if (res.code == 200) {
                    jQuery('#SiteConfigShipfee_district_id_<?php echo $count_tag ?>').html(res.html);
                }
                w3HideLoading();
            },
            error: function () {
                w3HideLoading();
            }
        });
    });

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
</script>