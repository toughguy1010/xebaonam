<div class="form-search">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'htmlOptions' => array(
            'class' => "form-inline",
        ),
    ));
    $options = array('' => Yii::t('common', 'status'))+SeAppointments::appointmentStatus();
    ?>

    <?php echo $form->textField($model, 'service_id', array('class' => '', 'placeholder' => $model->getAttributeLabel('service_id'))); ?>
    <?php echo $form->textField($model, 'provider_id', array('class' => '', 'placeholder' => $model->getAttributeLabel('provider_id'))); ?>
    <?php echo $form->dropDownList($model, 'status', $options, array('class' => '')); ?>
    <?php echo $form->textField($model, 'date', array('class' => '', 'placeholder' => $model->getAttributeLabel('date'))); ?>
    <?php echo CHtml::submitButton(Yii::t('common', 'common_search'), array('class' => 'btn btn-sm')); ?>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->