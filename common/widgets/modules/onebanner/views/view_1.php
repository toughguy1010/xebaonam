<?php if ($src) { ?>
<a class="banner-one" href="<?php echo $link; ?>" <?php echo $target; ?> title="<?php echo $widget_title; ?>">
        <img src="<?php echo $src ?>" <?php if ($height) { ?> height="<?php echo $height ?>" <?php } if ($width) { ?> width="<?php echo $width; ?>" <?php } ?> />
    </a>
<?php } ?>