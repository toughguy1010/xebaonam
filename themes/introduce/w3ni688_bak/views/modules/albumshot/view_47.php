<?php if (count($albums)) { ?>
    <?php $themUrl = Yii::app()->theme->baseUrl; ?>
    <script type="text/javascript" src="<?= $themUrl ?>/js/owl.carousel.min.js"></script> 
    <script>
        $(document).ready(function () {
            var owl = $("#owl-demo");
            owl.owlCarousel({
                itemsCustom: [
                    [0, 4],
                ],
                navigation: false,
                autoPlay: true,
            });
        });
    </script>
    <?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/prettyphoto/js/jquery.prettyPhoto.js');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/plugins/prettyphoto/css/prettyPhoto.css');
    ?>
    <!--<div class="col-xs-6 col-level1 row clearfix">-->
    <?php
//        $i = 0;
//        foreach ($albums as $album) {
//            $i++;
//            $tag_open = '<div class="row">';
//            $tag_close = '</div>';
//            $count_album = count($albums);
    ?>
    <div id="collection">
        <div class="container">
            <?php if ($show_widget_title) { ?>
                <div class="title">
                    <h2><?php echo $widget_title ?></h2>
                </div>
            <?php } ?>
            <div id="demo">
                <div id="owl-demo" class="owl-carousel">
                    <!-- Slides Container -->
                    <?php foreach ($albums as $album) { ?>
                        <div class="item">
                            <div class="box-img img-collection">
                                <a href="<?php echo ClaHost::getImageHost(), $album['avatar_path'] . 's1000_1000/', $album['avatar_name'] ?>" rel="prettyPhoto<?php echo $album['album_id'] ?>[]">
                                    <img src="<?php echo ClaHost::getImageHost(), $album['avatar_path'], 's1000_1000/', $album['avatar_name']; ?>" alt="<?php echo $video['video_title'] ?>" />
                                </a>
                                <div style="display: none">
                                    <?php
                                    $images = Albums::getImages($album['album_id']);
                                    foreach ($images as $image) {
                                        ?>
                                        <a href="<?php echo ClaHost::getImageHost(), $image['path'], 's1000_1000/', $image['name'] ?>" class="thumbnail imageitem-a" rel="prettyPhoto<?php echo $album['album_id'] ?>[]">
                                            <img src="<?php echo ClaHost::getImageHost(), $image['path'], 's250_0/', $image['name']; ?>" alt="<?php echo $image['name']; ?>"/>
                                        </a>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <script>
                                    $("a[rel^='prettyPhoto<?php echo $album['album_id'] ?>']").prettyPhoto({overlay_gallery: false, slideshow: 10000, hideflash: false, show_title: false, autoplay_slideshow: true, social_tools: '', deeplinking: false});
                                </script>
                            </div>
                        </div>
                    <?php } ?>
                </div>  
            </div>  
        </div>  
    </div>  
    <?php
//        }
    ?>
    <!--</div>-->

<?php }
?>