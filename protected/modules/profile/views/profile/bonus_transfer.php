<h3 class="username-title"><?php echo Yii::t('bonus', 'bonus_transfer'); ?></h3>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'bonus-transfer-model-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'htmlOptions' => array(
        'class' => 'form-horizontal',
    ),
));
?>
<div class="profileif">
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'point_transfer', array('class' => 'control-label col-sm-2')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->textField($model, 'point_transfer', array('class' => 'span9 form-control')); ?>
            <?php echo $form->error($model, 'point_transfer'); ?>
        </div>
    </div>
    <!---->
<!--    <div class="control-group form-group">-->
<!--        --><?php //echo $form->labelEx($model, 'receiver_id', array('class' => 'control-label col-sm-2')); ?>
<!--        <div class="controls col-sm-10">-->
<!--            --><?php
//            echo $form->dropDownList($model, 'receiver_id', $users, array('class' => 'span9 form-control',));
//            ?>
<!--            --><?php //echo $form->error($model, 'receiver_id'); ?>
<!--        </div>-->
<!--    </div>-->
    <!---->
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'receiver_email', array('class' => 'control-label col-sm-2')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->textField($model, 'receiver_email', array('class' => 'span9 form-control')); ?>
            <?php echo $form->error($model, 'receiver_email'); ?>
        </div>
    </div>
    <!---->
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'custom_note', array('class' => 'control-label col-sm-2')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->textField($model, 'custom_note', array('class' => 'span9 form-control')); ?>
            <?php echo $form->error($model, 'custom_note'); ?>
        </div>
    </div>
    <!---->
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'password', array('class' => 'control-label col-sm-2')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->passwordField($model, 'password', array('class' => 'span9 form-control')); ?>
            <?php echo $form->error($model, 'password'); ?>
        </div>
    </div>

    <!---->
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?php echo CHtml::submitButton(Yii::t('common', 'send'),
                array('class' => 'btn btn-info', 'confirm' => 'Bạn có bạn chắc chắn muốn tặng điểm')); ?>
            <p style="color: blue"> Lưu ý: Gõ đúng mật khẩu để chuyển điểm.</p>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>