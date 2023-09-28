<script>
    var choicedproducts = <?php echo json_encode(array_filter(explode(',', $model_info_news))) ?>;
    //
    jQuery(document).ready(function () {
        jQuery('#btnProductSave').on('click', function () {
            if (choicedproducts.length <= 0) {
                jQuery('#choicedProducts').val('');
                return true;
            } else {
                jQuery('#choicedProducts').val(choicedproducts.join(','));
                return true;
            }
        });
        <?php if ($isAjax) { ?>
        var formSubmit = true;
        jQuery('#consultant-groups-form').on('submit', function () {
            if (!formSubmit)
                return false;
            formSubmit = false;
            var thi = jQuery(this);
            jQuery.ajax({
                'type': 'POST',
                'dataType': 'JSON',
                'beforeSend': function () {
                    w3ShowLoading(jQuery('#btnProductSave'), 'left', -40, 0);
                },
                'url': thi.attr('action'),
                'data': thi.serialize(),
                'success': function (res) {
                    if (res.code != "200") {
                        if (res.errors) {
                            parseJsonErrors(res.errors);
                        }
                    } else {
                        $.fn.yiiGridView.update('consultant-groups-grid');
                        $.colorbox.close();
                    }
                    w3HideLoading();
                    formSubmit = true;
                },
                'error': function () {
                    w3HideLoading();
                    formSubmit = true;
                }
            });
            return false;
        });
        <?php } ?>
        //
    });
    //
    function AddToChoice(id, obj) {
        var obj = jQuery(obj);
        obj.addClass('hidden');
        var next = obj.next();
        if (next)
            next.removeClass('hidden');
        var tr = obj.closest('tr');
        //
        var html = '<tr id="pro' + id + '">' + tr.html() + '</tr>';
        tr.remove();
        if (jQuery('#pro' + id).length > 0)
            return false;
        choicedproducts.push(id);
        jQuery('#choicedproduct .products').find('tbody').prepend(html);
        return false;
    }
    //
    function RemoveChoice(id, obj) {
        //alert(choicedproducts.join(','));
        choicedproducts = jQuery.grep(choicedproducts, function (a) {
            return a !== id;
        });
        var obj = jQuery(obj);
        obj.closest('tr').remove();
        return false;
    }
</script>