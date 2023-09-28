<div class="check_id">
    <h3><?php echo $widget_title; ?></h3>
    <ul>
        <?php foreach ($range as $ra) { ?>
        <label data-link="<?php echo $ra['link']; ?>" class="container product-range"><?php echo $ra['priceText']; ?> <input type="checkbox" class="tnn_pri" <?=($ra['active']) ? 'checked' : ''?>>
            <span class="checkmark"></span>
        </label>
        <?php } ?>
    </ul>
</div>
<script>
    $('.product-range').click(function () {
        var link = $(this).data('link');
        window.location.href = link;
    })
</script>