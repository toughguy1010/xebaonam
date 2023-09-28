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
                                'action' => Yii::app()->createUrl('login/login/login'),
                                'htmlOptions' => array(
                                    'class' => 'form-horizontal'
                                )
                            ));
                            ?>
                            <fieldset>
                                <div>
                                    <label class="block clearfix">
                                        <span class="block input-icon input-icon-right">
                                            <?php echo $form->textField($model, 'username', array('class' => "form-control", 'placeholder' => $model->getAttributeLabel('username'))); ?>
                                            <i class="icon-user"></i>
                                        </span>
                                    </label>
                                    <div class="controls">
                                        <?php echo $form->error($model, 'username'); ?>
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
                                <div class="space"></div>
                                <div class="clearfix">
                                    <label class="inline">
                                        <?php
                                        echo $form->checkBox($model, 'rememberMe', array('class' => "ace"));
                                        ?>
                                        <span class="lbl"> <?php echo $model->getAttributeLabel('rememberMe'); ?></span>
                                    </label>
                                    <?php echo CHtml::submitButton(Yii::t('common', 'login'), array('class' => 'pull-right btn btn-sm btn-primary')); ?>
                                </div>
                                <input type="hidden" name="currPage" value="<?php echo Yii::app()->request->requestUri; ?>" />
                            </fieldset>
                            <?php $this->endWidget(); ?>
                        </div>
                        <div class="toolbar clearfix">
                            <div style="width:100%">
                                <a class="forgot-password-link" href="<?php echo Yii::app()->createUrl('login/login/forgotpassword'); ?>">
                                    <i class="icon-arrow-left"></i>
                                    <?php echo Yii::t('common', 'forgotpassword'); ?>
                                </a>

                                <a class="forgot-password-link" style="float: right;margin-right: 15px;" href="<?php echo Yii::app()->createUrl('login/login/signup'); ?>">
                                    <?php echo Yii::t('common', 'signup'); ?>
                                    <i class="icon-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>