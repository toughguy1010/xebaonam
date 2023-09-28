<div class="form-login">
    <h2 class="header-title"><?php echo Yii::t('common', 'login'); ?></h2>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'login-form',
        'htmlOptions' => array(
            'class' => 'form-horizontal',
        ),
        'enableClientValidation' => true,
        'enableAjaxValidation' => false,
    ));
    ?>
    <div class="regis control-group form-group">
        <?php echo $form->labelEx($model, 'username', array('class' => 'col-sm-3 control-label ')); ?>
        <div class="controls col-sm-9">
            <?php echo $form->textField($model, 'username', array('class' => 'span9 form-control')); ?>
            <?php echo $form->error($model, 'username'); ?>
        </div>
    </div>
    <div class ="regis control-group form-group">
        <?php echo $form->labelEx($model, 'password', array('class' => 'col-sm-3 control-label ')); ?>
        <div class="controls col-sm-9">
            <?php echo $form->passwordField($model, 'password', array('class' => 'span9 form-control')); ?>
            <?php echo $form->error($model, 'password'); ?>
        </div>
    </div>
    <div class="form-group" style="padding-top: 10px;">
        <div class="col-sm-offset-3 col-sm-9">
            <?php echo CHtml::submitButton(Yii::t('common', 'login'), array('tabindex' => 10, 'class' => 'btn btn-primary',)); ?>
            <a href="<?php echo Yii::app()->createUrl('/login/login/signup'); ?>" class="btn btn-info"><?php echo Yii::t('common', 'signup'); ?></a>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>