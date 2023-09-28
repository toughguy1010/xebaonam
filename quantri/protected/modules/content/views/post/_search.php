<div class="form-search">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'htmlOptions' => array(
            'class' => "form-inline",
        ),
    ));
    $option0 = array('' => Yii::t('post','post_category'));
    $option = $this->category->createOptionArray($this->category_id, ClaCategory::CATEGORY_STEP, $option0);
    ?>

    <?php echo $form->textField($model, 'title', array('class' => '', 'placeholder' => $model->getAttributeLabel('title'))); ?>
    <?php echo $form->dropDownList($model, 'category_id', $option, array('class' => '')); ?>
    <?php echo CHtml::submitButton(Yii::t('common', 'common_search'), array('class' => 'btn btn-sm')); ?>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->