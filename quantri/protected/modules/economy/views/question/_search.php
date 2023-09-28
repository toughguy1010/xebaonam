<div class="form-search">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'htmlOptions' => array(
            'class' => "form-inline",
        ),
    ));
    $option0 = array('' => Yii::t('news','news_category'));
    $option = ActiveRecord::statusArrayQuestion();
    ?>

    <?php echo $form->textField($model, 'question_title', array('class' => '', 'placeholder' => $model->getAttributeLabel('news_title'))); ?>
    <?php echo $form->dropDownList($model, 'status', $option, array('class' => '')); ?>
    <?php echo CHtml::submitButton(Yii::t('common', 'common_search'), array('class' => 'btn btn-sm')); ?>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->