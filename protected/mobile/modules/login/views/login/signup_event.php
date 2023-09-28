<?php if (Yii::app()->user->hasFlash('success')) { ?>
    <div class="info">
        <p class="bg-success"><?php echo Yii::app()->user->getFlash('success'); ?></p>
    </div>
<?php } else { ?>
    <div class="tzpage-default">
        <h3 class="tz-title-bold-3"><?php echo Yii::t('user', 'user_signup_title'); ?></h3>
        <div class="container">
            <div class="joom-login">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'user-form',
                            'enableAjaxValidation' => false,
                            'enableClientValidation' => true,
                            'htmlOptions' => array(
                                'class' => 'form-horizontal',
                                'enctype' => 'multipart/form-data',
                            ),
                        ));
                        ?>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 10px">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 10px">
                                        <?php $arr_user_eve = ActiveRecord::typeArrayUserEvent();
                                        foreach ($arr_user_eve as $key => $user_type) {
                                            ?>
                                            <label class="btn">
                                                <input style="display:none" name="Users[type]" checked="" type="radio"
                                                       value="<?php echo $key ?>"><i
                                                    class="fa fa-circle-o fa-2x"></i><i
                                                    class="fa fa-dot-circle-o fa-2x"></i>
                                                <span><?php echo $user_type ?></span>
                                            </label>

                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php
                                echo $form->error($model, 'type'); ?>
                                <!--                            </div>-->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <?php echo $form->textField($model, 'name', array('class' => 'span9 form-control', 'placeholder' => $model->getAttributeLabel('name'))); ?>
                                <?php echo $form->error($model, 'name'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <?php echo $form->textField($model, 'email', array('class' => '', 'placeholder' => $model->getAttributeLabel('email'))); ?>
                                <?php echo $form->error($model, 'email'); ?>
                                <!--                                <input placeholder="Email: *" type="text" name="email" id="email">-->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <?php echo $form->passwordField($model, 'password', array('class' => 'span9 form-control', 'placeholder' => $model->getAttributeLabel('password'))); ?>
                                <?php echo $form->error($model, 'password'); ?>
                                <!--                                <input placeholder="Mật khẩu: *" type="password" name="password" id="creat_password">-->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <?php echo $form->passwordField($model, 'passwordConfirm', array('class' => 'span9 form-control', 'placeholder' => $model->getAttributeLabel('passwordConfirm'))); ?>
                                <?php echo $form->error($model, 'passwordConfirm'); ?>
                                <!--                                <input placeholder="Mật khẩu: *" type="password" name="password" id="creat_password">-->
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <?php echo $form->textField($model, 'phone', array('class' => '', 'placeholder' => $model->getAttributeLabel('phone'))); ?>
                                <?php echo $form->error($model, 'phone'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <?php echo $form->textField($model, 'address', array('class' => '', 'placeholder' => $model->getAttributeLabel('address'))); ?>
                                <?php echo $form->error($model, 'address'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 10px">
                                <!--                            --><?php //echo $form->labelEx($model, 'sex', array('class' => 'col-sm-3 control-label ')); ?>
                                <!--                            <div class="sex-res controls col-sm-12">-->
                                <?php
                                echo $form->dropDownList($model, 'sex', ClaUser::getListSexArr(), array('class' => 'span9 form-control'));
                                echo $form->error($model, 'sex'); ?>
                                <!--                            </div>-->
                            </div>
                        </div>

                        <div class="submit-form">
                            <?php echo CHtml::submitButton(Yii::t('common', 'signup'), array('tabindex' => 10, 'class' => '',)); ?>
                            <!--                        <button type="submit"><span>ĐĂNG KÝ</span></button>-->
                        </div>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        jQuery(document).on('change', '#Users_province_id', function () {
            jQuery.ajax({
                url: '<?php echo Yii::app()->createUrl('/suggest/suggest/getdistrict') ?>',
                data: 'pid=' + jQuery('#Users_province_id').val(),
                dataType: 'JSON',
                beforeSend: function () {
                    w3ShowLoading(jQuery('#Users_province_id'), 'right', 20, 0);
                },
                success: function (res) {
                    if (res.code == 200) {
                        jQuery('#Users_district_id').html(res.html);
                    }
                    w3HideLoading();
                },
                error: function () {
                    w3HideLoading();
                }
            });
        });
    </script>
<?php }