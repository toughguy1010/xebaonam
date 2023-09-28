<?php if ($banners && count($banners)) { ?>
    <div class="bannergroup-style-1" id="<?php echo $id; ?>">
        <div class="jcarousel-wrapper-none">
            <div class="script jcarousel">
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
                            </a>
                        </li>
                    <?php } ?>
                </ul>
                <a href="#" class="jcarousel-control-prev"></a>
                <a href="#" class="jcarousel-control-next"></a>
                <p class="jcarousel-pagination"></p>
            </div>
        </div>
        <!--end-script-->
    </div>
<?php } ?>