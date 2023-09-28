<?php if (Yii::app()->user->hasFlash('success')){ ?>
    <div class="info">
        <p class="bg-success"><?php echo Yii::app()->user->getFlash('success'); ?></p>
    </div>
<?php } else { ?>
    <div class="form-regis">
        <div class="regis">
            <h2 class="header-title"><?php echo Yii::t('user', 'user_signup_title'); ?></h2>
            <div class="form">
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
                <h3 class="user-title"><?php echo Yii::t('user', 'accountinfo') ?></h3>
                <div class="regis control-group form-group">
                    <?php echo $form->labelEx($model, 'email', array('class' => 'col-sm-3 control-label ')); ?>
                    <div class="controls col-sm-9">
                        <?php echo $form->textField($model, 'email', array('class' => 'span9 form-control')); ?>
                        <?php echo $form->error($model, 'email'); ?>
                    </div>
                </div>
                <div class ="regis control-group form-group">
                    <?php echo $form->labelEx($model, 'password', array('class' => 'col-sm-3 control-label ')); ?>
                    <div class="controls col-sm-9">
                        <?php echo $form->passwordField($model, 'password', array('class' => 'span9 form-control')); ?>
                        <?php echo $form->error($model, 'password'); ?>
                    </div>
                </div>
                <div class ="regis control-group form-group">
                    <?php echo $form->labelEx($model, 'passwordConfirm', array('class' => 'col-sm-3 control-label ')); ?>
                    <div class="controls col-sm-9">
                        <?php echo $form->passwordField($model, 'passwordConfirm', array('class' => 'span9 form-control')); ?>
                        <?php echo $form->error($model, 'passwordConfirm'); ?>
                    </div>
                </div>
                <h3 class="user-title"><?php echo Yii::t('user', 'profileinfo') ?></h3>
                <div class="regis control-group form-group">
                    <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-3 control-label ')); ?>
                    <div class="controls col-sm-9">
                        <?php echo $form->textField($model, 'name', array('class' => 'span9 form-control')); ?>
                        <?php echo $form->error($model, 'name'); ?>
                    </div>
                </div>
                <div class ="regis control-group form-group" style="margin-top: 5px;">
                    <?php echo $form->labelEx($model, 'sex', array('class' => 'col-sm-3 control-label ')); ?>
                    <div class ="sex-res controls col-sm-9">
                        <?php
                        echo $form->dropDownList($model, 'sex', ClaUser::getListSexArr(), array('class' => 'span9 form-control',));
                        ?>
                    </div>
                </div>
                <div class="regis control-group form-group">
                    <?php echo $form->labelEx($model, 'phone', array('class' => 'col-sm-3 control-label ')); ?>
                    <div class="controls col-sm-9">
                        <?php echo $form->textField($model, 'phone', array('class' => 'span9 form-control')); ?>
                        <?php echo $form->error($model, 'phone'); ?>
                    </div>
                </div>
                <div class="regis control-group form-group">
                    <?php echo $form->labelEx($model, 'identity_card', array('class' => 'col-sm-3 control-label ')); ?>
                    <div class="controls col-sm-9">
                        <?php echo $form->textField($model, 'identity_card', array('class' => 'span9 form-control')); ?>
                        <?php echo $form->error($model, 'identity_card'); ?>
                    </div>
                </div>
                <div class="regis control-group form-group">
                    <?php echo $form->labelEx($model, 'created_identity_card', array('class' => 'col-sm-3 control-label ')); ?>
                    <div class="controls col-sm-9">
                        <?php
                        $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                            'model' => $model, //Model object
                            'name' => 'Users[created_identity_card]', //attribute name
                            'mode' => 'date',
                            'value' => ((int) $model->created_identity_card > 0 ) ? date('d-m-Y', (int) $model->created_identity_card) : '',
                            'language' => Yii::app()->language,
                            'options' => array(
                                'showSecond' => true,
                                'dateFormat' => 'dd-mm-yy',
                                'timeFormat' => 'HH:mm:ss',
                                'controlType' => 'select',
                                //'showOn' => 'button',
                                'tabularLevel' => null,
                                'addSliderAccess' => true,
                                'sliderAccessArgs' => array('touchonly' => false),
                                'changeMonth' => true,
                                'changeYear' => true,
                            ), // jquery plugin options
                            'htmlOptions' => array(
                                'class' => 'form-control',
                            )
                        ));
                        ?>
                        <?php echo $form->error($model, 'created_identity_card'); ?>
                    </div>
                </div>
                <div class="regis control-group form-group">
                    <?php echo $form->labelEx($model, 'address_identity_card', array('class' => 'col-sm-3 control-label ')); ?>
                    <div class="controls col-sm-9">
                        <?php echo $form->textField($model, 'address_identity_card', array('class' => 'span9 form-control')); ?>
                        <?php echo $form->error($model, 'address_identity_card'); ?>
                    </div>
                </div>
                <div class="regis control-group form-group">
                    <?php echo $form->labelEx($model, 'front_identity_card', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="controls col-sm-9">
                        <?php echo $form->hiddenField($model, 'front_identity_card', array('class' => 'span9 form-control')); ?>
                        <?php echo CHtml::fileField('front_identity_card', ''); ?>
                        <?php echo $form->error($model, 'front_identity_card'); ?>
                    </div>
                </div>
                <div class="regis control-group form-group">
                    <?php echo $form->labelEx($model, 'back_identity_card', array('class' => 'col-sm-3 control-label ')); ?>
                    <div class="controls col-sm-9">
                        <?php echo $form->hiddenField($model, 'back_identity_card', array('class' => 'span9 form-control')); ?>
                        <?php echo CHtml::fileField('back_identity_card', ''); ?>
                        <?php echo $form->error($model, 'back_identity_card'); ?>
                    </div>
                </div>
                <div class="regis control-group form-group">
                    <?php echo $form->labelEx($model, 'bank_id', array('class' => 'col-sm-3 control-label ')); ?>
                    <div class="controls col-sm-9">
                        <?php echo $form->textField($model, 'bank_id', array('class' => 'span9 form-control')); ?>
                        <?php echo $form->error($model, 'bank_id'); ?>
                    </div>
                </div>
                <div class="regis control-group form-group">
                    <?php echo $form->labelEx($model, 'bank_name', array('class' => 'col-sm-3 control-label ')); ?>
                    <div class="controls col-sm-9">
                        <?php echo $form->textField($model, 'bank_name', array('class' => 'span9 form-control')); ?>
                        <?php echo $form->error($model, 'bank_name'); ?>
                    </div>
                </div>
                <div class="regis control-group form-group">
                    <?php echo $form->labelEx($model, 'bank_branch', array('class' => 'col-sm-3 control-label ')); ?>
                    <div class="controls col-sm-9">
                        <?php echo $form->textField($model, 'bank_branch', array('class' => 'span9 form-control')); ?>
                        <?php echo $form->error($model, 'bank_branch'); ?>
                    </div>
                </div>

                <div class="regis control-group form-group">
                    <?php echo $form->labelEx($model, 'address', array('class' => 'col-sm-3 control-label ')); ?>
                    <div class="controls col-sm-9">
                        <?php echo $form->textField($model, 'address', array('class' => 'span9 form-control')); ?>
                        <?php echo $form->error($model, 'address'); ?>
                    </div>
                </div>
                <div class ="regis control-group form-group" style="margin-top: 5px;">
                    <?php echo $form->labelEx($model, 'province_id', array('class' => 'col-sm-3 control-label ')); ?>
                    <div class="controls col-sm-9">
                        <?php
                        echo $form->dropDownList($model, 'province_id', $listprivince, array('class' => 'span9 form-control',));
                        ?>
                        <?php echo $form->error($model, 'province_id'); ?>
                    </div>
                </div> 
                <div class ="regis control-group form-group" style="margin-top: 5px;">
                    <?php echo $form->labelEx($model, 'district_id', array('class' => 'col-sm-3 control-label ')); ?>
                    <div class="controls col-sm-9">
                        <?php
                        echo $form->dropDownList($model, 'district_id', $listdistrict, array('class' => 'span9 form-control',));
                        ?>
                        <?php echo $form->error($model, 'district_id'); ?>
                    </div>
                </div> 
                <div class="regis control-group form-group">
                    <?php echo $form->labelEx($model, 'phone_introduce', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="controls col-sm-9">
                        <?php echo $form->textField($model, 'phone_introduce', array('class' => 'span9 form-control')); ?>
                        <?php echo $form->error($model, 'phone_introduce'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'captcha', array('class' => 'col-sm-3 control-label no-padding-left')); ?>
                    <div class="controls col-sm-9">
                        <div class="input-group captcha-realestate">
                            <?php echo $form->textField($model, 'captcha', array('class' => 'form-control')); ?>
                            <span class="input-group-addon" style="padding: 0px 5px; min-width: 110px;">
                                <?php
                                $this->widget('CCaptcha', array(
                                    'buttonLabel' => '<i class="ico ico-refrest"></i>',
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
                </div>
                <div class="form-group" style="padding-top: 10px;">
                    <div class="col-sm-offset-3 col-sm-9">
                        <?php echo CHtml::submitButton(Yii::t('common', 'signup'), array('tabindex' => 10, 'class' => 'regis btn btn-primary',)); ?>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
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
<?php } ?>