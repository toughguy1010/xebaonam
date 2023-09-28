<?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/login/signup.js');
?>
<div class="hero-unit"> 
    <div class="form-register">
        <div class="register">
            <h2>Register Account</h2>
            <div class="form">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'user-form',
                    'enableAjaxValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => false,
                        'validateOnChange' => true,
                    ),
                ));
                ?>            
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'email'); ?>
                    <?php echo $form->textField($model, 'email', array('size' => 60, 'tabindex' => 4, 'maxlength' => 64, 'placeholder' => 'Email', 'autocomplete'=>"off",'disabled' => (Yii::app()->controller->action->id == "register_email") ? "disabled" : "")); ?>
                    <?php echo $form->error($model, 'email'); ?>
                </div>

                <div class ="control-group">
                    <label for="UserModel_password">Password <a class="tooltip-pass">(!)</a></label>
                    <script>
                        $('.tooltip-pass').popover({
                            trigger: 'hover',
                            content: '<?= Yii::t('errorsProfile', 'tootip_password_set') ?>'
                        })
                    </script>
                    <?php echo $form->passwordField($model, 'password', array('size' => 60, 'tabindex' => 5,'autocomplete'=>"off", 'maxlength' => 32, 'placeholder' => 'Password')); ?>
                    <?php echo $form->error($model, 'password'); ?>

                </div>
                <div class ="control-group sig-agree" >
                    <label class="checkbox error">
                        <input name="agree" type="checkbox" value="1" class="">
                        Argree with <a href="<?= Yii::app()->createUrl('site/term') ?>">Terms of use</a>
                    </label>
                    <div style="display: none" id="agree_term" class="errorMessage"><?= Yii::t('errorsProfile', 'term_register'); ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::submitButton('Register', array('tabindex' => 10, 'class' => 'btn sig-submit', 'value' => 'Register',)); ?>
                </div>

                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>