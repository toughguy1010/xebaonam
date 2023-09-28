<div class="form-search">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'htmlOptions' => array(
            'class' => "form-inline",
        ),
    ));
    $options_group = TourHotelGroup::getOptionsGroup();
    $option_star = array_combine(range(1,10), range(1, 10));
    $option_star = array('' => 'Số sao') + $option_star;
    ?>

    <?php echo $form->textField($model, 'name', array('class' => '', 'placeholder' => $model->getAttributeLabel('name'))); ?>
    <?php echo $form->dropDownList($model, 'star', $option_star, array('class' => '')); ?>
    <?php echo $form->dropDownList($model, 'group_id', $options_group, array('class' => '')); ?>
    <?php echo CHtml::submitButton(Yii::t('common', 'common_search'), array('class' => 'btn btn-sm')); ?>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->