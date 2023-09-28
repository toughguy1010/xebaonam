<?php if ($src) { ?>
    <div class="banner-one">
        <object <?php if ($height) { ?> height="<?php echo $height ?>" <?php } if ($width) { ?> width="<?php echo $width ?>" <?php } ?> >
            <param name="wmode" value="transparent">
            <param name="movie" value="<?php echo $src ?>">
            <embed <?php if ($height) { ?> height="<?php echo $height ?>" <?php } if ($width) { ?> width="<?php echo $width ?>" <?php } ?> src="<?php echo $src ?>" wmode="transparent">
        </object>
    </div>
<?php } ?>