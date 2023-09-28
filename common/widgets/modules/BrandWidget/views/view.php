<?php
if (isset($brands) && $brands) {
    ?>
    <div class="our-venue">
        <?php if ($show_widget_title) { ?>
            <div class="left-our-venue">
                <h2><?php echo $widget_title ?></h2>
            </div>
        <?php } ?>
        <div class="right-our-venue">
            <div id="example5" class="slider-pro">

                <div class="sp-slides">

                    <?php foreach ($brands as $brand) { ?>
                        <div class="sp-slide">
                            <img class="sp-image" src="<?php echo Yii::app()->theme->baseUrl ?>/css/images/blank.gif"
                                 data-src="<?php echo ClaHost::getImageHost(), $brand['cover_path'], $brand['cover_name'] ?>"
                                 data-retina="<?php echo ClaHost::getImageHost(), $brand['cover_path'], $brand['cover_name'] ?>"/>

                            <div class="sp-caption">
                                <div class="location-img">
                                    <div class="goto-shop">
                                        <a href="<?= $brand['link_site'] ?>">Go to site</a>
                                    </div>
                                    <div class="ctn-shop">
                                        <p><i class="fa fa-map-marker"></i><?= $brand['address'] ?></p>
                                        <p><i class="fa fa-phone"></i><?= $brand['phone'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>

                <div class="sp-thumbnails">

                    <?php foreach ($brands as $brand) { ?>
                        <div class="sp-thumbnail">
                            <div class="sp-thumbnail-image-container">
                                <img class="sp-thumbnail-image" src="<?php echo ClaHost::getImageHost(), $brand['avatar_path'], $brand['avatar_name'] ?>"/>
                            </div>
                            <div class="sp-thumbnail-text">
                                <div class="sp-thumbnail-title"><?php echo $brand['name'] ?></div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#example5').sliderPro({
                width: "100%",
                height: 580,
                orientation: 'vertical',
                loop: false,
                arrows: true,
                buttons: false,
                thumbnailsPosition: 'left',
                thumbnailPointer: true,
                thumbnailWidth: 225,
                thumbnailHeight: 210,
                breakpoints: {
                    800: {
                        thumbnailsPosition: 'bottom',
                    },
                    500: {
                        thumbnailsPosition: 'bottom',
                    }
                }
            });
        });
    </script>
    <?php
}
?>