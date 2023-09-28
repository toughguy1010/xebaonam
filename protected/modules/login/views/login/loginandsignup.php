<div class="row">
    <div class="col-xs-6 form-left">
        <div class="page-login">
            <h2 class="title-login-register"><?php echo Yii::t('common', 'login'); ?></h2>
        </div>
        <div class="box-form">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'login-form',
                'action' => Yii::app()->createUrl('login/login/login'),
                'htmlOptions' => array(
                    'class' => 'form-horizontal',
                ),
                'enableClientValidation' => true,
                'enableAjaxValidation' => false,
            ));
            ?>
            <div class="item-login">
                <?php echo $form->textField($model, 'username', array('class' => 'form-control w3-form-input input-text', 'placeholder' => 'Email address')); ?>
                <?php echo $form->error($model, 'username'); ?>
            </div>
            <div class="item-login">
                <?php echo $form->passwordField($model, 'password', array('class' => 'form-control w3-form-input input-text', 'placeholder' => 'Password')); ?>
                <?php echo $form->error($model, 'password'); ?>
            </div>
            <div class="bottom-box-form clearfix">
                <div class="checkbox">
                    <label><input type="checkbox">Remember me</label>
                </div>
                <div class="change-pass">
                    <a href="<?php echo $this->createUrl('forgotpassword'); ?>" >Quên mật khẩu ?</a>
                </div>
                <div class="w3-form-group form-group">
                    <div class=" w3-form-button">
                        <?php echo CHtml::submitButton(Yii::t('common', 'login'), array('tabindex' => 10, 'class' => 'btn  btn-primary w3-btn w3-btn-sb continue',)); ?>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
    <div class="col-xs-6 form-right">
        <div class="page-register">
            <h2 class="title-login-register"><?php echo Yii::t('user', 'user_signup_title'); ?></h2>
        </div>
        <div class="box-form">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'user-form',
                'action' => Yii::app()->createUrl('login/login/signup'),
                'enableAjaxValidation' => false,
                'enableClientValidation' => true,
                'htmlOptions' => array(
                    'class' => 'form-horizontal',
                ),
            ));
            ?>
            <div class="item-login">
                <?php echo $form->textField($usermodel, 'email', array('class' => 'form-control w3-form-input input-text', 'placeholder' => 'Email')); ?>
                <?php echo $form->error($usermodel, 'email'); ?>
            </div>
            <div class="item-login">
                <?php echo $form->passwordField($usermodel, 'password', array('class' => 'form-control w3-form-input input-text', 'placeholder' => 'Mật khẩu')); ?>
                <?php echo $form->error($usermodel, 'password'); ?>
            </div>
            <div class="item-login">
                <?php echo $form->passwordField($usermodel, 'passwordConfirm', array('class' => 'form-control w3-form-input input-text', 'placeholder' => 'Nhập lại mật khẩu')); ?>
                <?php echo $form->error($usermodel, 'passwordConfirm'); ?>
            </div>
            <div class="item-login">
                <?php echo $form->textField($usermodel, 'name', array('class' => 'form-control w3-form-input input-text', 'placeholder' => 'Họ và tên')); ?>
                <?php echo $form->error($usermodel, 'name'); ?>
            </div>
            <div class="item-login">
                <?php echo $form->textField($usermodel, 'phone', array('class' => 'form-control w3-form-input input-text', 'placeholder' => 'Số điện thoại')); ?>
                <?php echo $form->error($usermodel, 'phone'); ?>
            </div>
            <div class="item-login">
                <?php echo $form->textField($usermodel, 'address', array('class' => 'form-control w3-form-input input-text', 'placeholder' => 'Địa chỉ')); ?>
                <?php echo $form->error($usermodel, 'address'); ?>
            </div>
            <div class="bottom-box-form clearfix">
                <div class="w3-form-group form-group">
                    <div class=" w3-form-button">
                        <?php echo CHtml::submitButton(Yii::t('common', 'signup'), array('tabindex' => 10, 'class' => 'btn btn-primary w3-btn w3-btn-sb continue',)); ?>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
