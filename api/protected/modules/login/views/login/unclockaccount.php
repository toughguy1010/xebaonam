<?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/login/signup.js');
?>
<div class="form-register">
    <div class="register">
        <h1>unlock account</h1>
        <div class="form">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'login-form',
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'htmlOptions' => array(
                    'class' => 'form-horizontal'
                )
            ));
            ?>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'code', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'code'); ?>
                    <?php echo $form->error($model, 'code'); ?>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <?php echo CHtml::submitButton('Unlock', array('class' => 'btn btn-info')); ?>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
