<script type="text/javascript">
    jQuery(document).on('click', '.new_delimgaction_color', function() {
        jQuery(this).closest('.ui-state-default').remove();
        updateImgBox();
        return false;
    });
    jQuery(document).on('click', '.delimgaction_color', function() {
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
                            jQuery(thi).closest('.ui-state-default').remove();
                            updateImgBox();
                        }
                    }
                });
            }
        }
        return false;
    });
    function callbackComplete(da, color_code) {
        var firstitem = jQuery('#algalley' + color_code + ' .alimglist').find('.ui-state-default:first');
        var html = '<li class="ui-state-default">';
        html += '<div class="alimgitem">';
        html += '<div class="alimgitembox">';
        html += '<div class="delimg">';
        html += '<a href="#" class="new_delimgaction_color">';
        html += '<i class="icon-remove">';
        html += '</i>';
        html += '</a>';
        html += '</div>';
        html += '<div class="alimgthum">';
        html += '<img src="' + da.imgurl + '">';
        html += '</div>';
        html += '<div class="alimgaction">';
        html += '<input class="position_image" type="hidden" name="order_img_color[' + color_code + '][]" value="newimage[' + color_code + '[]]" />';
        html += '<input type="radio" value="new_' + da.imgid + '" name="setavacolor[' + color_code + ']">';
        html += '<span>Đặt làm ảnh đại diện</span>';
        html += '</div>';
        html += '<input type="hidden" value="' + da.imgid + '" name="newimagecolor[' + color_code + '][]" class="newimage" />';
        html += '</div>';
        html += '</div>';
        html += '</li>';
        if (firstitem.html()) {
            firstitem.before(html);
        } else {
            jQuery('#algalley' + color_code + ' #sortable' + color_code).append(html);
        }
        updateImgBox();
    }
</script>