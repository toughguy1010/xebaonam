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

    <?php echo $form->textField($model, 'user_name', array('class' => '', 'placeholder' => $model->getAttributeLabel('user_name'))); ?>
    <?php echo $form->textField($model, 'phone', array('class' => '', 'placeholder' => $model->getAttributeLabel('phone'))); ?>
    <?php echo $form->textField($model, 'email', array('class' => '', 'placeholder' => $model->getAttributeLabel('email'))); ?>
    <?php echo CHtml::submitButton(Yii::t('common', 'common_search'), array('class' => 'btn btn-sm')); ?>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->