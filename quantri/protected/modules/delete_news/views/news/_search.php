<div class="form-search">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'htmlOptions' => array(
            'class' => "form-inline",
        ),
    ));
    $option0 = array(0 => Yii::t('news','news_category'));
    $option = $this->category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $option0);
    ?>

    <?php echo $form->textField($model, 'news_title', array('class' => '', 'placeholder' => $model->getAttributeLabel('news_title'))); ?>
    <?php echo $form->dropDownList($model, 'news_category_id', $option, array('class' => '')); ?>
    <?php echo CHtml::submitButton(Yii::t('common', 'common_search'), array('class' => 'btn btn-sm')); ?>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->