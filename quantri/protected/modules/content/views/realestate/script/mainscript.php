<script>
    jQuery(document).ready(function () {
        //var $container = $('#algalley .alimglist').masonry('reloadItems');
        $('#algalley .alimglist').imagesLoaded(function () {
//            $('#algalley .alimglist').masonry({
//                itemSelector: '.alimgitem',
//                isAnimated: true
//            });

            jQuery('#myTab li a').on('click', function () {
                if (!ta)
                    return false;
                var href = $(this).attr('href');
                if (href == '#imagevideo') {
                    if (jQuery('#imagevideo').hasClass('showed')) {
                        return;
                    } else {
                        jQuery('#imagevideo').addClass('showed');
                        setTimeout(function () {
                            updateImgBox();
                        }, 100);
                    }
                }
            });

        });


        jQuery('#saverealestateproject').on('click', function () {
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
                    data: jQuery('#car-form').serialize(),
                    beforeSend: function () {
                        w3ShowLoading(_this, 'left', -30, 0);
                    },
                    success: function (res) {
                        if (res.code == 200) {
                            jQuery('#car-form').submit();
                        } else {
                            if (res.errors) {
                                parseJsonErrors(res.errors, jQuery('#car-form'));
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
    jQuery(document).on('click', '.new_delimgaction', function () {
        jQuery(this).closest('.alimgitem').remove();
        updateImgBox();
        return false;
    });
    jQuery(document).on('click', '.delimgaction', function () {
        if (confirm('<?php echo Yii::t('album', 'album_delete_image_confirm'); ?>')) {
            var thi = $(this);
            var href = thi.attr('href');
            if (href) {
                jQuery.ajax({
                    url: href,
                    type: 'POST',
                    dataType: 'JSON',
                    success: function (res) {
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
    jQuery('#saverealestateproject').on('click', function () {
        var thi = $(this);
        if (thi.hasClass('disable'))
            return false;
        thi.addClass('disable');
        if (validate()) {
            var form = $('#realestate-project-form');
            jQuery.ajax({
                url: form.attr('action'),
                type: 'POST',
                dataType: 'JSON',
                data: form.serialize(),
                beforeSend: function () {
                    w3ShowLoading(thi, 'right', 40, 0);
                },
                success: function (data) {
                    if (data.code == 200) {
                        window.location.href = data.redirect;
                    }
                    thi.removeClass('disable');
                    w3HideLoading();
                },
                error: function () {
                    w3HideLoading();
                    thi.removeClass('disable');
                }
            });
        } else
            thi.removeClass('disable');
        return false;
    });
    jQuery(document).on('click', '.alimgitembox', function () {
        $('#algalley .alimgitem').removeClass('active');
        $(this).closest('.alimgitem').addClass('active');
        $(this).find('.alimgaction').find('input[type=radio]').prop('checked', true);
    });
    function updateImgBox() {
//        $('#algalley .alimglist').masonry('reloadItems');
//        $('#algalley .alimglist').masonry('layout');
    }
</script>