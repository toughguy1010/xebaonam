<script>
    var choicednews = <?php echo json_encode(array_filter(explode(',', $model_info_news))) ?>;
    //
    jQuery(document).ready(function () {
        jQuery('#btnNewsSave').on('click', function () {
            if (choicednews.length <= 0) {
                jQuery('#choicedNews').val('');
                return true;
            } else {
                jQuery('#choicedNews').val(choicednews.join(','));
                return true;
            }
        });
        <?php if ($isAjax) { ?>
        var formSubmit = true;
        jQuery('#news-groups-form').on('submit', function () {
            if (!formSubmit)
                return false;
            formSubmit = false;
            var thi = jQuery(this);
            jQuery.ajax({
                'type': 'POST',
                'dataType': 'JSON',
                'beforeSend': function () {
                    w3ShowLoading(jQuery('#btnNewsSave'), 'left', -40, 0);
                },
                'url': thi.attr('action'),
                'data': thi.serialize(),
                'success': function (res) {
                    if (res.code != "200") {
                        if (res.errors) {
                            parseJsonErrors(res.errors);
                        }
                    } else {
                        $.fn.yiiGridView.update('news-groups-grid');
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
        choicednews.push(id);
        jQuery('#choicednews .news').find('tbody').prepend(html);
        return false;
    }
    //
    function RemoveChoice(id, obj) {
        //alert(choicednews.join(','));
        choicednews = jQuery.grep(choicednews, function (a) {
            return a !== id;
        });
        var obj = jQuery(obj);
        obj.closest('tr').remove();
        return false;
    }
</script>