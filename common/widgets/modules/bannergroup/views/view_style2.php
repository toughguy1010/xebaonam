<div class="bannergroup-style-2" id="<?php echo $id; ?>">
    <div class="ivslider">
        <?php
        foreach ($banners as $banner) {
            if ($banner['banner_type'] == Banners::BANNER_TYPE_FLASH)
                continue;
            $height = $banner['banner_height'];
            $width = $banner['banner_width'];
            ?>
            <div data-iview:image="<?php echo $banner['banner_src']; ?>" data-iview:transition="block-random,zigzag-top,zigzag-bottom,strip-right-fade,strip-left-fade">
                <?php if ($banner['banner_link']) { ?>
                    <a href="<?php echo $banner['banner_link'] ?>" <?php echo Banners::getTarget($banner) ?> title="<?php echo $banner['banner_name']; ?>" style="display: block; width: 100%; height: 100%;">
                    <?php } ?>
                    <?php if ($banner['banner_description']) { ?>
                        <div class="iview-caption" data-transition="wipedown" vertical="bottom" data-x="50" data-y="50">
                            <?php echo $banner['banner_description']; ?>
                        </div>
                    <?php } ?>
                    <?php if ($banner['banner_link']) { ?>
                    </a>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>
<script>
    jQuery(document).ready(function() {
        setTimeout(function() {
            jQuery('#<?php echo $id; ?> .iviewSlider').css({'width': jQuery('#<?php echo $id; ?> .ivslider').width()});
        }, 1000);
    });
</script>