<?php
$form_id = (isset($form->form_id) && $form->form_id) ? $form->form_id : 0;
?>
<script>
    $(function() {
        var fbname = <?php if ($form_id) echo '"' . Forms::FORM_DEFAULT_PRE . $form_id . '";'; else { ?> fbuilder.getNewFormName();
<?php } ?>
        $('#listfields').append('<div class=\'fb-main\'><input class="fbname" type="hidden" value="' + fbname + '"/>' + '<div class="fbitem" id="' + fbname + '"></div></div>');
        fbuilder.listfields[fbname] = new Formbuilder({
            selector: '#' + fbname,
            bootstrapData: <?php echo json_encode(isset($listfields) ? $listfields : array()); ?>
        });

        fbuilder.listfields[fbname].on('save', function(payload) {
        });
        fbuilder.order.push(fbname);
    });
</script>