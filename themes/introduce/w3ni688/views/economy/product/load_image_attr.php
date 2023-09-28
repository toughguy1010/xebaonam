<?php $themUrl = Yii::app()->theme->baseUrl; ?>

<?php
$first = reset($images) ? reset($images) : '';
?>
<div class="big-img" style="margin-bottom:10px;">
    <a id="magiczoommain" class="MagicZoom"
       title="<?php echo $first['alias'] ?>"
       href="<?php echo ClaHost::getImageHost(), $first['path'], $first['name'] ?>">
        <img
                src="<?php echo ClaHost::getImageHost(), $first['path'], 's800_600/', $first['name'] ?>"
                alt="<?php echo $first['alias'] ?>"/>
    </a>
</div>
<?php if ($images && count($images)) { ?>
    <div class="thumb-img">
        <div id="owl-details" class="owl-carousel owl-theme">
            <?php foreach ($images as $img) { ?>
                <a data-zoom-id="magiczoommain"
                   href="<?php echo ClaHost::getImageHost(), $img['path'], $img['name'] ?>"
                   data-image="<?php echo ClaHost::getImageHost(), $img['path'], 's500_500/', $img['name'] ?>"><img
                            src="<?php echo ClaHost::getImageHost(), $img['path'], 's50_50/', $img['name'] ?>"
                            alt="<?php echo $img['alias'] ?>"/></a>
            <?php } ?>
        </div>
    </div>
<?php } ?>
<script type="text/javascript" src="<?php echo $themUrl ?>/js/magiczoomplus.js"></script>
<script type="text/javascript" src="<?= $themUrl ?>/js/home/js/jquery.min.js"></script>
<script type="text/javascript" src="<?= $themUrl ?>/js/owl.carousel.min.js"></script>
<script>
    $(document).ready(function () {
        $('#owl-details').owlCarousel({
            items: 8,
            autoplay: true,
            autoplayTimeout: 6000,
            autoplaySpeed: 2000,
            loop: false,
            margin: 0,
            nav: false,
            dots: false,
            responsive: {
                0: {
                    items: 3
                },
                600: {
                    items: 7
                },
                1000: {
                    items: 7
                },
                1200: {
                    items: 7
                },
                1600: {
                    items: 8
                },
            },
        });
    });
</script>
