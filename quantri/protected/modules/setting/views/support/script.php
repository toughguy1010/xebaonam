<script type="text/javascript">
    support = {};
    support.types = {};
    support.inputDefault = <?php echo json_encode($this->renderPartial('form/default', array(), true)); ?>;
    jQuery(document).ready(function() {
<?php
$types = SiteSupport::getSupportTypesArr();
?>
<?php foreach ($types as $type => $name) { ?>
            support.types.<?php echo $type; ?> = <?php echo json_encode($this->renderPartial('form/' . $type, array(), true)); ?>;
<?php } ?>
        jQuery(document).on('change', '.SupportType', function() {
            var type = $(this).val();
            var html = '';
            if (support.types[type])
                html = support.types[type];
            jQuery(this).closest('.support-item').find('.support-form').html(html);
        });

        //
        $('.support-add').on('click', function(e) {
            $('.support .list-support').append(support.inputDefault);
            //$(document).scrollTop($('.support .list-support .support-item:last').offset().top - 10);
            return false;
        });
        //
        $(document).on('click', '.support-removeItem', function(e) {
            if (jQuery(this).closest('.support-item').hasClass('has')) {
                if (confirm("<?php echo Yii::t('notice', 'areyousuredelete'); ?>"))
                    jQuery(this).closest('.support-item').remove();
            } else {
                jQuery(this).closest('.support-item').remove();
            }
            return false;
        });
        //
        $('#saveData').on('click', function(e) {
            var url = $(this).attr('href');
            if (!url)
                url = $(this).attr('src');
            if (url) {
                var dt = support.buildData();
                $.ajax({
                    method: 'POST',
                    url: url,
                    dataType: 'json',
                    data: {'SiteSupport': dt},
                    success: function(res) {
                        if (res.code == '200')
                            window.location.href = window.location.href;
                    }
                });
            }
            return false;
        });
        //
        $('.support .list-support').sortable({
            connectWith: '.list-support',
            items: '> .support-item',
            opacity: 0.8,
            revert: true,
            forceHelperSize: true,
            forcePlaceholderSize: true,
            tolerance: 'pointer'
        });
        //
//        if ($('.support .support-item').length == 0)
//            $('#saveData').hide();

    });
    //
    support.buildData = function() {
        var i = 0;
        var data = new Array();
        $('.support .support-item').each(function() {
            // Find disabled inputs, and remove the "disabled" attribute
            var disabled = $(this).find(':input:disabled').removeAttr('disabled');
            var fields = $(this).find(":input").serializeArray();
            var temp = {};
            disabled.attr('disabled', 'disabled');
            //
            jQuery.each(fields, function(i, field) {
                temp[field.name] = field.value;
            });
            data[i] = temp;
            i++;
        });
        return JSON.stringify(data);
    };

</script>