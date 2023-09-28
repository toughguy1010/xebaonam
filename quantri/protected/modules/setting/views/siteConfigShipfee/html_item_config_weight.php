<div class="item_config clearfix">
    <div class="item item_province">
        <label>Từ:</label>
        <input type="text" name="SiteConfigShipfeeWeight[<?php echo $count_tag ?>][from]" />
    </div>
    <div class="item item_district">
        <label class="label_district">Đến nhỏ hơn hoặc bằng:</label>
        <input type="text" name="SiteConfigShipfeeWeight[<?php echo $count_tag ?>][to]" />
    </div>
    <div class="item">
        <label>Phí:</label>
        <input class="numberFormat" name="SiteConfigShipfeeWeight[<?php echo $count_tag ?>][price]" type="text" maxlength="10">
    </div>
    <div class="item">
        <a class="remove_button remove_item_config_weight_<?php echo $count_tag ?>" href="javascript:void(0)"><i class="removeattri icon-minus"></i></a>
    </div>
</div>
<script type="text/javascript">
    
    $(document).ready(function () {
        jQuery('.remove_item_config_weight_<?php echo $count_tag ?>').click(function () {
            if (confirm('Bạn có chắc muốn xóa cấu hình này?')) {
                jQuery(this).parents('.item_config').remove();
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