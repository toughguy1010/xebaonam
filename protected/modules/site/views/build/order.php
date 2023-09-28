<div class="theme-register-box">
    <div class="theme-header">
        <div class="container">
            <a class="back-button" href ="#" onclick="history.go(-1);
                    window.history.go(-1);
                    return false;">
                <span class="back-icon">&lsaquo;</span><?php echo Yii::t('request','button_back'); ?>
            </a>
        </div>
    </div>
    <div class="container">
        <div class="theme-title">
            <h4><?php echo Yii::t('request', 'request_design') ?></h4>
            <h5 class="text-danger"><?php echo Yii::t('request', 'request_notice'); ?></h5>
        </div>
        <div class="row theme-register">
            <div class="col-xs-8">
                <div class="register-image">
                    <img src="<?php echo ClaHost::getImageHost() . $theme['avatar_path'] . 's700_0/' . $theme['avatar_name']; ?>" />
                </div>
            </div>
            <div class="col-xs-4">
                <?php
                $this->renderPartial('request_form', array(
                    'model' => $model,
                ));
                ?>
            </div>
        </div>
        <?php
        if ($themerelaction && count($themerelaction)) {
            ?>
            <div class="theme-relaction">
                <p class="tr-title"><?php echo Yii::t('request','other_template') ?></p>
                <div class="row list-theme">
                    <?php
                    foreach ($themerelaction as $theme) {
                        $this->renderPartial('themeItem', array('theme' => $theme));
                    }
                    ?>
                </div>
            </div>
        <?php } ?>
        <script>
            jQuery(document).ready(function() {
                var c_position = jQuery("#content").position();
                jQuery(window).scrollTop(c_position.top);
                var formSubmit = true;
                jQuery('#w3ncreate-form').on('submit', function() {
                    if (!formSubmit)
                        return false;
                    formSubmit = false;
                    var thi = jQuery(this);
                    jQuery.ajax({
                        'type': 'POST',
                        'dataType': 'JSON',
                        'url': thi.attr('action'),
                        'data': thi.serialize(),
                        'beforeSend': function() {
                            w3ShowLoading(jQuery('#sendrequest'), 'right', 60, 0);
                        },
                        'success': function(res) {
                            w3HideLoading();
                            var time = (res.time) ? res.time * 1000 : 10000;
                            if (res.code != "200") {
                                if (res.errors) {
                                    parseJsonErrors(res.errors);
                                }
                                //
                                jQuery('#yw0_button').trigger('click');
                            } else if (res.redirect) {
                                //
                                window.location.href = res.redirect;
                            }
                            formSubmit = true;
                        },
                        'error': function() {
                            w3HideLoading();
                            formSubmit = true;
                        }
                    });
                    return false;
                });
            });
        </script>
    </div>
</div>