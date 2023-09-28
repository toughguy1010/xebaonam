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
    <?php echo $form->textField($model, 'min_temp', array('class' => '', 'placeholder' => $model->getAttributeLabel('min_temp'))); ?>
    <?php echo $form->textField($model, 'max_temp', array('class' => '', 'placeholder' => $model->getAttributeLabel('max_temp'))); ?>
    <?php echo CHtml::submitButton(Yii::t('common', 'common_search'), array('class' => 'btn btn-sm')); ?>
    <?php $this->endWidget(); ?>
</div><!-- search-form -->