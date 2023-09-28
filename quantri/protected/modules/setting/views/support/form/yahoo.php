<?php

echo CHtml::textField('nick', $data['nick'], array('class' => 'support-input', 'placeholder' => Yii::t('support', 'yahoo_nick')));
echo CHtml::textField('title', $data['title'], array('class' => 'support-input', 'placeholder' => Yii::t('support', 'yahoo_title')));
?>