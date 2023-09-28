<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/wizard/jquery.smartWizard.js'); ?>
<style>
    .form-vertical .control-label {
        text-align: justify;
    }

    .form-vertical textarea.form-control {
        border-radius: 0;
    }
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
                        <?php echo 'Đăng kí doanh nghiệp khởi nghiệp' ?>
                    </h3>
                    <h4 class="title-small text-center">
                        <?php echo 'Register Startup Company' ?>
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
                                            Thông tin doanh nghiệp<br/>
                                              <small>STARTUP PROFILE</small>
                                          </span>
                                </a>
                            </li>
                            <li>
                                <a href="#step-3">
                                    <span class="step_no">3</span>
                                    <span class="step_descr">
                                              Nội dung dự án<br/>
                                              <small>PROJECT DETAILS</small>
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
                                            <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'placeholder' => 'Câu trả lời của bạn')); ?>
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
                                <!--                                <div class="col-xs-12">-->
                                <!--                                    --><?php //echo $form->labelEx($model, 'phone', array('class' => 'control-label ')); ?>
                                <!--                                    <div class="row">-->
                                <!--                                        <div class="col-sm-8 col-xs-12">-->
                                <!--                                            --><?php //echo $form->textField($model, 'phone', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('phone'))); ?>
                                <!--                                        </div>-->
                                <!--                                        <div class="col-sm-4 col-xs-12">-->
                                <!--                                            --><?php //echo $form->error($model, 'phone'); ?>
                                <!---->
                                <!--                                        </div>-->
                                <!--                                    </div>-->
                                <!--                                </div>-->
                                <!--                                <div class="col-xs-12">-->
                                <!--                                    --><?php //echo $form->labelEx($model, 'address', array('class' => 'control-label ')); ?>
                                <!--                                    <div class="row">-->
                                <!--                                        <div class="col-sm-8 col-xs-12">-->
                                <!--                                            --><?php //echo $form->textField($model, 'address', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('address'))); ?>
                                <!--                                        </div>-->
                                <!--                                        <div class="col-sm-4 col-xs-12">-->
                                <!--                                            --><?php //echo $form->error($model, 'address'); ?>
                                <!--                                        </div>-->
                                <!--                                    </div>-->
                                <!--                                </div>-->
                                <!--                                <div class="col-xs-12" style="margin-bottom: 10px">-->
                                <!--                                    --><?php //echo $form->labelEx($model, 'sex', array('class' => 'control-label ')); ?>
                                <!--                                    <div class="row">-->
                                <!--                                        <div class="col-sm-8 col-xs-12">-->
                                <!--                                            --><?php //echo $form->dropDownList($model, 'sex', ClaUser::getListSexArr(), array('class' => 'span9 form-control')); ?>
                                <!--                                        </div>-->
                                <!--                                        <div class="col-sm-4 col-xs-12">-->
                                <!--                                            --><?php //echo $form->error($model, 'sex'); ?>
                                <!--                                        </div>-->
                                <!--                                    </div>-->
                                <!--                                </div>-->
                            </div>
                        </div>
                        <div id="step-2">
                            <div class="row">
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($company_info, 'company_project_name', array('class' => 'control-label ')); ?>
                                    <div class="row">
                                        <div class="col-sm-8 col-xs-12">
                                            <?php echo $form->textField($company_info, 'company_project_name', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('company_name'))); ?>
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <?php echo $form->error($company_info, 'company_project_name'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($company_info, 'contact_name', array('class' => 'control-label ')); ?>
                                    <div class="row">
                                        <div class="col-sm-8 col-xs-12">
                                            <?php echo $form->textField($company_info, 'contact_name', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('address'))); ?>
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <?php echo $form->error($company_info, 'contact_name'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($company_info, 'phone_email_website', array('class' => 'control-label ')); ?>
                                    <div class="row">
                                        <div class="col-sm-8 col-xs-12">
                                            <?php echo $form->textField($company_info, 'phone_email_website', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('phone'))); ?>
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <?php echo $form->error($company_info, 'phone_email_website'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($company_info, 'time_working', array('class' => 'control-label ')); ?>
                                    <div class="compactRadioGroup">
                                        <?php
                                        echo $form->radioButtonList($company_info, 'time_working', UsersCompanyInfo::time_working());
                                        ?>
                                    </div>
                                    <?php echo $form->error($company_info, 'time_working'); ?>
                                </div>
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($company_info, 'industry', array('class' => 'control-label ')); ?>
                                    <div class="compactRadioGroup">
                                        <?php
                                        echo $form->radioButtonList($company_info, 'industry', UsersCompanyInfo::industry());
                                        ?>
                                    </div>
                                    <?php echo $form->error($company_info, 'industry'); ?>
                                </div>
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($company_info, 'product_type', array('class' => 'control-label ')); ?>
                                    <div class="compactRadioGroup">
                                        <?php
                                        echo $form->radioButtonList($company_info, 'product_type', UsersCompanyInfo::product_type());
                                        ?>
                                    </div>
                                    <?php echo $form->error($company_info, 'product_type'); ?>
                                </div>
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($company_info, 'member', array('class' => 'control-label ')); ?>
                                    <div class="row">
                                        <div class="col-sm-8 col-xs-12">
                                            <?php
                                            echo $form->textarea($company_info, 'member');
                                            ?>
                                        </div>
                                        <div class="col-xs-4 col-xs-12">
                                            <?php echo $form->error($company_info, 'member'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($company_info, 'stage_of_development', array('class' => 'control-label')); ?>
                                    <div class="compactRadioGroup">
                                        <?php
                                        echo $form->radioButtonList($company_info, 'stage_of_development', UsersCompanyInfo::time_working());
                                        ?>
                                    </div>
                                    <?php echo $form->error($company_info, 'stage_of_development'); ?>
                                </div>
                            </div>
                        </div>
                        <div id="step-3">
                            <div class="row">
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($company_info, 'proj_qt1', array('class' => 'control-label')); ?>
                                    <div class="row">
                                        <div class="col-sm-8 col-xs-12">
                                            <?php echo $form->textArea($company_info, 'proj_qt1', array('class' => 'form-control', 'placeholder' => 'Câu trả lời của bạn')); ?>
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <?php echo $form->error($company_info, 'proj_qt1'); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($company_info, 'proj_qt2', array('class' => 'control-label ')); ?>
                                    <div class="row">
                                        <div class="col-sm-8 col-xs-12">
                                            <?php echo $form->textArea($company_info, 'proj_qt2', array('class' => 'form-control', 'placeholder' => 'Câu trả lời của bạn')); ?>
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <?php echo $form->error($company_info, 'proj_qt2'); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($company_info, 'proj_qt3', array('class' => 'control-label ')); ?>
                                    <div class="row">
                                        <div class="col-sm-8 col-xs-12">
                                            <?php echo $form->textArea($company_info, 'proj_qt3', array('class' => 'form-control', 'placeholder' => 'Câu trả lời của bạn')); ?>
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <?php echo $form->error($company_info, 'proj_qt3'); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($company_info, 'proj_qt4', array('class' => 'control-label ')); ?>
                                    <div class="row">
                                        <div class="col-sm-8 col-xs-12">
                                            <?php echo $form->textArea($company_info, 'proj_qt4', array('class' => 'form-control', 'placeholder' => 'Câu trả lời của bạn')); ?>
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <?php echo $form->error($company_info, 'proj_qt4'); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($company_info, 'proj_qt5', array('class' => 'control-label ')); ?>
                                    <div class="row">
                                        <div class="col-sm-8 col-xs-12">
                                            <?php echo $form->textArea($company_info, 'proj_qt5', array('class' => 'form-control', 'placeholder' => 'Câu trả lời của bạn')); ?>
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <?php echo $form->error($company_info, 'proj_qt5'); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($company_info, 'proj_qt6', array('class' => 'control-label ')); ?>
                                    <div class="row">
                                        <div class="col-sm-8 col-xs-12">
                                            <?php echo $form->textArea($company_info, 'proj_qt6', array('class' => 'form-control', 'placeholder' => 'Câu trả lời của bạn')); ?>
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <?php echo $form->error($company_info, 'proj_qt6'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($company_info, 'proj_qt7', array('class' => 'control-label ')); ?>
                                    <div class="row">
                                        <div class="col-sm-8 col-xs-12">
                                            <?php echo $form->textArea($company_info, 'proj_qt7', array('class' => 'form-control', 'placeholder' => 'Câu trả lời của bạn')); ?>
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <?php echo $form->error($company_info, 'proj_qt7'); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <label class="control-label" style="font-weight: 28px">
                                        2.8 What major milestones have you reached and what are your startup's plans for
                                        this year?
                                    </label>
                                    <?php echo $form->labelEx($company_info, 'proj_qt8_1', array('class' => 'control-label ')); ?>
                                    <div class="row">
                                        <div class="col-sm-8 col-xs-12">
                                            <?php echo $form->textField($company_info, 'proj_qt8_1', array('class' => 'form-control',)); ?>
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <?php echo $form->error($company_info, 'proj_qt8_1'); ?>
                                        </div>
                                    </div>

                                    <?php echo $form->labelEx($company_info, 'proj_qt8_2', array('class' => 'control-label ')); ?>
                                    <div class="row">
                                        <div class="col-sm-8 col-xs-12">
                                            <?php echo $form->textField($company_info, 'proj_qt8_2', array('class' => 'form-control',)); ?>
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <?php echo $form->error($company_info, 'proj_qt8_2'); ?>
                                        </div>
                                    </div>

                                    <?php echo $form->labelEx($company_info, 'proj_qt8_3', array('class' => 'control-label ')); ?>
                                    <div class="row">

                                        <div class="col-sm-8 col-xs-12">
                                            <?php echo $form->textField($company_info, 'proj_qt8_3', array('class' => 'form-control',)); ?>
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <?php echo $form->error($company_info, 'proj_qt8_3'); ?>
                                        </div>
                                    </div>

                                    <?php echo $form->labelEx($company_info, 'proj_qt8_4', array('class' => 'control-label ')); ?>
                                    <div class="row">

                                        <div class="col-sm-8 col-xs-12">
                                            <?php echo $form->textField($company_info, 'proj_qt8_4', array('class' => 'form-control',)); ?>
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <?php echo $form->error($company_info, 'proj_qt8_4'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($company_info, 'proj_qt9', array('class' => 'control-label ')); ?>
                                    <div class="row">

                                        <div class="col-sm-8 col-xs-12">
                                            <?php echo $form->textArea($company_info, 'proj_qt9', array('class' => 'form-control',)); ?>
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <?php echo $form->error($company_info, 'proj_qt9'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($company_info, 'proj_qt10', array('class' => 'control-label ')); ?>
                                    <div class="row">

                                        <div class="col-sm-8 col-xs-12">
                                            <?php echo $form->textField($company_info, 'proj_qt10', array('class' => 'form-control',)); ?>
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <?php echo $form->error($company_info, 'proj_qt10'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($company_info, 'proj_qt11', array('class' => 'control-label ')); ?>
                                    <div class="row">

                                        <div class="col-sm-8 col-xs-12">
                                            <?php echo $form->textField($company_info, 'proj_qt11', array('class' => 'form-control',)); ?>
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <?php echo $form->error($company_info, 'proj_qt11'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <?php echo $form->labelEx($company_info, 'proj_qt12', array('class' => 'control-label ')); ?>
                                    <div class="row">

                                        <div class="col-sm-8 col-xs-12">
                                            <?php echo $form->textField($company_info, 'proj_qt12', array('class' => 'form-control',)); ?>
                                        </div>
                                        <div class="col-sm-4 col-xs-12">
                                            <?php echo $form->error($company_info, 'proj_qt12'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="step-4">
                            <div class="row">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-xs-12"></div>
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
            }
        );
        $('.buttonNext').addClass('btn btn-primary');
        $('.buttonNext').addClass('btn btn-primary');
        $('.buttonPrevious').addClass('btn btn-default');
        $('.buttonFinish').addClass('btn btn-success');
    });
</script>
