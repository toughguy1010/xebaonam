<style>
    @media (max-width:480px){
        .sc-account-box, .full-inmobile{
            width:100%;
        }
        .sc-checkout .sc-userinfo {
            display: block;
        }

        .sc-checkout .sc-account-box {
            border-bottom: 1px solid #ebebeb;
            padding: 0px 0px 15px 0px;
        }

        .btn-group-sm>.btn, .btn-sm {
            margin-bottom: 10px;
        }
        .sc-checkout .sc-title {
            font-size: 17px;
            margin-top: 25px;
        }

        .btn-primary {
            color: #fff;
            background-color: #5cb85c;
            border-color: #5cb85c;
        }
    }
</style>
<div class="content-wrap">
    <div class="payment-step1-page">
        <div class="container">

            <div class="sc sc-checkout">
                <h2 class="sc-title"><?php echo Yii::t('shoppingcart', 'checkoutandorder'); ?></h2>
                <div class="row sc-userinfo">
                    <div class="col-xs-12 col-lg-6 col-md-6 col-sm-6 sc-account-box">
                        <h3 class="sc-account-text"><?= Yii::t('shoppingcart', 'account_information') ?></h3>
                        <h3 class="sc-user-text"><?= Yii::t('shoppingcart', 'new_customer') ?></h3>
                        <p> <?= Yii::t('shoppingcart', 'by_creating') ?> </p>
                        <a href="<?php echo Yii::app()->createUrl('/login/login/signup'); ?>" class="btn btn-sm btn-success">
                            <?= Yii::t('shoppingcart', 'create_new_account') ?>
                        </a>
                        <a href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/checkout', array('step' => 's2', 'user' => 'guest')); ?>" class="btn btn-sm btn-success">
                            <?= Yii::t('shoppingcart', 'shopping_without_account') ?>
                        </a>
                    </div>
                    <div class="col-xs-12 col-lg-6 col-md-6 col-sm-6 full-inmobile">
                        <div class="sc-user-login">
                            <h3 class="sc-user-text"><?= Yii::t('shoppingcart', 'already_has_account') ?></h3>
                            <?php
                            $loginform = new LoginForm();
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
                            <div class="row">    
                                <div class="control-group form-group">
                                    <?php echo $form->label($loginform, 'username', array('class' => 'col-sm-3 control-label ')); ?>
                                    <div class="controls col-sm-9">
                                        <?php echo $form->textField($loginform, 'username', array('class' => 'form-control', 'placeholder' => $loginform->getAttributeLabel('username'))); ?>
                                        <?php echo $form->error($loginform, 'username'); ?>
                                    </div>
                                </div>
                                <div class="control-group form-group">
                                    <?php echo $form->label($loginform, 'password', array('class' => 'col-sm-3 control-label ')); ?>
                                    <div class="controls col-sm-9">
                                        <?php echo $form->passwordField($loginform, 'password', array('class' => 'form-control', 'placeholder' => $loginform->getAttributeLabel('password'))); ?>
                                        <?php echo $form->error($loginform, 'password'); ?>  
                                    </div>
                                </div>
                                <div class="control-group form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <?php echo $form->checkBox($loginform, 'rememberMe', array('class' => 'fieldremem')); ?>
                                        <?php echo $form->label($loginform, 'rememberMe', array('class' => 'choice', 'for' => 'fieldremem')); ?>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <?php echo CHtml::submitButton(Yii::t('common', 'login'), array('class' => 'btn btn-sm btn-primary',)); ?>
                                    </div>
                                </div>
                            </div>
                            <?php $this->endWidget(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>