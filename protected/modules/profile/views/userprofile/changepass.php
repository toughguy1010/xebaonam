<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'changepass-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'htmlOptions' => array(
        'class' => 'form-horizontal',
    ),
        ));
?>
<div class="changepass">
    <h3 class="username-title"><?php echo Yii::t('common', 'user_changepassword'); ?></h3>
    <?php if ($user->password) { ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'oldPassword', array('class' => 'control-label col-sm-3')); ?>
            <div class="controls col-sm-9">
                <?php echo $form->passwordField($model, 'oldPassword', array('class' => 'form-control', 'autocomplete' => 'off')); ?>
                <?php echo $form->error($model, 'oldPassword'); ?>
            </div>
        </div>
    <?php } ?>
    <div class ="control-group form-group">
        <?php echo $form->label($model, 'password', array('class' => 'control-label col-sm-3')); ?>
        <div class="controls col-sm-9">
            <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', 'autocomplete' => 'off')); ?>
            <?php echo $form->error($model, 'password'); ?>
        </div>
    </div>
    <div class ="control-group form-group">
        <?php echo $form->label($model, 'passwordConfirm', array('class' => 'control-label col-sm-3')); ?>
        <div class="controls col-sm-9">
            <?php echo $form->passwordField($model, 'passwordConfirm', array('class' => 'form-control', 'autocomplete' => 'off')); ?>
            <?php echo $form->error($model, 'passwordConfirm'); ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?php echo CHtml::submitButton(Yii::t('common', 'save'), array('class' => 'btn btn-primary')); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>
</div>