<?php if ($banners && count($banners)) { ?>
    <div id="slider">
        <div id="owl-demo-bn" class="owl-carousel">
            <?php
            foreach ($banners as $banner) {
                if ($banner['banner_type'] == Banners::BANNER_TYPE_FLASH) {
                    continue;
                }
                $height = $banner['banner_height'];
                $width = $banner['banner_width'];
                ?>
                <div class="item-slider">
                    <a style="display: block;" href="<?php echo $banner['banner_link'] ?>" title="<?php echo $banner['banner_name'] ?>">
                        <img alt="<?php echo $banner['banner_name']; ?>" src="<?php echo $banner['banner_src']; ?>" alt="<?php echo $banner['banner_name']; ?>"/>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            var owl = $("#owl-demo-bn");
            owl.owlCarousel({
                itemsCustom: [
                    [0, 1],
                ],
                navigation: true,
                autoPlay: true,
            });
        });
    </script>
    <?php
}
