<style type="text/css">
    .item_config{ padding: 15px; border-bottom: 1px solid #eeeeee; }
    .item_config .item{ float: left; margin-right: 25px; }
    .add_district_bonus{ font-size: 18px; margin-left: 10px; display: inline-block; color: #428bca; }
    .remove_district_bonus{ font-size: 18px; margin-left: 10px; display: inline-block; color: #ff0000; }
    .remove_district_bonus:hover{ color: #ff2d2d; }
    .remove_item_config, .remove_item_config_weight{color: #ff0000; font-size: 18px;}
    .remove_item_config:hover, .remove_item_config_weight:hover{color: #ff2d2d}
    .wrap_value_district{ display: inline-block; }
    .wrap_value_district select{ display: block; margin-bottom: 5px; width: 150px; }
    .label_district{ display: block; float: left; margin-right: 5px; }
    .item_province select{ width: 150px; }
    .remove_button{color: #ff0000; font-size: 18px;}
    .remove_button:hover{color: #ff0000; font-size: 18px;}
</style>
<div class="widget widget-box">
    <div class="widget-header">
        <h4><?php echo Yii::t('site', 'manage_config_shipfee'); ?></h4>
        <div class="widget-toolbar no-border">
            <a class="btn btn-xs btn-primary" id="saveshipfee" href="javascript:void(0)">
                <i class="icon-ok"></i>
                <?php echo Yii::t('common', 'save') ?>
            </a>
        </div>
    </div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <?php
            $this->renderPartial('_form', array(
                'model' => $model,
                'listprovince' => $listprovince,
                'listdistrict' => $listdistrict,
                'data' => $data,
                'data_weight' => $data_weight,
                    )
            );
            ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    var count_tag = $('.wrapper_config_shipfee').children('.item_config').length;
    $(document).ready(function () {
        jQuery('.add_district_bonus_1').click(function () {
            var html = '<select name="SiteConfigShipfee[district_id][1][]">';
            var option_select = $(this).prev('.wrap_value_district').children('select').first().html();
            html += option_select;
            html += '</select>';
            $(this).prev('.wrap_value_district').append(html);
        });

        jQuery('.add_config_shipfee').click(function () {
            ++count_tag;
            jQuery.getJSON(
                    "<?php echo Yii::app()->createUrl('setting/siteConfigShipfee/htmlItemconfig'); ?>",
                    {count_tag: count_tag},
                    function (data) {
                        $('.wrapper_config_shipfee').append(data.html);
                    }
            );
        });

        jQuery('.remove_item_config').click(function () {
            if (confirm('Bạn có chắc muốn xóa cấu hình này?')) {
                jQuery(this).parents('.item_config').remove();
            }
        });
        
        $('#saveshipfee').click(function() {
            $('#site-settings-shipfee-form').submit();
        });

    });

    jQuery(document).on('change', '#SiteConfigShipfee_province_id_1', function () {
        jQuery.ajax({
            url: '<?php echo Yii::app()->createUrl('/setting/siteConfigShipfee/getdistrict') ?>',
            data: 'pid=' + jQuery('#SiteConfigShipfee_province_id_1').val(),
            dataType: 'JSON',
            beforeSend: function () {
                w3ShowLoading(jQuery('#SiteConfigShipfee_province_id_1'), 'right', 20, 0);
            },
            success: function (res) {
                if (res.code == 200) {
                    jQuery('#SiteConfigShipfee_district_id_1').html(res.html);
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