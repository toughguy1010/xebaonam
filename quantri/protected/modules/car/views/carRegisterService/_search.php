<div class="form-search">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'htmlOptions' => array(
            'class' => "form-inline",
        ),
    ));
    ?>

    <?php echo $form->textField($model, 'customer_name', array('class' => '', 'placeholder' => $model->getAttributeLabel('customer_name'))); ?>
    <?php echo $form->textField($model, 'customer_email', array('class' => '', 'placeholder' => $model->getAttributeLabel('customer_email'))); ?>
    <?php echo $form->textField($model, 'customer_phone', array('class' => '', 'placeholder' => $model->getAttributeLabel('customer_phone'))); ?>
    <?php echo CHtml::submitButton(Yii::t('common', 'common_search'), array('class' => 'btn btn-sm')); ?>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->