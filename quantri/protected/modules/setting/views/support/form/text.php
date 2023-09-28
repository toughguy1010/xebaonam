<?php

echo CHtml::textArea('content', $data['content'], array('class' => 'support-input', 'placeholder' => Yii::t('support', 'text_help'), 'style' => 'min-width:60%;'));
?>