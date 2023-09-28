<?php if ($banners && count($banners)) { ?>
<div class="bannergroup-default" id="<?php echo $id ?>">
        <div class="jcarousel-wrapper">
            <a class="jcarousel-control-next" href="#" data-jcarouselcontrol="true"></a>
            <a class="jcarousel-control-prev" href="#" data-jcarouselcontrol="true"></a>
            <div class="jcarousel">
                <ul>
                    <?php
                    foreach ($banners as $banner) {
                        if ($banner['banner_type'] == Banners::BANNER_TYPE_FLASH)
                            continue;
                        $height = $banner['banner_height'];
                        $width = $banner['banner_width'];
                        ?>
                        <li>
                            <a href="<?php echo $banner['banner_link'] ?>" <?php echo Banners::getTarget($banner) ?> title="<?php echo $banner['banner_name']; ?>">
                                <img src="<?php echo $banner['banner_src']; ?>" <?php if ($height) { ?> height="<?php echo $height ?>" <?php } if ($width) { ?> width="<?php echo $width; ?>" <?php } ?> alt="<?php echo $banner['banner_name']; ?>"/>
                                <div class="nd-banner">
                                    <p><?php echo $banner['banner_description']; ?></p>
                                </div>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
<?php } ?>