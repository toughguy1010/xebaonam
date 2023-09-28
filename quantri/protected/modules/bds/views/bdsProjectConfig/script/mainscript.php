<script>
    jQuery(document).ready(function () {
        jQuery('#save_project_config').on('click', function () {
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
                    data: jQuery('#project-config-form').serialize(),
                    beforeSend: function () {
                        w3ShowLoading(_this, 'left', -30, 0);
                    },
                    success: function (res) {
                        if (res.code == 200) {
                            jQuery('#project-config-form').submit();
                        } else {
                            if (res.errors) {
                                parseJsonErrors(res.errors, jQuery('#project-config-form'));
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
        
        jQuery('#BdsProjectavatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/bds/bdsProject/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#BdsProjectConfig_avatar').val(obj.data.avatar);
                        if (jQuery('#BdsProjectavatar_img img').attr('src')) {
                            jQuery('#BdsProjectavatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#BdsProjectavatar_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#BdsProjectavatar_img').css({"margin-right": "10px"});
                    }
                }
            }
        });
        //
        jQuery('#BdsProjectlogo_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/bds/bdsProject/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#BdsProjectConfig_logo').val(obj.data.avatar);
                        if (jQuery('#BdsProjectlogo_img img').attr('src')) {
                            jQuery('#BdsProjectlogo_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#BdsProjectlogo_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#BdsProjectlogo_img').css({"margin-right": "10px"});
                    }
                }
            }
        });
        //
        jQuery('#BdsProjectconfig1_image_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/bds/bdsProject/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#BdsProjectConfig_config1_image').val(obj.data.avatar);
                        if (jQuery('#BdsProjectconfig1_image_img img').attr('src')) {
                            jQuery('#BdsProjectconfig1_image_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#BdsProjectconfig1_image_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#BdsProjectconfig1_image_img').css({"margin-right": "10px"});
                    }
                }
            }
        });
        //
        jQuery('#BdsProjectconfig2_image_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/bds/bdsProject/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#BdsProjectConfig_config2_image').val(obj.data.avatar);
                        if (jQuery('#BdsProjectconfig2_image_img img').attr('src')) {
                            jQuery('#BdsProjectconfig2_image_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#BdsProjectconfig2_image_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#BdsProjectconfig2_image_img').css({"margin-right": "10px"});
                    }
                }
            }
        });
        //
        jQuery('#BdsProjectconfig3_image_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/bds/bdsProject/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#BdsProjectConfig_config3_image').val(obj.data.avatar);
                        if (jQuery('#BdsProjectconfig3_image_img img').attr('src')) {
                            jQuery('#BdsProjectconfig3_image_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#BdsProjectconfig3_image_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#BdsProjectconfig3_image_img').css({"margin-right": "10px"});
                    }
                }
            }
        });
        //
        jQuery('#BdsProjectconfig4_image_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/bds/bdsProject/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#BdsProjectConfig_config4_image').val(obj.data.avatar);
                        if (jQuery('#BdsProjectconfig4_image_img img').attr('src')) {
                            jQuery('#BdsProjectconfig4_image_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#BdsProjectconfig4_image_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#BdsProjectconfig4_image_img').css({"margin-right": "10px"});
                    }
                }
            }
        });
        //
        jQuery('#BdsProjectconfig5_image_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/bds/bdsProject/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#BdsProjectConfig_config5_image').val(obj.data.avatar);
                        if (jQuery('#BdsProjectconfig5_image_img img').attr('src')) {
                            jQuery('#BdsProjectconfig5_image_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#BdsProjectconfig5_image_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#BdsProjectconfig5_image_img').css({"margin-right": "10px"});
                    }
                }
            }
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
    });

</script>