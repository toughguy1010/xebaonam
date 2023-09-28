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
    <?php echo $form->dropDownList($model, 'payonline', array('' =>'Tất cả','0' =>'Trả góp công ty tài chính','1' =>'Trả góp thẻ tín dụng')); ?>
    <?php echo $form->textField($model, 'username', array('class' => '', 'placeholder' => Yii::t('shoppingcart', 'customer')));
    $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
        'model' => $model, //Model object
        'name' => 'InstallmentOrder[from_date]', //attribute name
        'mode' => 'date',
        'value' => ((int)$model->from_date > 0) ? date('d-m-Y', (int)$model->from_date) : '',
        'language' => Yii::app()->language,
        'options' => array(
            'showSecond' => true,
            'dateFormat' => 'dd-mm-yy',
            'timeFormat' => 'HH:mm:ss',
            'controlType' => 'select',
            //'showOn' => 'button',
            'tabularLevel' => null,
            'addSliderAccess' => true,
            'sliderAccessArgs' => array('touchonly' => false),
        ), // jquery plugin options
        'htmlOptions' => array(
            'class' => '',
            'placeholder' => Yii::t('shoppingcart', 'from_date'),
        ),
    ));

    $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
        'model' => $model, //Model object
        'name' => 'InstallmentOrder[to_date]', //attribute name
        'mode' => 'date',
        'value' => ((int)$model->to_date > 0) ? date('d-m-Y', (int)$model->to_date) : '',
        'language' => Yii::app()->language,
        'options' => array(
            'showSecond' => true,
            'dateFormat' => 'dd-mm-yy',
            'timeFormat' => 'HH:mm:ss',
            'controlType' => 'select',
            //'showOn' => 'button',
            'tabularLevel' => null,
            'addSliderAccess' => true,
            'sliderAccessArgs' => array('touchonly' => false),
        ), // jquery plugin options
        'htmlOptions' => array(
            'class' => '',
            'placeholder' => Yii::t('shoppingcart', 'to_date'),
        ),
    ));
    ?>
    <?php echo CHtml::submitButton(Yii::t('common', 'common_search'), array('class' => 'btn btn-sm')); ?>
    <?php $this->endWidget(); ?>

</div><!-- search-form -->