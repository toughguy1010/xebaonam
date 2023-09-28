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

    <?php echo $form->textField($model, 'site_id', array('class' => '', 'placeholder' => 'Tên miền')); ?>
    <?php if (!$model->disk) { ?>
        <?php echo $form->dropDownList($model, 'disk', array('' => 'Tất cả', '1' => 'Vượt giới hạn', '2' => 'Mức cảnh báo', '3' => 'Mức trung bình', '4' => 'Sử dụng ít')); ?>
    <?php } ?>
    <?php echo CHtml::submitButton(Yii::t('common', 'common_search'), array('class' => 'btn btn-sm')); ?>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->