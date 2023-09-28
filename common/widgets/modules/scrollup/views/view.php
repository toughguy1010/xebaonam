<script type="text/javascript">
    jQuery(document).ready(function() {
        $("body").append("<a class=\"scrollup\" href=\"#\" id=\"<?php echo $btnID; ?>\"></a>");
        $(document).on('scroll', function() {
            if ($(this).scrollTop() > <?php echo $fromTop; ?>) {
                $('#<?php echo $btnID; ?>').fadeIn('slow');
            } else {
                $('#<?php echo $btnID; ?>').fadeOut();
            }
        });
        //
        $('#<?php echo $btnID; ?>').click(function() {
            $("html, body").animate({
                scrollTop: 0
            }, <?php echo $scrollTime; ?>);
            return false;
        });
    });
</script>