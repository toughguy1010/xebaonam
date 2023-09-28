<div class="form-login">
    <div class="login">
        <h2 class="header-title"><?php echo Yii::t('common', 'login'); ?></h2>
        <div class="form">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'login-form',
                'htmlOptions' => array(
                    'class' => 'form-horizontal',
                ),
                'enableClientValidation' => true,
                'enableAjaxValidation' => false,
//        'clientOptions' => array(
//            'validateOnSubmit' => true,
//        ),
            ));
            ?>
            <div class="locontent">
                <h1><?php echo Yii::t('common', 'login'); ?></h1>
                <!-- Login Fields -->
                <div class="regis control-group form-group">
                    <?php echo $form->labelEx($model, 'username', array('class' => 'col-sm-3 control-label ')); ?>
                    <div class="controls col-sm-9">
                        <?php echo $form->textField($model, 'username', array('class' => 'span9 form-control')); ?>
                        <?php echo $form->error($model, 'username'); ?>
                    </div>
                </div>
                <div class="control-group form-group">
                    <?php echo $form->labelEx($model, 'password', array('class' => 'col-sm-3 control-label ')); ?>
                    <div class="controls col-sm-9">
                        <?php echo $form->passwordField($model, 'password', array('class' => 'span9 form-control')); ?>
                        <?php echo $form->error($model, 'password'); ?>
                    </div>
                </div>
                <div class="control-group form-group">
                    <div class="controls col-sm-9">
                        <div class="button">
                            <?php echo CHtml::submitButton(Yii::t('common', 'login'), array('class' => 'btn btn-primary')); ?>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <!-- Checkbox -->
                    <div class="checkbox">
                        <li>
                            <fieldset>
                                <div>
                            <span>
                                <?php echo $form->checkBox($model, 'rememberMe', array('id' => 'Field', 'class' => 'field', 'onchange' => 'handleInput(this);')); ?>
                                <?php echo $form->label($model, 'rememberMe', array('class' => 'choice', 'for' => 'Field')); ?>
                            </span>
                                </div>
                            </fieldset>
                        </li>
                    </div>
                    <!-- Social Buttons -->
                    <!--                <div class="social">-->
                    <!--                    <div class="fb"><a href="http://chiasediadiem.vn/fblogin"-->
                    <!--                                       class="btn_2">-->
                    <?php //echo Yii::t('common', 'login_with_facebook') ?><!--</a></div>-->
                    <!--                </div>-->

                </div>
                <div id="bottom_text">
                    <?php echo Yii::t('common', 'havenoaccount'); ?>
                    <a href="<?php echo Yii::app()->createUrl('login/login/signup'); ?>">
                        <?php echo Yii::t('common', 'signup'); ?>
                    </a><br/>
                    <?php echo Yii::t('common', 'forgot'); ?>
                    <a href="<?php echo Yii::app()->createUrl('login/login/forgotpassword'); ?>">
                        <?php echo Yii::t('common', 'password'); ?>
                    </a>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>