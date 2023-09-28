<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/wizard/jquery.smartWizard.js'); ?>
<style>

</style>
<?php if (Yii::app()->user->hasFlash('success')) { ?>
    <div class="info">
        <p class="bg-success"><?php echo Yii::app()->user->getFlash('success'); ?></p>
    </div>
<?php } else { ?>
<div class="tzpage-default">
    <div class="container">
        <div class="loginform">
            <div class="row">
                <div class="col-md-2 col-xs-12"></div>
                <div class="col-md-8 col-xs-12">

                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'user-form',
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                        'htmlOptions' => array(
                            'class' => 'form-vertical',
                            'enctype' => 'multipart/form-data',
                        ),
                    ));
                    ?>
                    <h3 class="title text-center">
                        <?php echo 'Đăng kí nhà đầu tư' ?>
                    </h3>
                    <h4 class="title-small text-center">
                        <?php echo 'Register Investor' ?>
                    </h4>
                    <div id="wizard" class="form_wizard wizard_horizontal">
                        <ul class="wizard_steps">
                            <li>
                                <a href="#step-1">
                                    <span class="step_no">1</span>
                                    <span class="step_descr">
                                              Thông tin tài khoản<br/>
                                              <small> Account</small>
                                          </span>
                                </a>
                            </li>
                            <li>
                                <a href="#step-2">
                                    <span class="step_no">2</span>
                                    <span class="step_descr">
                                             Thông tin công ty<br/>
                                              <small>Company Infomation</small>
                                          </span>
                                </a>
                            </li>
                            <li>
                                <a href="#step-3">
                                    <span class="step_no">3</span>
                                    <span class="step_descr">
                                              Thông tin ban đầu<br/>
                                              <small>Initial Infomation</small>
                                          </span>
                                </a>
                            </li>
                            <li>
                                <a href="#step-4">
                                    <span class="step_no">4</span>
                                    <span class="step_descr">
                                              Thông tin tham khảo<br/>
                                              <small>Preferences</small>
                                          </span>
                                </a>
                            </li>
                        </ul>
                        <p style="color: red">
                            <?php if ($model->hasErrors() || $user_info->hasErrors()) {
                                echo 'Bạn vui lòng điền đầy đủ thông tin trong *';
                            } ?>
                        </p>
                        <div id="step-1">
                            <div class="row">
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($model, 'name', array('class' => 'control-label ')); ?>
                                    <div class="row">
                                        <div class="col-sm-8 col-xs-12">
                                            <?php echo $form->textField($model, 'name', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('name'))); ?>
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <?php echo $form->error($model, 'name'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($model, 'email', array('class' => 'control-label ')); ?>
                                    <div class="row">
                                        <div class="col-sm-8 col-xs-12">
                                            <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('email'))); ?>
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <?php echo $form->error($model, 'email'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($model, 'password', array('class' => 'control-label ')); ?>
                                    <div class="row">
                                        <div class="col-sm-8 col-xs-12">
                                            <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('password'))); ?>
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <?php echo $form->error($model, 'password'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($model, 'passwordConfirm', array('class' => 'control-label ')); ?>
                                    <div class="row">
                                        <div class="col-sm-8 col-xs-12">
                                            <?php echo $form->passwordField($model, 'passwordConfirm', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('passwordConfirm'))); ?>

                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <?php echo $form->error($model, 'passwordConfirm'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($model, 'phone', array('class' => 'control-label ')); ?>
                                    <div class="row">
                                        <div class="col-sm-8 col-xs-12">
                                            <?php echo $form->textField($model, 'phone', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('phone'))); ?>
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <?php echo $form->error($model, 'phone'); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($model, 'address', array('class' => 'control-label ')); ?>
                                    <div class="row">
                                        <div class="col-sm-8 col-xs-12">
                                            <?php echo $form->textField($model, 'address', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('address'))); ?>
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <?php echo $form->error($model, 'address'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12" style="margin-bottom: 10px">
                                    <?php echo $form->labelEx($model, 'sex', array('class' => 'control-label ')); ?>
                                    <div class="row">
                                        <div class="col-sm-8 col-xs-12">
                                            <?php echo $form->dropDownList($model, 'sex', ClaUser::getListSexArr(), array('class' => 'span9 form-control')); ?>
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <?php echo $form->error($model, 'sex'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div id="step-2">
                            <div class="row">
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($user_info, 'company_name', array('class' => 'control-label ')); ?>
                                    <div class="row">
                                        <div class="col-sm-8 col-xs-12">
                                            <?php echo $form->textField($user_info, 'company_name', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('company_name'))); ?>
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <?php echo $form->error($user_info, 'company_name'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($user_info, 'address', array('class' => 'control-label ')); ?>
                                    <div class="row">
                                        <div class="col-sm-8 col-xs-12">
                                            <?php echo $form->textField($user_info, 'address', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('address'))); ?>
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <?php echo $form->error($user_info, 'address'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($user_info, 'phone', array('class' => 'control-label ')); ?>
                                    <div class="row">
                                        <div class="col-sm-8 col-xs-12">
                                            <?php echo $form->textField($user_info, 'phone', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('phone'))); ?>
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <?php echo $form->error($user_info, 'phone'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($user_info, 'owner_company', array('class' => 'control-label ')); ?>
                                    <?php echo $form->error($user_info, 'owner_company'); ?>
                                    <div class="compactRadioGroup">
                                        <?php
                                        echo $form->radioButtonList($user_info, 'owner_company', $user_info->yesno);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="step-3">
                            <div class="row">
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($user_info, 'info_qt1', array('class' => 'control-label ')); ?>
                                    <?php echo $form->error($user_info, 'info_qt1'); ?>
                                    <div class="compactRadioGroup">
                                        <?php
                                        echo $form->radioButtonList($user_info, 'info_qt1', $user_info::yesno);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($user_info, 'info_qt2', array('class' => 'control-label ')); ?>
                                    <?php echo $form->error($user_info, 'info_qt2'); ?>

                                    <div class="compactRadioGroup">
                                        <?php
                                        echo $form->radioButtonList($user_info, 'info_qt2', $user_info->yesno);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($user_info, 'info_qt3', array('class' => 'control-label ')); ?>
                                    <?php echo $form->error($user_info, 'info_qt3'); ?>

                                    <div class="compactRadioGroup">
                                        <?php
                                        echo $form->radioButtonList($user_info, 'info_qt3', $user_info->yesno);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($user_info, 'info_qt4', array('class' => 'control-label ')); ?>
                                    <?php echo $form->error($user_info, 'info_qt4'); ?>

                                    <div class="compactRadioGroup">
                                        <?php
                                        echo $form->radioButtonList($user_info, 'info_qt4', $user_info->howDoYouWantToJoin, array('class' => 'control-label '));
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="step-4">
                            <div class="row">
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($user_info, 'pref_1', array('class' => 'control-label ')); ?>
                                    <?php echo $form->error($user_info, 'pref_1'); ?>

                                    <div class="compactRadioGroup">
                                        <?php echo $form->checkBoxList($user_info, 'pref_1', $user_info->industrie); ?>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($user_info, 'pref_2', array('class' => 'control-label ')); ?>
                                    <?php echo $form->error($user_info, 'pref_2'); ?>

                                    <div class="compactRadioGroup">
                                        <?php
                                        echo $form->radioButtonList($user_info, 'pref_2', $user_info->moneyInvest);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($user_info, 'pref_3', array('class' => 'control-label ')); ?>
                                    <?php echo $form->error($user_info, 'pref_3'); ?>
                                    <div class="compactRadioGroup">
                                        <?php echo $form->checkBoxList($user_info, 'pref_3', $user_info->region); ?>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($user_info, 'pref_4', array('class' => 'control-label ')); ?>
                                    <?php echo $form->error($user_info, 'pref_4'); ?>
                                    <div class="compactRadioGroup">
                                        <?php echo $form->checkBoxList($user_info, 'pref_4', $user_info->archive); ?>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($user_info, 'pref_5', array('class' => 'control-label ')); ?>
                                    <?php echo $form->error($user_info, 'pref_5'); ?>
                                    <div class="compactRadioGroup">
                                        <?php
                                        echo $form->radioButtonList($user_info, 'pref_5', $user_info->timeSlot);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($user_info, 'pref_6', array('class' => 'control-label ')); ?>
                                    <?php echo $form->textarea($user_info, 'pref_6', array('class' => 'form-control')); ?>
                                    <?php echo $form->error($user_info, 'pref_6'); ?>
                                </div>
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($user_info, 'pref_7', array('class' => 'control-label ')); ?>
                                    <?php echo $form->error($user_info, 'pref_7'); ?>

                                    <div class="compactRadioGroup">
                                        <?php
                                        echo $form->radioButtonList($user_info, 'pref_7', $user_info->yesno);
                                        ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-xs-12">
                    <?php if ($model->hasErrors()) { ?>
                        Vui lòng điền đủ thông tin "*"
                    <?php } ?>
                </div>
            </div>
            <?php $this->endWidget(); ?>
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

    ?>
</div>
<script>
    $(document).ready(function () {
        $('#wizard').smartWizard({
            labelNext: 'Tiếp theo',
            labelPrevious: 'Quay lại',
            labelFinish: 'Đăng kí',
            transitionEffect: 'slideleft',
            onLeaveStep: leaveAStepCallback,
            onFinish: onFinishCallback,
            enableFinishButton: true
        });

        function leaveAStepCallback(obj) {
            var step_num = obj.attr('rel');
            return validateSteps(step_num);
        }

        function onFinishCallback() {
            if (validateAllSteps()) {
                $('form').submit();
            }
        }

        $('.buttonNext').addClass('btn btn-primary');
        $('.buttonNext').addClass('btn btn-primary');
        $('.buttonPrevious').addClass('btn btn-default');
        $('.buttonFinish').addClass('btn btn-success');
    });

    function validateAllSteps() {
        var isStepValid = true;

        if (validateStep1() == false) {
            isStepValid = false;
            $('#wizard').smartWizard('setError', {stepnum: 1, iserror: true});
        } else {
            $('#wizard').smartWizard('setError', {stepnum: 1, iserror: false});
        }

        if (validateStep3() == false) {
            isStepValid = false;
            $('#wizard').smartWizard('setError', {stepnum: 3, iserror: true});
        } else {
            $('#wizard').smartWizard('setError', {stepnum: 3, iserror: false});
        }

//        if (!isStepValid) {
//            $('#wizard').smartWizard('showMessage', 'Bạn vui lòng hoàn thiện các bước được chon');
//        }

        return isStepValid;
    }


    function validateSteps(step) {
        var isStepValid = true;
        // validate step 1
        if (step == 1) {
            if (validateStep1() == false) {
                isStepValid = false;
//                $('#wizard').smartWizard('showMessage', 'Vui lòng hoàn thiện bước' + step + '');
//                $('#wizard').smartWizard('setError', {stepnum: step, iserror: true});
            } else {
//                $('#wizard').smartWizard('hideMessage');
//                $('#wizard').smartWizard('setError', {stepnum: step, iserror: false});
            }
        }

        // validate step3
        if (step == 3) {
            if (validateStep3() == false) {
                isStepValid = false;
//                $('#wizard').smartWizard('showMessage', 'Vui lòng điền đầy đủ các bước có dấu "*"');
//                $('#wizard').smartWizard('setError', {stepnum: step, iserror: true});
            } else {
//                $('#wizard').smartWizard('hideMessage');
//                $('#wizard').smartWizard('setError', {stepnum: step, iserror: false});
            }
        }

        return isStepValid;
    }

    function validateStep1() {
        var isValid = true;
        var user_name = $('#Users_name').val();
        if (!user_name && user_name.length <= 0) {
            isValid = false;
            $('#Users_name_em_').html('Họ và tên không được phép rỗng.').show();
        }
        else {
            $('#Users_name_em_').html('').hide();
        }

        var user_email = $('#Users_email').val();
        if (!user_email && user_email.length <= 0) {
            isValid = false;
            $('#Users_email_em_').html('email không được phép rỗng.').show();
        }
        else {
            $('#Users_email_em_').html('').hide();
        }

        // validate password
        var pw = $('#Users_password').val();
        if (!pw && pw.length <= 6) {
            isValid = false;
            $('#Users_password_em_').html('Mật khẩu vui lòng > 6 ký tự').show();
        } else {
            $('#Users_password_em_').html('').hide();
        }

        // validate confirm password
        var cpw = $('#Users_passwordConfirm').val();
        if (!cpw && cpw.length <= 6) {
            isValid = false;
            $('#Users_password_em_').html('Please fill confirm password').show();
        } else {
            $('#Users_password_em_').html('').hide();
        }

        // validate password match
        if (pw && pw.length > 0 && cpw && cpw.length > 0) {
            if (pw != cpw) {
                isValid = false;
                $('#Users_password_em_').html('Mật khẩu không khớp').show();
            } else {
                $('#Users_password_em_').html('').hide();
            }
        }

        // Validate Username
        return isValid;
    }

    function validateStep3() {
        var isValid = true;
        //validate email  email
//        var qt1 = $('#ytUsersInvestorInfo_info_qt1').val();
//        if (!qt1 && qt1.length <= 0) {
//            isValid = false;
//            $('#UsersInvestorInfo_info_qt1_em_').html('Vui lòng chọn').show();
//        }
//
//        var qt2 = $('#ytUsersInvestorInfo_info_qt2').val();
//        if (!qt2 && qt2.length <= 0) {
//            isValid = false;
//            $('#UsersInvestorInfo_info_qt2_em_').html('Vui lòng chọn').show();
//        }
//
//        var qt3 = $('#ytUsersInvestorInfo_info_qt3').val();
//        if (!qt3 && qt3.length <= 0) {
//            isValid = false;
//            $('#UsersInvestorInfo_info_qt3_em_').html('Vui lòng chọn').show();
//        }
//
//        var qt4 = $('#ytUsersInvestorInfo_info_qt4').val();
//        if (!qt4 && qt4.length <= 0) {
//            isValid = false;
//            $('#UsersInvestorInfo_info_qt4_em_').html('Vui lòng chọn').show();
//        }

        return isValid;
    }
    // Email Validation
    function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
        return pattern.test(emailAddress);
    }


</script>
