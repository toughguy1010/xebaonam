<script>
    jQuery(document).ready(function () {
//        var $container = $('#algalley .alimglist').masonry('reloadItems');
//        $('#algalley .alimglist').imagesLoaded(function () {
//            $('#algalley .alimglist').masonry({
//                itemSelector: '.alimgitem',
//                isAnimated: true
//            });
        jQuery('#myTab li a').on('click', function () {
//                if (!ta)
//                    return false;
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
//        });
    });
    jQuery(document).on('click', '.delimgaction', function () {
        jQuery(this).closest('.ui-state-default').remove();
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
//                    type: 'POST',
                    dataType: 'JSON',
                    success: function (res) {
                        if (res.code == 200) {
                            jQuery(thi).closest('.ui-state-default').remove();
                            updateImgBox();
                        }
                    }
                });
            }
        }
        return true;
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