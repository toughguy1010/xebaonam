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

    <?php echo $form->textField($model_customer, 'name', array('class' => '', 'placeholder' => $model_customer->getAttributeLabel('name'))); ?>
    <?php echo $form->textField($model_customer, 'phone', array('class' => '', 'placeholder' => $model_customer->getAttributeLabel('phone'))); ?>
    <?php echo $form->textField($model_customer, 'provider_key', array('class' => '', 'placeholder' => $model_customer->getAttributeLabel('provider_key'))); ?>
    <?php
    $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
        'model' => $model_customer, //Model object
        'name' => 'SmsCustomer[from_datesearch]', //attribute name
        'mode' => 'date', //use "time","date" or "datetime" (default)
        'value' => ((int) $model_customer->from_datesearch > 0 ) ? date('d-m-Y H:i:s', (int) $model_customer->from_datesearch) : '',
        'language' => 'vi',
        'options' => array(
            'dateFormat' => 'dd-mm-yy',
            'timeFormat' => 'HH:mm:ss',
            'controlType' => 'select',
            'stepHour' => 1,
            'stepMinute' => 1,
            'stepSecond' => 1,
            //'showOn' => 'button',
            'showSecond' => false,
            'changeMonth' => false,
            'changeYear' => false,
            'tabularLevel' => null,
        //'addSliderAccess' => true,
        //'sliderAccessArgs' => array('touchonly' => false),
        ), // jquery plugin options
        'htmlOptions' => array(
            'placeholder' => 'Từ ngày',
        )
    ));
    ?>
    <?php
    $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
        'model' => $model_customer, //Model object
        'name' => 'SmsCustomer[to_datesearch]', //attribute name
        'mode' => 'date', //use "time","date" or "datetime" (default)
        'value' => ((int) $model_customer->to_datesearch > 0 ) ? date('d-m-Y H:i:s', (int) $model_customer->to_datesearch) : '',
        'language' => 'vi',
        'options' => array(
            'dateFormat' => 'dd-mm-yy',
            'timeFormat' => 'HH:mm:ss',
            'controlType' => 'select',
            'stepHour' => 1,
            'stepMinute' => 1,
            'stepSecond' => 1,
            //'showOn' => 'button',
            'showSecond' => false,
            'changeMonth' => false,
            'changeYear' => false,
            'tabularLevel' => null,
        //'addSliderAccess' => true,
        //'sliderAccessArgs' => array('touchonly' => false),
        ), // jquery plugin options
        'htmlOptions' => array(
            'placeholder' => 'Đến ngày',
        )
    ));
    ?>
    <?php echo CHtml::submitButton(Yii::t('common', 'common_search'), array('class' => 'btn btn-sm')); ?>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->