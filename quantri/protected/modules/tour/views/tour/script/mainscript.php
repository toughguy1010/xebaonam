<script>
    jQuery(document).ready(function() {
        $('#algalley .alimglist').imagesLoaded(function() {

            jQuery('#myTab li a').on('click', function() {
                if (!ta)
                    return false;
                var href = $(this).attr('href');
                if (href == '#imagevideo') {
                    if (jQuery('#imagevideo').hasClass('showed')) {
                        return;
                    } else {
                        jQuery('#imagevideo').addClass('showed');
                        setTimeout(function() {
                            updateImgBox();
                        }, 100);
                    }
                }
            });
        });


        jQuery('#savetour').on('click', function() {
            if (!ta) {
                if (!confirm('<?php echo Yii::t('notice', 'uploadimage_notice'); ?>'))
                    return false;
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
                    data: jQuery('#tour-form').serialize(),
                    beforeSend: function() {
                        w3ShowLoading(_this, 'left', -30, 0);
                    },
                    success: function(res) {
                        if (res.code == 200) {
                            jQuery('#tour-form').submit();
                        } else {
                            if (res.errors) {
                                parseJsonErrors(res.errors, jQuery('#tour-form'));
                            }
                        }
                        _this.removeClass('disable');
                        w3HideLoading();
                    },
                    error: function() {
                        w3HideLoading();
                        _this.removeClass('disable');
                        return false;
                    }
                });
            }
            return false;
        });

    });
    jQuery(document).on('click', '.new_delimgaction', function() {
        jQuery(this).closest('.alimgitem').remove();
        updateImgBox();
        return false;
    });
    jQuery(document).on('click', '.delimgaction', function() {
        if (confirm('<?php echo Yii::t('album', 'album_delete_image_confirm'); ?>')) {
            var thi = $(this);
            var href = thi.attr('href');
            if (href) {
                jQuery.ajax({
                    url: href,
                    type: 'POST',
                    dataType: 'JSON',
                    success: function(res) {
                        if (res.code == 200) {
                            jQuery(thi).closest('.alimgitem').remove();
                            updateImgBox();
                        }
                    }
                });
            }
        }
        return false;
    });
    jQuery(document).on('click', '.alimgitembox', function() {
        $('#algalley .alimgitem').removeClass('active');
        $(this).closest('.alimgitem').addClass('active');
        $(this).find('.alimgaction').find('input[type=radio]').prop('checked', true);
    });
    function updateImgBox() {
//        $('#algalley .alimglist').masonry('reloadItems');
//        $('#algalley .alimglist').masonry('layout');
    }
</script>