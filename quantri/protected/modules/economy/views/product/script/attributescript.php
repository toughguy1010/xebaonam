<script type="text/javascript">
    jQuery(function () {
        $(".contain_option_children").each(function (index) {
            if ($(this).attr('lang')) {
                var attr_id = parseInt(jQuery(this).attr('id').replace("contain_option_children_", ""));
                var op_id = jQuery('#Attribute_'+attr_id).val();
                load_child(attr_id,op_id,$(this).attr('lang'));
            }
        });
        jQuery('.has_children_option').on('change', function () {
            var attr_id = parseInt(jQuery(this).attr('id').replace("Attribute_", ""));
            var op_id = jQuery(this).val();
            var child_id = jQuery('#contain_option_children_' + attr_id).attr('lang');
            load_child(attr_id, op_id, child_id);
        });
    });

    function load_child(attr_id, op_id, child_id) {
        jQuery('.att-loading-' + attr_id).show();
        jQuery('#contain_option_children_' + attr_id).html("");
        jQuery.ajax({
            url: "<?php echo Yii::app()->createUrl("economy/productAttribute/ajaxListOpChildren") ?>",
            global: false,
            type: "POST",
            data: {'attrid': attr_id, 'opid': op_id, 'child_id': child_id},
            dataType: "html",
            success: function (data) {
                jQuery('.att-loading-' + attr_id).hide();
                var mydata = JSON.parse(data);
                if (mydata.action == "success") {
                    if (mydata.content) {
                        jQuery('#contain_option_children_' + attr_id).html(mydata.content);
                    } else {
                        jQuery('#contain_option_children_' + attr_id).html(mydata.content);
                    }
                } else if (mycart.action == "error") {
                    if (mydata.content) {
                        jQuery('#contain_option_children_' + attr_id).html(mydata.content);
                    }
                }
            }
        });
    }

    function close_new_attr(id) {
        jQuery('#new_attr_conten_' + id).css('display', 'none');
        jQuery('#is_newattr_' + id).css('display', 'inline');
        jQuery('#attribute_option_' + id).val('');
//        jQuery('#attribute_option_code'+id).val('');

    }
    function new_attr(id) {
        if (id && jQuery('#attribute_option_' + id).val() != "") {
            jQuery('.att-loading-' + id).show();
            jQuery.ajax({
                url: "<?php echo Yii::app()->createUrl("economy/productAttribute/ajaxAddOption") ?>",
                global: false,
                type: "POST",
                data: {'attrid': id, 'name': jQuery('#attribute_option_' + id).val()},
                dataType: "html",
                success: function (data) {
                    jQuery('.att-loading-' + id).hide();
                    var mycart = JSON.parse(data);
                    if (mycart.action == "success") {
                        $('#Attribute_' + id).append(mycart.content);
                    } else if (mycart.action == "error") {
                        if (mycart.content) {
                            alert(mycart.content);
                        }
                    }
                    close_new_attr(id);
                }
            });

        } else {
            alert('Bạn vui lòng nhập tên giá trị!');
            jQuery('#attribute_option_' + id).focus();
        }


    }

    function is_newattr_click(m, lang) {
        if (lang) {
            jQuery(m).css('display', 'none');
            jQuery('#new_attr_conten_' + lang).css('display', 'inline');
        }
    }


    // add option children

    function close_new_attr_child(attr_id, id) {
        jQuery('#new_attr_conten_' + attr_id + '_' + id).css('display', 'none');
        jQuery('#is_newattr_' + attr_id + '_' + id).css('display', 'inline');
        jQuery('#attribute_option_' + attr_id + '_' + id).val('');
//        jQuery('#attribute_option_code'+id).val('');

    }
    function new_attr_child(attr_id, id) {
        if (id && jQuery('#attribute_option_' + attr_id + '_' + id).val() != "") {
            jQuery('.att-loading-' + attr_id + '_' + id).show();
            jQuery.ajax({
                url: "<?php echo Yii::app()->createUrl("economy/productAttribute/ajaxAddOpChildren") ?>",
                global: false,
                type: "POST",
                data: {'opid': id, 'name': jQuery('#attribute_option_' + attr_id + '_' + id).val()},
                dataType: "html",
                success: function (data) {
                    jQuery('.att-loading-' + attr_id + '_' + id).hide();
                    var mydata = JSON.parse(data);
                    if (mydata.action == "success") {
                        $('#Attribute_option_children' + attr_id + '_' + id).append(mydata.content);
                    } else if (mydata.action == "error") {
                        if (mydata.content) {
                            alert(mydata.content);
                        }
                    }
                    close_new_attr(attr_id, id);
                }
            });

        } else {
            alert('Bạn vui lòng nhập tên giá trị!');
            jQuery('#attribute_option_' + attr_id + '_' + id).focus();
        }


    }

    function is_newattr_child_click(m, lang) {
        if (lang) {
            jQuery(m).css('display', 'none');
            jQuery('#new_attr_conten_' + lang).css('display', 'inline');
        }
    }

</script>