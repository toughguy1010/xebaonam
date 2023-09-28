<script>
    jQuery(document).ready(function () {
//        var $container = $('#algalley .alimglist').masonry('reloadItems');
//        $('#algalley .alimglist').imagesLoaded(function() {
//            $('#algalley .alimglist').masonry({
//                itemSelector: '.alimgitem',
//                isAnimated: true
//            });
//        });
        var $grid = $('#algalley .alimglist').imagesLoaded(function () {
            $grid.masonry({
                itemSelector: '.alimgitem',
                isAnimated: true
            });
//            $('.grid').isotope({
//                itemSelector: '.alimgitem',
//                masonry: {
//                    columnWidth: '.col-sm-4'
//                }
//            });
//            $('.grid').isotope({
//                itemSelector: '.alimgitem'
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
    //    jQuery('#savealbum').on('click', function() {
    //        var thi = $(this);
    //        if (thi.hasClass('disable'))
    //            return false;
    //        thi.addClass('disable');
    //        if (validate()) {
    //            var form = $('#albums-form');
    //            jQuery.ajax({
    //                url: form.attr('action'),
    //                type: 'POST',
    //                dataType: 'JSON',
    //                data: form.serialize(),
    //                beforeSend: function() {
    //                    w3ShowLoading(thi, 'right', 40, 0);
    //                },
    //                success: function(data) {
    //                    if (data.code == 200) {
    //                        window.location.href = data.redirect;
    //                    }
    //                    thi.removeClass('disable');
    //                    w3HideLoading();
    //                },
    //                error: function() {
    //                    w3HideLoading();
    //                    thi.removeClass('disable');
    //                }
    //            });
    //        } else
    //            thi.removeClass('disable');
    //        return false;
    //    });
    jQuery(document).on('click', '.alimgaction', function () {
        $('#algalley .alimgitem').removeClass('active');
        $(this).closest('.alimgitem').addClass('active');
        $(this).find('input[type=radio]').prop('checked', true);
    });
    function updateImgBox() {
        $('#algalley .alimglist').masonry('reloadItems');
        $('#algalley .alimglist').masonry('layout');
    }
    function validate() {
        jQuery('#Albums_imageitem_em_').hide();
        var alname = jQuery.trim(jQuery('#Albums_album_name').val());
        var aldes = jQuery.trim(jQuery('#Albums_album_description').val());
        var imgitem = jQuery('#algalley .alimglist').find('.alimgitem').length;
        if (!imgitem)
            jQuery('#Albums_imageitem_em_').show();
        if (!alname || !aldes || !imgitem)
            return false;
        return true;
    }
</script>