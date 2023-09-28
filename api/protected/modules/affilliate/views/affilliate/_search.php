<div class="form-search">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action'      => Yii::app()->createUrl($this->route),
        'method'      => 'get',
        'htmlOptions' => array(
            'class' => "form-inline",
        ),
    ));
    ?>
    <?php 
    $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
        'model'       => $model, //Model object
        'name'        => 'AffItems[from_date]', //attribute name
        'mode'        => 'date',
        'value'       => ((int) $model->from_date > 0) ? date('d-m-Y', (int) $model->from_date) : '',
        'language'    => Yii::app()->language,
        'options'     => array(
            'showSecond'       => true,
            'dateFormat'       => 'dd-mm-yy',
            'timeFormat'       => 'HH:mm:ss',
            'controlType'      => 'select',
            //'showOn' => 'button',
            'tabularLevel'     => null,
            'addSliderAccess'  => true,
            'sliderAccessArgs' => array('touchonly' => false),
        ), // jquery plugin options
        'htmlOptions' => array(
            'class'       => '',
            'placeholder' => Yii::t('shoppingcart', 'from_date'),
            'autocomplete' => 'off'
        ),
    ));

    $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
        'model'       => $model, //Model object
        'name'        => 'AffItems[to_date]', //attribute name
        'mode'        => 'date',
        'value'       => ((int) $model->to_date > 0) ? date('d-m-Y', (int) $model->to_date) : '',
        'language'    => Yii::app()->language,
        'options'     => array(
            'showSecond'       => true,
            'dateFormat'       => 'dd-mm-yy',
            'timeFormat'       => 'HH:mm:ss',
            'controlType'      => 'select',
            //'showOn' => 'button',
            'tabularLevel'     => null,
            'addSliderAccess'  => true,
            'sliderAccessArgs' => array('touchonly' => false),
        ), // jquery plugin options
        'htmlOptions' => array(
            'class'       => '',
            'placeholder' => Yii::t('shoppingcart', 'to_date'),
            'autocomplete' => 'off'
        ),
    ));
    ?>
    <?php echo CHtml::submitButton(Yii::t('common', 'common_search'), array('class' => 'btn btn-sm')); ?>
    <?php $this->endWidget(); ?>

</div><!-- search-form -->