<span class="w3npagesize">
    <?php if ($summaryText) { ?>
        <span class='pzsummarytext'><?php echo $summaryText ?></span>
    <?php } ?>
    <?php
    echo CHtml::dropDownList(ClaSite::PAGE_SIZE_VAR, $pageSize, $options, array(
        'onchange' => "window.location.href='" . $url . "'+jQuery(this).find('option:selected').val();",
        'class' => 'pzselect',
    ));
    ?>
    <?php if ($afterText) { ?>
        <span class="pzaftertext"><?php echo $afterText; ?></span>
    <?php } ?>
</span>