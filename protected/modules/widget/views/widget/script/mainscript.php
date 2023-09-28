<script>
    jQuery(document).ready(function() {
        jQuery('.addwidget').on('click', function() {
            var thi = $(this);
            var href = thi.attr('href');
            if (href) {
                getFormWidget(thi, href);
            }
            return false;
        });
        jQuery('.editwget').on('click', function() {
            var thi = $(this);
            var href = thi.attr('href');
            if (href) {
                getFormWidget(thi, href);
            }
            return false;
        });
        jQuery('.deletewget').on('click', function() {
            if (confirm('<?php echo Yii::t('widget', 'widget_deleteconfirm'); ?>')) {
                var _this = $(this);
                if (_this.hasClass('disable'))
                    return false;
                var href = _this.attr('href');
                if (href) {
                    _this.addClass('disable');
                    jQuery.ajax({
                        type: 'POST',
                        dataType: 'JSON',
                        url: href,
                        beforeSend: function() {
                            w3ShowLoading(_this, 'right', 0, -9);
                        },
                        success: function(data) {
                            if (data.code == 200) {
                                _this.closest('.widgetitem').remove();
                            }
                            w3HideLoading();
                        },
                        error: function() {
                            w3HideLoading();
                        }
                    });
                }
            }
            return false;
        });
        jQuery('.wgetm').on('click', function() {
            var _this = $(this);
            if (_this.hasClass('disable'))
                return false;
            var href = _this.attr('href');
            if (href) {
                _this.addClass('disable');
                jQuery.ajax({
                    url: href,
                    type: 'POST',
                    dataType: 'JSON',
                    beforeSend: function() {
                        w3ShowLoading(_this, 'right', 0, -9);
                    },
                    success: function(data) {
                        if (data.code == 200) {
                            if (data.redirect)
                                window.location.href = data.redirect;
                        }
                        w3HideLoading();
                    },
                    error: function() {
                        w3HideLoading();
                    }
                });
            }
            return false;
        });
    });
    function getFormWidget(obj, href) {
        if (obj.hasClass('disable'))
            return false;
        obj.addClass('disable');
        if (href) {
            jQuery.ajax({
                url: href,
                type: 'POST',
                dataType: 'JSON',
                beforeSend: function() {
                    w3ShowLoading(obj, 'right', 0, -9);
                },
                success: function(data) {
                    if (data.code == 200) {
                        $(document).LoPopUp({
                            title: data.title,
                            clearBefore: true,
                            clearAfter: true,
                            maxwidth: '800px',
                            minwidth: '800px',
                            maxheight: '550px',
                            top: '200px',
                            contentHtml: data.html
                        });
                        $(".LOpopup").show();
                    }
                    w3HideLoading();
                    obj.removeClass('disable');
                },
                error: function() {
                    obj.removeClass('disable');
                    w3HideLoading();
                }
            });
        } else {
            obj.removeClass('disable');
        }
        return true;
    }
</script>