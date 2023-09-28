<script type="text/javascript">
    var choicedproducts_manual = [];
    //
    jQuery(document).ready(function () {
        jQuery('#btnProductSave_manual').on('click', function () {

            if (choicedproducts_manual.length <= 0) {
                return false;
            }
            jQuery('#choicedProducts_manual').val(choicedproducts_manual.join(','));
            return true;

        });
         <?php if ($isAjax) { ?>
        var formSubmit = true;
        jQuery('#news-groups-form-manual').on('submit', function () {
            if (!formSubmit) {
                return false;
            }
            formSubmit = false;

            var thi = jQuery(this);

            jQuery.ajax({
                'type': 'POST',
                'dataType': 'JSON',
                'beforeSend': function () {
                    w3ShowLoading(jQuery('#btnProductSave_manual'), 'left', -40, 0);
                },
                'url': thi.attr('action'),
                'data': thi.serialize(),
                'success': function (res) {
                    if (res.code != "200") {
                        if (res.errors) {
                            parseJsonErrors(res.errors);
                        }
                    } else {

                        $.fn.yiiGridView.update('news-groups-grid-manual');
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
        choicedproducts_manual.push(id);
        jQuery('#choicedproduct_manual .products_manual').find('tbody').prepend(html);
        return false;
    }
    //
    function RemoveChoice(id, obj) {
        //alert(choicedproducts.join(','));
        choicedproducts_manual = jQuery.grep(choicedproducts_manual, function (a) {
            return a !== id;
        });
        var obj = jQuery(obj);
        obj.closest('tr').remove();
        return false;
    }
</script>