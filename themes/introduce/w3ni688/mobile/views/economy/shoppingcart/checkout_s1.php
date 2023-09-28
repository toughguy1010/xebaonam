<div class="sc sc-checkout">
    <h2 class="sc-title"><?php echo Yii::t('shoppingcart', 'checkoutandorder'); ?></h2>
    <div class="row sc-userinfo">
        <div class="col-xs-6 sc-account-box">
            <h3 class="sc-account-text">THÔNG TIN TÀI KHOẢN</h3>
            <h3 class="sc-user-text">BẠN LÀ KHÁCH HÀNG MỚI?</h3>
            <p>
                Đăng ký với chúng tôi để thanh toán nhanh hơn, để theo dõi
                tình trạng đặt hàng của bạn và nhiều hơn nữa. Bạn cũng có 
                thể thanh toán mà không cần đăng ký tài khoản.
            </p>
            <a href="<?php echo Yii::app()->createUrl('/login/login/signup'); ?>" class="btn btn-sm btn-success">
                Đăng ký tài khoản mới
            </a>
            <a href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/checkout', array('step' => 's2', 'user' => 'guest')); ?>" class="btn btn-sm btn-success">
                Đặt hàng không cần tài khoản
            </a>
        </div>
        <div class="col-xs-6">
            <div class="sc-user-login">
                <h3 class="sc-user-text">BẠN ĐÃ CÓ TÀI KHOẢN</h3>
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
    <div class="accordion-inner">
        <?php
        $this->renderPartial('pack', array(
            'shoppingCart' => $shoppingCart,
            'update' => false,
        ));
        ?>
    </div>
</div>