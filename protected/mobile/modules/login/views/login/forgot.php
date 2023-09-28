<div class="form">
    <div class="forgotpass">
        <h2>
            <?php echo Yii::t('user', 'user_forgotpass_title'); ?>
        </h2>
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'forgot-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
        ?>
        <div>
            <div class="action-field">
                <?php echo $form->labelEx($model, 'email', array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'email', array('class' => 'ui-form', 'id' => 'email_forgot')); ?>
            </div>
            <?php echo $form->error($model, 'email'); ?>
        </div>

        <div>
            <div style="clear:both"></div>
        </div>

        <div class="text">
            <?php echo Yii::t('user', 'user_forgotpass_help', array('{servername}' => Yii::app()->request->getServerName())) ?>
        </div>

        <div class="btn_send">
            <?php echo CHtml::submitButton(Yii::t('common', 'sendmail'), array('class' => 'btn btn-primary')); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div><!--support-->
</div>