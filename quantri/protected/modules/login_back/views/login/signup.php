<div class="wrap">
    <div class="form-register">
        <div class="register">
            <h1>Đăng ký tài khoản mới</h1>
            <div class="form">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'user-form',
                    'enableAjaxValidation' => true,
                ));
                ?>
                <div class="regis">
                    <?php echo $form->textField($model, 'firstname', array('size' => 60,'tabindex'=>1, 'maxlength' => 64, 'placeholder' => 'First Name')); ?>
                    <?php echo $form->error($model, 'firstname'); ?>
                </div>
                <div class="regis">
                    <?php echo $form->textField($model, 'lastname', array('size' => 60,'tabindex'=>1, 'maxlength' => 64, 'placeholder' => 'Last Name')); ?>
                    <?php echo $form->error($model, 'lastname'); ?>
                </div>
                
                <div class="regis">
                    <?php echo $form->textField($model, 'email', array('size' => 60,'tabindex'=>4, 'maxlength' => 64, 'placeholder' => 'Email', 'disabled' => (Yii::app()->controller->action->id == "register_email") ? "disabled" : "")); ?>
                    <?php echo $form->error($model, 'email'); ?>
                </div>

                <div class ="regis">


                    <?php echo $form->passwordField($model, 'password', array('size' => 60,'tabindex'=>5, 'maxlength' => 32, 'placeholder' => 'Mật khẩu')); ?>
                    <?php echo $form->error($model, 'password'); ?>

                </div>

                <div class ="regis">


                    <?php echo $form->passwordField($model, 'passwordConfirm', array('size' => 60,'tabindex'=>6, 'maxlength' => 32, 'placeholder' => 'Nhập lại mật khẩu')); ?>
                    <?php echo $form->error($model, 'passwordConfirm'); ?>

                </div>
                <div style="width: 100%; height: 1px; clear: both; "></div>

                <div class ="sex-res" style="padding: 10px 0 10px 0;">

                    <span>
                        <?php echo $form->radioButton($model, 'gender', array('class'=>'res-checkbox','id'=>'check-male-res','tabindex'=>'7','checked'=>'checked')); ?>
                        <label for="check-male-res" class="res-checkbox">Male</label>
                    </span>
                    <span style="margin:0 0 0 24px">
                        <?php echo $form->radioButton($model, 'gender', array('class'=>'res-checkbox','id'=>'check-female-res','tabindex'=>'8')); ?>
                        <label for="check-female-res" class="res-checkbox">Female</label>
                    </span>   
                </div>
                <div class ="regis" style="margin-top: 5px;">

                    <?php
                    $this->widget('application.widgets.CJuiDateTimePicker.CJuiDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'dob',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                            'changeMonth' => true,
                            'changeYear' => true,
                            'tabularLevel' => null,
                            'minDate' => '-50y',
                            'yearRange' => '100',
                        ),
                        'language' => '',
                        'htmlOptions' => array(
                            //'style' => 'color: #333',
                            'autocomplete' => 'on',
                            'placeholder' => 'Ngày sinh',
                            'tabindex'=>9,
                            'value' => $model->dob ? $model->dob : '',),
                    ));
                    ?>
                    <?php echo $form->error($model, 'dob'); ?>
                </div>
                <div class="controls">
                    <?php echo CHtml::submitButton('Register', array('tabindex'=>10,'onClick' => 'return checkForm()', 'class' => 'register-button', 'value' => 'Register',)); ?>
                    <?php echo CHtml::button('Back', array('tabindex'=>11,'onclick' => "redirectHome()", 'class' => 'cancel-button', 'value' => 'Hủy',)); ?>
                </div>

                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>