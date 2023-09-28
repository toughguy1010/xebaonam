<div class="form-search">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'htmlOptions' => array(
            'class' => "form-inline",
        ),
    ));
    $option0 = array('' => Yii::t('car', 'car_category'));
    $option = $this->category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $option0);
    ?>

    <?php echo $form->textField($model, 'name', array('class' => '', 'placeholder' => $model->getAttributeLabel('name'))); ?>
    <?php echo $form->dropDownList($model, 'car_category_id', $option, array('class' => '')); ?>
    <?php echo CHtml::submitButton(Yii::t('common', 'common_search'), array('class' => 'btn btn-sm')); ?>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->