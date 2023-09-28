<script>
    jQuery(document).ready(function () {
        <?php if ($isAjax) { ?>
        var formSubmit = true;
        jQuery('#schedule-groups-form').on('submit', function () {
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
                        $.fn.yiiGridView.update('schedule-groups-grid');
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
    });
</script>