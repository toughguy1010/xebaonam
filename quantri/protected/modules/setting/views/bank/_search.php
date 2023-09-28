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

    <?php echo $form->textField($model, 'name', array('class' => '', 'placeholder' => $model->getAttributeLabel('name'))); ?>
    <?php echo $form->textField($model, 'bank_name', array('class' => '', 'placeholder' => $model->getAttributeLabel('bank_name'))); ?>
    <?php echo $form->textField($model, 'number', array('class' => '', 'placeholder' => $model->getAttributeLabel('number'))); ?>
    <?php echo CHtml::submitButton(Yii::t('common', 'common_search'), array('class' => 'btn btn-sm')); ?>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->