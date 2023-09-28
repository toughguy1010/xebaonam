<style>
    #product-attributes-changeprice .controls{margin-left: 0px;}
    #product-attributes-changeprice .action{line-height: 30px;padding-top: 5px;}
    /*    #product-attributes-changeprice .action *{font-size: 12px;}*/
    #product-attributes-changeprice .action i{margin: 10px 5px; cursor: pointer; float: left;}
    #product-attributes-changeprice .changeprice-row{margin-top: 8px;}
    #product-attributes-changeprice .changeprice-row input{margin-right: 20px;}
    #product-attributes-changeprice .changeprice-row-head{margin-top: 8px;}
    #product-attributes-changeprice .changeprice-row-head span.head-t{margin-right: 20px;}
    #product-attributes-changeprice .changeprice-row-head span.head-d{margin-right: 20px;text-align: center;}
</style>
<script type="text/javascript">
    var count_new = 0;
    var count_changeprice = <?php echo $count_changeprice; ?>;    
    var type_option = "";
    var htmlOp = '';
    var tmp_att_dropdown = '';
    jQuery(document).on('click', '.addattri', function () {
        var length = jQuery('#product-attributes-changeprice').find('.changeprice-row').length;
        if (length == 1) {
            jQuery('#product-attributes-changeprice').find('.changeprice-row').find('.removeattri').css({'display': 'inline-block'});
        }
        var thi = jQuery(this);
        count_new++;        
        tmp_att_dropdown = jQuery(thi).parents('.changeprice-row').html();
        tmp_att_dropdown = tmp_att_dropdown.replace('selected="selected"','');        
        tmp_att_dropdown = tmp_att_dropdown.replace(/attribute_changeprice\[new\]\[\d\]/g,'attribute_changeprice[new]['+count_new+']');               
        tmp_att_dropdown = tmp_att_dropdown.replace(/attribute_changeprice_new_\d/g,'attribute_changeprice_new_'+count_new);               
        tmp_att_dropdown = tmp_att_dropdown.replace(/attribute_changeprice\[update\]\[\d\]/g,'attribute_changeprice[new]['+count_new+']'); 
        tmp_att_dropdown = tmp_att_dropdown.replace(/attribute_changeprice_update_\d/g,'attribute_changeprice_new_'+count_new);                                  
        htmlOp = '<div class="control-group form-group changeprice-row">';
        htmlOp += tmp_att_dropdown;        
        htmlOp += '</div>';        
        jQuery(thi).parents('.changeprice-row').after(htmlOp);        
        return false;
    });

    jQuery(document).on('click', '.removeattri', function () {
        var length = jQuery('#product-attributes-changeprice').find('.changeprice-row').length;
        if (length > 1) {
            var thi = jQuery(this);
            if (jQuery(thi).parents('.changeprice-row').hasClass('changepriceupdate')) {
                jQuery(thi).parents('#product-attributes-changeprice').append('<input name=\"attribute_changeprice[delete][' + jQuery(thi).parents('.changeprice-row').attr('id') + ']\" type=\"hidden\" value=\"' + jQuery(thi).parents('.changeprice-row').attr('id') + '\">');
            }
            jQuery(thi).parents('.changeprice-row').remove();
            if (length == 2)
                jQuery('#product-attributes-changeprice').find('.changeprice-row').find('.removeattri').fadeOut('fast');
        }
        return false;
    });

</script>