<div class="form-search">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'htmlOptions' => array(
            'class' => "form-inline",
        ),
    ));
    $option0 = array('' => Yii::t('translate', 'translate_category'));
    $option = ActiveRecord::statusArrayQuestion();
    ?>

    <?php echo $form->dropDownList($model, 'from_lang', ['' => 'Chọn ngôn ngữ cần dịch'] + ClaLanguage::getCountries(), array('class' => '')); ?>
    <?php echo $form->dropDownList($model, 'to_lang', ['' => 'Chọn ngôn ngữ cần dịch sang'] + ClaLanguage::getCountries(), array('class' => '')); ?>
    <?php echo $form->dropDownList($model, 'status', $option, array('class' => '')); ?>
    <?php echo $form->textField($model, 'aff_percent', array('class' => '','placeholder'=>'% Aff')); ?>
    <?php echo CHtml::submitButton(Yii::t('common', 'common_search'), array('class' => 'btn btn-sm')); ?>
    <?php $this->endWidget(); ?>

</div><!-- search-form -->