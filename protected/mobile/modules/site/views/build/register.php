<div class="theme-register-box">
    <div class="promotion" style="margin-bottom: 0px;">
        <div class="promotion-box">
            <div class="promotion-text">
                <a>HOÀN THÀNH ĐĂNG KÝ</a>
            </div>
        </div>
    </div>
    <div class="theme-header">
        <div class="container">
            <a class="back-button" href ="#" onclick="history.go(-1);
                    window.history.go(-1);
                    return false;">
                <span class="back-icon">&lsaquo;</span>QUAY LẠI
            </a>
        </div>
    </div>
    <div class="container">
        <div class="theme-title">
            <h4>ĐĂNG KÝ</h4>
            <h5>BẠN CÓ THỂ THAY ĐỔI GIAO DIỆN BẤT CỨ LÚC NÀO</h5>
        </div>
        <div class="theme-register">
            <div class="">
                <div class="register-image">
                    <img src="<?php echo ClaHost::getImageHost() . $theme['avatar_path'] . 's500_500/' . $theme['avatar_name']; ?>" />
                </div>
            </div>
            <div class="register-form">

                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'w3ncreate-form',
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                ));
                ?>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'domain'); ?>
                    <div class="input-group">
                        <?php echo $form->textField($model, 'domain', array('class' => 'form-control')); ?>
                        <span class="input-group-addon" style="font-size: 11px;">
                            .<?php echo $model->getPostFix(); ?>
                        </span>
                    </div>
                    <div>
                        <?php echo $form->error($model, 'domain'); ?>
                    </div>
                </div>                    
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'email'); ?>
                    <?php echo $form->textField($model, 'email', array('class' => 'form-control')); ?>
                    <div>
                        <?php echo $form->error($model, 'email'); ?>
                    </div>
                </div>                    
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'password'); ?>
                    <?php echo $form->passwordField($model, 'password', array('class' => 'form-control')); ?>
                    <div>
                        <?php echo $form->error($model, 'password'); ?>
                    </div>
                </div>                    
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'captcha'); ?>
                    <div class="input-group">

                        <?php echo $form->textField($model, 'captcha', array('class' => 'form-control')); ?>
                        <span class="input-group-addon" style="padding: 0px 5px; min-width: 110px;">
                            <?php
                            $this->widget('CCaptcha', array(
                                'buttonLabel' => '<i class="ico ico-refrest"></i>',
//                            'showRefreshButton' => false,
//                            'clickableImage' => true,
                                'imageOptions' => array(
                                    'height' => '34px',
                                ),
                            ));
                            ?>
                        </span>
                    </div>
                    <div>
                        <?php echo $form->error($model, 'captcha'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <p class="w3n-term">
                        Chọn đăng ký là bạn đồng ý với quy định sử dụng và chính sách bảo mật của Nanoweb
                    </p>
                </div>
                <div class="form-group">
                    <?php echo CHtml::submitButton('TẠO TRANG WEB MIỄN PHÍ NGAY', array('class' => 'btn btn-primary btn-register', 'id' => 'W3nCreate')); ?>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
        <?php
        if ($themerelaction && count($themerelaction)) {
            ?>
            <div class="theme-relaction">
                <p class="tr-title">CÁC TEMPLATLE KHÁC CÓ THỂ BẠN THÍCH</p>
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
                            $.colorbox({overlayClose: false, closeButton: false, html: "<div style=\"display:block; width: 160px; height:100px; padding: 10px;\"><image src=\"/images/w3n-processing.gif\"/></div>"});
                        },
                        'success': function(res) {
                            var time = (res.time) ? res.time * 1000 : 10000;
                            if (res.code != "200") {
                                $.colorbox.close();
                                if (res.errors) {
                                    parseJsonErrors(res.errors);
                                }
                                //
                                jQuery('#yw0_button').trigger('click');
                                //
                            } else if (res.redirect) {
                                if (res.autologin) {
                                    jQuery.ajax({
                                        'type': 'GET',
                                        'dataType': 'jsonp',
                                        'crossDomain': true,
                                        'url': res.autologin,
                                        'success': function(res) {
                                            //
                                        }
                                    });
                                }
                                //
                                if (res.message) {
                                    $.colorbox({width: "60%", maxWidth: '700px', closeButton: false, html: res.message});
                                    setTimeout(function() {
                                        window.location.href = res.redirect;
                                    }, time);
                                }
                                else if (res.redirect)
                                    setTimeout(function() {
                                        window.location.href = res.redirect;
                                    }, 2000);
                            }
                            formSubmit = true;
                        },
                        'error': function() {
                            $.colorbox.close();
                            formSubmit = true;
                        }
                    });
                    return false;
                });
            });
        </script>
    </div>
</div>