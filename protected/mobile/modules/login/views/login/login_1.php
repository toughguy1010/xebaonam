<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('common', 'login');
?>
<div class="contentpadding">
    <h2><?php echo Yii::t('common', 'login'); ?></h2>

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

        <div class="control-group form-group">
            <?php echo $form->label($model, 'username', array('class' => 'col-sm-3 control-label')); ?>
            <div class="col-sm-5">
                <?php echo $form->textField($model, 'username', array('class' => 'span4 form-control')); ?>
            </div>
            <?php echo $form->error($model, 'username'); ?>
        </div>

        <div class="control-group form-group">
            <?php echo $form->label($model, 'password', array('class' => 'col-sm-3 control-label')); ?>
            <div class="col-sm-5">
                <?php echo $form->passwordField($model, 'password', array('class' => 'span4 form-control')); ?>
            </div>
            <?php echo $form->error($model, 'password'); ?>
        </div>

        <div class="control-group form-group">
            <div class="col-sm-offset-3 col-sm-5">
                <div class="rememberMe checkbox span5" style="margin-left: 0px;">
                    <?php echo $form->checkBox($model, 'rememberMe'); ?>
                    <?php echo $form->label($model, 'rememberMe'); ?>
                    <?php echo $form->error($model, 'rememberMe'); ?>
                </div>
            </div>
        </div>

        <div class="control-group form-group buttons">
            <div class="col-sm-offset-3 col-sm-5">
                <?php echo CHtml::submitButton(Yii::t('common', 'login'), array('class' => 'btn btn-primary')); ?>
            </div>
        </div>

        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>