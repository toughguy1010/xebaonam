<?php
echo CHtml::dropDownList(ClaSite::PAGE_SIZE_VAR, $selected, $options, array(
    'onchange' => "window.location.href='" . $url . "'+jQuery(this).find('option:selected').val();",
    'class' => 'pzselect',
    'id' => 'price-high-to-low',
));
?>