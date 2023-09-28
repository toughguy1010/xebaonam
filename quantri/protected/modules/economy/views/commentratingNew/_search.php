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
    <?php echo $form->dropDownList($model, 'type', CommentRating::getAryType(), array('class' => '')); ?>
    <?php echo $form->dropDownList($model, 'status', array('' => Yii::t('common', 'status')) + ActiveRecord::statusArray(), array('class' => '')); ?>

    <?php echo CHtml::submitButton(Yii::t('common', 'common_search'), array('class' => 'btn btn-sm')); ?>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->