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
                <div id="signup-box" class="signup-box widget-box no-border visible">
                    <div class="widget-body">
                        <div class="widget-main">
                            <h4 class="header green lighter bigger">
                                <i class="icon-key blue"></i>
                                <?php echo Yii::t('user', 'user_forgotpass_title') ?>
                            </h4>

                            <div class="space-6"></div>
                            <p> <?php echo Yii::t('user','user_create_new_password') ?>: </p>
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
                                        <?php echo $form->passwordField($model, 'newpassword', array('class' => "form-control", 'placeholder' => $model->getAttributeLabel('newpassword'))); ?>
                                        <i class="icon-lock"></i>
                                    </span>
                                </label>

                                <label class="block clearfix">
                                    <span class="block input-icon input-icon-right">
                                        <?php echo $form->passwordField($model, 'confirmpassword', array('class' => "form-control", 'placeholder' => $model->getAttributeLabel('confirmpassword'))); ?>
                                        <i class="icon-retweet"></i>
                                    </span>
                                </label>

                                <div class="space-24">
                                    <?php echo $form->error($model, 'newpassword'); ?>
                                </div>

                                <div class="clearfix">
                                    <?php echo CHtml::submitButton(Yii::t('common', 'update'), array('class' => 'btn btn-sm btn-primary')); ?>
                                </div>
                            </fieldset>
                            <?php $this->endWidget(); ?>
                        </div>
                    </div><!-- /widget-body -->
                </div>
            </div>
        </div>
    </div>
</div>