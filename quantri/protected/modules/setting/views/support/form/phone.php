<?php

echo CHtml::textField('phone', $data['phone'], array('class' => 'support-input', 'placeholder' => Yii::t('support', 'phone_help')));
echo CHtml::textField('title', $data['title'], array('class' => 'support-input', 'placeholder' => Yii::t('common', 'title')));
?>