<div class="title-ad-ft">
    <?php if ($show_widget_title) { ?>
        <h2><span><?php echo $widget_title ?></span></h2>
    <?php } ?>
</div>
<div class="box-ft box-map">
    <iframe style="width: 100%;" src="<?= $iframe_map ?>"
            width="<?= $width ?>"
            height="<?= $height ?>" frameborder="0" style="border:0" allowfullscreen></iframe>
</div>

