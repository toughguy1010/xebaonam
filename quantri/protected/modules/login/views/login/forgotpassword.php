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
                <div class="forgot-box widget-box no-border visible" id="forgot-box">
                    <div class="widget-body">
                        <div class="widget-main">
                            <h4 class="header red lighter bigger">
                                <i class="icon-key"></i>
                                <?php echo Yii::t('user', 'user_forgotpass_title'); ?>
                            </h4>

                            <div class="space-6"></div>
                            <p>
                                <?php echo Yii::t('user', 'user_forgotpass_help') ?>
                            </p>
                            <?php
                            $form = $this->beginWidget('CActiveForm', array(
                                'id' => 'login-form',
                                'enableClientValidation' => true,
                                'clientOptions' => array(
                                    'validateOnSubmit' => true,
                                ),
                            ));
                            ?>
                            <fieldset>
                                <label class="block clearfix">
                                    <span class="block input-icon input-icon-right">
                                        <?php echo $form->textField($model, 'email', array('class' => 'form-control')); ?>
                                        <i class="icon-envelope"></i>
                                    </span>
                                </label>
                                <?php echo $form->error($model, 'email'); ?>
                                <div class="clearfix">
                                    <?php echo CHtml::submitButton(Yii::t('common', 'send'), array('class' => 'pull-right btn btn-sm btn-danger')); ?>
                                </div>
                            </fieldset>
                            <?php $this->endWidget(); ?>
                        </div><!-- /widget-main -->

                        <div class="toolbar center">
                            <a class="back-to-login-link" href="<?php echo Yii::app()->createUrl('login/login/login'); ?>">
                                <?php echo Yii::t('common', 'login'); ?>
                                <i class="icon-arrow-right"></i>
                            </a>
                        </div>
                    </div><!-- /widget-body -->
                </div>
            </div>
        </div>
    </div>
</div>