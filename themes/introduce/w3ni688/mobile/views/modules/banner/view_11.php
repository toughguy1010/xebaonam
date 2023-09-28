<?php if (count($banners)) { ?>
    <div id="owl-demo-banner" class="owl-carousel">
        <?php
        foreach ($banners as $banner) {
            ?>
            <div class="box-banner-top">
                <a <?php echo Banners::getTarget($banner) ?> href="<?php echo $banner['banner_link'] ?>">
                    <img <?php if ($height) { ?> height="<?php echo $height ?>" <?php } if ($width) { ?> width="<?php echo $width; ?>" <?php } ?> src="<?php echo $banner['banner_src'] ?>" alt="<?php echo $banner['banner_name'] ?>">
                </a>
            </div>
            <!--                <div class="box-banner-top">
                                <a <?php echo Banners::getTarget($banner) ?> href="<?php echo $banner['banner_link'] ?>">
                                    <img <?php if ($height) { ?> height="<?php echo $height ?>" <?php } if ($width) { ?> width="<?php echo $width; ?>" <?php } ?> src="<?php echo $banner['banner_src'] ?>" alt="<?php echo $banner['banner_name'] ?>">
                                </a>-->
            <!--</div>-->
        <?php }
        ?>
    </div>
    <?php $themUrl = Yii::app()->theme->baseUrl; ?>
    <script type="text/javascript" src="<?= $themUrl ?>/js/owl.carousel.min.js"></script> 
    <script>
        $(document).ready(function () {
            var owl = $("#owl-demo-banner");
            owl.owlCarousel({
                itemsCustom: [
                    [0, 2],
                ],
                navigation: false,
                autoPlay: true,
                rewindNav: false,
                pagination: false,
            });
        });
    </script>
    <?php
}
?>


