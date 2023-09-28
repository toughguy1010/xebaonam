<?php

echo CHtml::textField('link', $data['link'], array('class' => 'support-input', 'placeholder' => Yii::t('support', 'pinterest_link')));
echo CHtml::textField('title', $data['title'], array('class' => 'support-input', 'placeholder' => Yii::t('support', 'pinterest_title')));
?>