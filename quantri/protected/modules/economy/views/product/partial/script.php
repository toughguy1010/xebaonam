<script>
    var choicedproducts = [];
    //
    jQuery(document).ready(function() {
        jQuery('#btnProductSave').on('click', function() {
            if (choicedproducts.length <= 0)
                return false;
            jQuery('#choicedProducts').val(choicedproducts.join(','));
            if(jQuery(this).hasClass('imageTag')){
                var addHtml = jQuery(this).closest('form').find('table tbody').html();
                jQuery('.show-tag .itpData.active tbody').append(addHtml);
            }
            return true;
        });
        <?php if ($isAjax) { ?>
        var formSubmit = true;
        jQuery('#product-groups-form').on('submit', function() {
            if (!formSubmit)
                return false;
            formSubmit = false;
            var thi = jQuery(this);
            jQuery.ajax({
                'type': 'POST',
                'dataType': 'JSON',
                'beforeSend': function() {
                    w3ShowLoading(jQuery('#btnProductSave'), 'left', -40, 0);
                },
                'url': thi.attr('action'),
                'data': thi.serialize(),
                'success': function(res) {
                    if (res.code != "200") {
                        if (res.msg) {
                            alert(res.msg);
                        }
                        if (res.errors) {
                            parseJsonErrors(res.errors);
                        }
                    } else {
                        $.fn.yiiGridView.update('product-groups-grid');
                        $.fn.yiiGridView.update('product-groups-grid-1');
                        $.fn.yiiGridView.update('product-groups-grid-2');
                        $.colorbox.close();
                    }
                    w3HideLoading();
                    formSubmit = true;
                },
                'error': function() {
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
        var html = '<tr class="new" id="pro' + id + '" data-product="'+id+'">' + tr.html() + '</tr>';
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
        choicedproducts = jQuery.grep(choicedproducts, function(a) {
            return a !== id;
        });
        var obj = jQuery(obj);
        obj.closest('tr').remove();
        return false;
    }
</script>