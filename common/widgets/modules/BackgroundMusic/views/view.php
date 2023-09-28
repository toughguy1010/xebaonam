<div class="background-music">
    <?php if ($audio_path && $audio_name) { ?>
        <audio<?php if($showControl){ ?> controls<?php } ?><?php if($autoPlay){ ?> autoplay<?php } ?><?php if($repeat){ ?> loop<?php } ?>>
            <source src="<?php echo ClaHost::getImageHost() . $audio_path . $audio_name; ?>" type="audio/mpeg">
        </audio>
    <?php } ?>
</div>