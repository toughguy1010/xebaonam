<div class="form-search">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'htmlOptions' => array(
            'class' => "form-inline",
        ),
    ));
    echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 100, 'placeholder' => 'Tên khách hàng'));
    echo $form->dropDownList($model, 'status', array('' => 'Tình trạng đơn hàng') + Orders::getStatusArr());
    echo $form->dropDownList($model, 'payment_status', array('' => 'Tình trạng thanh toán') + TranslateOrder::getPaymentStatus());
    echo $form->dropDownList($model, 'payment_method', array('' => 'Phương thức thanh toán') + TranslateOrder::getPaymentMethod());
    echo CHtml::submitButton(Yii::t('common', 'common_search'), array('class' => 'btn btn-sm')); ?>
    <?php $this->endWidget(); ?>

</div>