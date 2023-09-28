<div class="form-search">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'htmlOptions' => array(
            'class' => "form-inline",
        ),
    ));        
    $option = ProductAttributeSet::model()->getAttributeSetOptions();
    ?>

    <?php echo $form->textField($model, 'name', array('class' => '', 'placeholder' => $model->getAttributeLabel('name'))); ?>    
    <?php echo $form->dropDownList($model, 'attribute_set_id',$option, array('empty'=>"-- Nhóm thuộc tính --",'class' => '')); ?>
    <?php echo CHtml::submitButton(Yii::t('common', 'common_search'), array('class' => 'btn btn-sm')); ?>
    <?php $this->endWidget(); ?>
</div><!-- search-form -->