
<?php if (count($images)) { ?>
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
                    <?php foreach ($images as $image) { ?>
                        <div class="item">
                            <div class="box-img img-collection">
                                <a href="<?php echo Yii::app()->createUrl('/media/album/detail', array('id' => $image['album_id'])); ?>">
                                    <img u="image"  alt="<?php echo $image['name'] ?>" src="<?php echo ClaHost::getImageHost() . $image['path'] . 's250_250/' . $image['name']; ?>"/>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                </div>  
            </div>  
        </div>  
    </div>  
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
<?php } ?>
