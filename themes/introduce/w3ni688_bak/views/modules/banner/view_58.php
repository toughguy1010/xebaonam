<?php
if (count($banners)) {
    ?>
    <div class="content-bci">
        <?php
        foreach ($banners as $banner) {
            ?>
            <a <?php echo Banners::getTarget($banner) ?> href="<?php echo $banner['banner_link'] ?>">
                <img <?php if ($height) { ?> height="<?php echo $height ?>" <?php }
                if ($width) { ?> width="<?php echo $width; ?>" <?php } ?> src="<?php echo $banner['banner_src'] ?>"
                                                                          alt="<?php echo $banner['banner_name'] ?>">
            </a>
        <?php } ?>
    </div>
<?php } ?>