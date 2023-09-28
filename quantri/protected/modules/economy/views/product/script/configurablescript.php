<style>
    #product-attributes-cf .controls{margin-left: 0px;}
    #product-attributes-cf .action{line-height: 30px;padding-top: 5px;}
    /*    #product-attributes-cf .action *{font-size: 12px;}*/
    #product-attributes-cf .action i{margin: 10px 5px; cursor: pointer; float: left;}
    #product-attributes-cf .cf-row{margin-top: 8px;}
    #product-attributes-cf .cf-row input{margin-right: 20px;}
    #product-attributes-cf .cf-row-head{margin-top: 8px;}
    #product-attributes-cf .cf-row-head span.head-t{margin-right: 20px;}
    #product-attributes-cf .cf-row-head span.head-d{margin-right: 20px;text-align: center;}
</style>
<script type="text/javascript">
    var count_new = 0;
    var count_cf = <?php echo $count_cf; ?>;
    var tmp_att_1 = '<?php if (isset($attributes_cf[0])) echo str_replace(array('\r\n', "\n"), '', CHtml::dropDownList('attribute_cf[new][count_new][' . $attributes_cf[0]->field_configurable . ']', '', CHtml::listData($attributes_cf[0]->getAttributeOption(), 'index_key', 'value'), array('empty' => '-- Lựa chọn --', 'class' => '', 'style' => 'width:100%;'))); ?>';
    var tmp_att_2 = '<?php if (isset($attributes_cf[1])) echo str_replace(array('\r\n', "\n"), '', CHtml::dropDownList('attribute_cf[new][count_new][' . $attributes_cf[1]->field_configurable . ']', '', CHtml::listData($attributes_cf[1]->getAttributeOption(), 'index_key', 'value'), array('empty' => '-- Lựa chọn --', 'class' => '', 'style' => 'width:100%;'))); ?>';
    var tmp_att_3 = '<?php if (isset($attributes_cf[2])) echo str_replace(array('\r\n', "\n"), '', CHtml::dropDownList('attribute_cf[new][count_new][' . $attributes_cf[2]->field_configurable . ']', '', CHtml::listData($attributes_cf[2]->getAttributeOption(), 'index_key', 'value'), array('empty' => '-- Lựa chọn --', 'class' => '', 'style' => 'width:100%;'))); ?>';
    var type_option = "";
    var htmlOp = '';
    jQuery(document).on('click', '.addattri', function () {
        var length = jQuery('#product-attributes-cf').find('.cf-row').length;
        if (length == 1) {
            jQuery('#product-attributes-cf').find('.cf-row').find('.removeattri').css({'display': 'inline-block'});
        }
        var thi = jQuery(this);
        count_new++;
        htmlOp = '<div class="control-group form-group cf-row">';
        htmlOp += '<div class="col-sm-2">' + tmp_att_1.replace("count_new", count_new) + '</div>';
        htmlOp += (tmp_att_2) ? '<div class="col-sm-2">' + tmp_att_2.replace("count_new", count_new) + '</div>' : '';
        htmlOp += (tmp_att_3) ? '<div class="col-sm-2">' + tmp_att_3.replace("count_new", count_new) + '</div>' : '';
        htmlOp += '<div class="col-sm-2 att-pro-price"><input type="text" id="attribute_cf_new_4" class="numberFormat" name="attribute_cf[new][' + count_new + '][4]" value="" style="width:90%;" maxlength="15"></div>';
        htmlOp += '<div class="col-sm-4 att-pro-images att-pro-image-' + count_new + '"></div>';
        htmlOp += '<span class=\"col-sm-1 help-inline action\"><i class=\"addattri icon-plus\"></i><i class=\"removeattri icon-minus\"></i></span>';
        htmlOp += '<div style="clear: both"></div>';
        htmlOp += '<div id="algalley_configurable_' + count_new + '" class="algalley"><div class="alimgbox"><div class="alimglist"></div></div></div>';
        htmlOp += '</div>';
        jQuery(thi).parents('.cf-row').after(htmlOp);
        $.getJSON(
                'economy/product/renderImageConfig',
                {'count_new': count_new},
                function (data) {
                    $('.att-pro-image-' + count_new).html(data.html);
                });
        return false;
    });

    jQuery(document).on('click', '.removeattri', function () {
        var length = jQuery('#product-attributes-cf').find('.cf-row').length;
//        if (length > 1) {
        var thi = jQuery(this);
        if (jQuery(thi).parents('.cf-row').hasClass('cfupdate')) {
            jQuery(thi).parents('#product-attributes-cf').append('<input name=\"attribute_cf[delete][' + jQuery(thi).parents('.cf-row').attr('id') + ']\" type=\"hidden\" value=\"' + jQuery(thi).parents('.cf-row').attr('id') + '\">');
        }
        jQuery(thi).parents('.cf-row').remove();
//            if (length == 2)
//                jQuery('#product-attributes-cf').find('.cf-row').find('.removeattri').fadeOut('fast');
//        }
        return false;
    });
    
    jQuery(document).on('click', '.addattri-new', function () {
        var length = jQuery('#product-attributes-cf').find('.cf-row').length;
        if (length == 1) {
            jQuery('#product-attributes-cf').find('.cf-row').find('.removeattri').css({'display': 'inline-block'});
        }
        var thi = jQuery(this);
        count_new++;
        htmlOp = '<div class="control-group form-group cf-row">';
        htmlOp += '<div class="col-sm-2">' + tmp_att_1.replace("count_new", count_new) + '</div>';
        htmlOp += (tmp_att_2) ? '<div class="col-sm-2">' + tmp_att_2.replace("count_new", count_new) + '</div>' : '';
        htmlOp += (tmp_att_3) ? '<div class="col-sm-2">' + tmp_att_3.replace("count_new", count_new) + '</div>' : '';
        htmlOp += '<div class="col-sm-2 att-pro-price"><input type="text" id="attribute_cf_new_4" class="numberFormat" name="attribute_cf[new][' + count_new + '][4]" value="" style="width:100%;" maxlength="15"></div>';
        htmlOp += '<div class="col-sm-2"><input type="text" id="attribute_cf_new_4" class="numberFormat" name="attribute_cf[new][' + count_new + '][5]" value="" style="width:100%;" maxlength="15"></div>';
        htmlOp += '<div class="col-sm-2"><input type="text" id="attribute_cf_new_4" name="attribute_cf[new][' + count_new + '][6]" value="" style="width:100%;" maxlength="15"></div>';
        htmlOp += '<span class=\"col-sm-2 help-inline action\"><i class=\"addattri icon-plus\"></i><i class=\"removeattri icon-minus\"></i></span>';
        htmlOp += '<div style="clear: both"></div>';
        htmlOp += '<div id="algalley_configurable_' + count_new + '" class="algalley"><div class="alimgbox"><div class="alimglist"></div></div></div>';
        htmlOp += '</div>';
        jQuery(thi).parents('.cf-row').after(htmlOp);
        $.getJSON(
                'economy/product/renderImageConfig',
                {'count_new': count_new},
                function (data) {
                    $('.att-pro-image-' + count_new).html(data.html);
                });
        return false;
    });

</script>