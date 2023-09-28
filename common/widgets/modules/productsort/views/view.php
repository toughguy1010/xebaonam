<span class="w3nproductsort">
    <?php if ($summaryText) { ?>
        <span class='pssummarytext'><?php echo $summaryText ?></span>
    <?php } ?>
    <?php
    echo CHtml::dropDownList(ClaSite::PAGE_SIZE_VAR, $selected, $options, array(
        'onchange' => "window.location.href='" . $url . "'+jQuery(this).find('option:selected').val();",
        'class' => 'pzselect',
    ));
    ?>
    <?php if ($afterText) { ?>
        <span class="psaftertext"><?php echo $afterText; ?></span>
    <?php } ?>
</span>