<script>
    jQuery(document).ready(function () {
        jQuery('#savecompany').on('click', function () {
            if (!ta) {
                if (!confirm('<?php echo Yii::t('notice', 'uploadimage_notice'); ?>')) {
                    return false;
                }
            }
            var _this = jQuery(this);
            if (_this.hasClass('disable'))
                return false;
            _this.addClass('disable');
            var link = _this.attr('validate');
            if (link) {
                jQuery.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: link,
                    data: jQuery('#company-form').serialize(),
                    beforeSend: function () {
                        w3ShowLoading(_this, 'left', -30, 0);
                    },
                    success: function (res) {
                        if (res.code == 200) {
                            jQuery('#company-form').submit();
                        } else {
                            if (res.errors) {
                                parseJsonErrors(res.errors, jQuery('#company-form'));
                            }
                        }
                        _this.removeClass('disable');
                        w3HideLoading();
                    },
                    error: function () {
                        w3HideLoading();
                        _this.removeClass('disable');
                        return false;
                    }
                });
            }
            return false;
        });

    });
</script>