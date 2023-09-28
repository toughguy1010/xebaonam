<div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <div class="login-container">
            <div class="center">
                <h1>
                    <i class="icon-cog green"></i>
                    <span class="white"><?php echo Yii::t('common', 'adminpanel') ?></span>
                </h1>
            </div>
            <div class="space-6"></div>
            <div class="position-relative">
                <div id="login-box" class="login-box visible widget-box no-border">
                    <div class="widget-body">
                        <div class="widget-main">
                            <h4 class="header blue lighter bigger">
                                <i class="icon-coffee green"></i>
                                <?php echo Yii::t('common', 'enterinfo') ?>
                            </h4>
                            <div class="space-6"></div>
                            <?php
                            $form = $this->beginWidget('CActiveForm', array(
                                'id' => 'login-form',
                                'enableClientValidation' => true,
                                'clientOptions' => array(
                                    'validateOnSubmit' => true,
                                ),
                                'action' => Yii::app()->createUrl('login/login/signup'),
                                'htmlOptions' => array(
                                    'class' => 'form-horizontal'
                                )
                            ));
                            ?>
                            <fieldset>
                                <div>
                                    <label class="block clearfix">
                                        <span class="block input-icon input-icon-right">
                                            <?php echo $form->textField($model, 'user_name', array('class' => "form-control", 'placeholder' => $model->getAttributeLabel('user_name'))); ?>
                                            <i class="icon-user"></i>
                                        </span>
                                    </label>
                                    <div class="controls">
                                        <?php echo $form->error($model, 'user_name'); ?>
                                    </div>
                                </div>
                                <div>
                                    <label class="block clearfix">
                                        <span class="block input-icon input-icon-right">
                                            <?php echo $form->textField($model, 'email', array('class' => "form-control", 'placeholder' => $model->getAttributeLabel('email'))); ?>
                                            <i class="icon-user"></i>
                                        </span>
                                    </label>
                                    <div class="controls">
                                        <?php echo $form->error($model, 'email'); ?>
                                    </div>
                                </div>
                                <div>
                                    <label class="block clearfix">
                                        <span class="block input-icon input-icon-right">
                                            <?php echo $form->passwordField($model, 'passwordConfirm', array('class' => "form-control", 'placeholder' => $model->getAttributeLabel('passwordConfirm'))); ?>
                                            <i class="icon-lock"></i>
                                        </span>
                                    </label>
                                    <div class="controls">
                                        <?php echo $form->error($model, 'passwordConfirm'); ?>
                                    </div>
                                </div>
                                <div>
                                    <label class="block clearfix">
                                        <span class="block input-icon input-icon-right">
                                            <?php echo $form->passwordField($model, 'password', array('class' => "form-control", 'placeholder' => $model->getAttributeLabel('password'))); ?>
                                            <i class="icon-lock"></i>
                                        </span>
                                    </label>
                                    <div class="controls">
                                        <?php echo $form->error($model, 'password'); ?>
                                    </div>
                                </div>
                                <div>
                                    <label class="block clearfix">
                                        <span class="block input-icon input-icon-right">
                                            <?php echo $form->textField($model, 'user_affilliate', array('class' => "form-control", 'placeholder' => $model->getAttributeLabel('user_affilliate'))); ?>
                                            <i class="icon-user"></i>
                                        </span>
                                    </label>
                                    <div class="controls">
                                        <?php echo $form->error($model, 'user_affilliate'); ?>
                                    </div>
                                </div>
                                <div class="space"></div>
                                <div class="clearfix">
                                    <?php echo CHtml::submitButton(Yii::t('common', 'signup'), array('class' => 'pull-right btn btn-sm btn-primary')); ?>
                                </div>
                            </fieldset>
                            <?php $this->endWidget(); ?>
                        </div>
                        <div class="toolbar clearfix">
                            <div>
                                <a class="forgot-password-link" href="<?php echo Yii::app()->createUrl('login/login/login'); ?>">
                                    <i class="icon-arrow-left"></i>
                                    <?php echo Yii::t('common', 'login'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>