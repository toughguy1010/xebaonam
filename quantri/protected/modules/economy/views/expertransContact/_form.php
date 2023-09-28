<?php
/* @var $this ContactsController */
/* @var $model Contacts */
/* @var $form CActiveForm */
?>

<div class="form">
    <div class="col-xs-12 no-padding">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'bpo-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
        )); ?>
        <div class="form-group w3-form-group">
            <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'status', BpoForm::getStatusArr(), array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'status'); ?>
            </div>
        </div>
        <div class="form-group w3-form-group">
            <?php echo $form->labelEx($model, 'total_price', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'total_price', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'total_price'); ?>
            </div>
        </div>
        <div class="form-group w3-form-group">
            <?php echo $form->labelEx($model, 'payment_method', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
            <div class="col-xs-10 w3-form-field">
                <?php echo $form->dropDownList($model, 'payment_method', TranslateOrder::getPaymentMethod(), array('class' => 'form-control w3-form-input')); ?>
                <?php echo $form->error($model, 'payment_method'); ?>
            </div>
        </div>
        <div class="form-group w3-form-group">
            <?php echo $form->labelEx($model, 'payment_status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'payment_status', TranslateOrder::getPaymentStatus(), array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'payment_status'); ?>
            </div>
        </div>

        <div class="form-group w3-form-group">
            <?php if ($model->status != BpoForm::ORDER_WAITFORCOMPLETE) { ?>
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-info')); ?>
            <?php } ?>
            <a href="<?= Yii::app()->createUrl('economy/bpoOrder/') ?>" class="btn btn-danger">Back</a>
            <p style="color: red">Lưu ý đơn hàng hoàn thành sẽ không thể sửa lại</p>
        </div>
        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div><!-- form -->
<style>
    .form-group {
        margin-bottom: 15px;
    }
</style>