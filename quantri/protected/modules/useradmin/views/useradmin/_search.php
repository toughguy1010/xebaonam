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

    <?php
    if (Yii::app()->controller->site_id == ClaSite::ROOT_SITE_ID) {
        echo $form->textField($model, 'site_id', array('class' => '', 'placeholder' => $model->getAttributeLabel('site_id')));
    }
    ?>
    <?php echo $form->textField($model, 'user_id', array('class' => '', 'placeholder' => $model->getAttributeLabel('user_id'))); ?>
    <?php echo $form->textField($model, 'email', array('class' => '', 'placeholder' => $model->getAttributeLabel('email'))); ?>
    <?php echo $form->dropDownList($model, 'sex', array('' => $model->getAttributeLabel('sex')) + ClaUser::getListSexArr(), array('class' => '')); ?>
    <?php echo CHtml::submitButton(Yii::t('common', 'common_search'), array('class' => 'btn btn-sm')); ?>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->