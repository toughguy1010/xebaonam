<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/effects/imagesloaded.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/effects/masonry.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/prettyphoto/js/jquery.prettyPhoto.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/plugins/prettyphoto/css/prettyPhoto.css');
?>
<div class="album-title">
    <h2><?php echo $album->album_name; ?></h2>
</div>
<div id="image-box">
    <?php if ($images) { ?>
        <div class="row image-list">
            <?php foreach ($images as $image) {
                ?>
                <div class="col-xs-4 imageitem">
                    <a href="<?php echo ClaHost::getImageHost() . $image['path'] . 's1000_1000/' . $image['name'] ?>" class="thumbnail imageitem-a" rel="prettyPhoto[]">
                        <img src="<?php echo ClaHost::getImageHost() . $image['path'] . 's400_0/' . $image['name']; ?>" alt="<?php echo $image['name']; ?>"/>
                    </a>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>

<script>
    jQuery(document).ready(function() {
        //var $container = $('#algalley .alimglist').masonry('reloadItems');
        $('#image-box .image-list').imagesLoaded(function() {
            $('#image-box .image-list').masonry({
                itemSelector: '.imageitem',
                isAnimated: true
            });
        });
    });
    $("a[rel^='prettyPhoto']").prettyPhoto({overlay_gallery: false, slideshow:10000, hideflash: false, show_title: false, autoplay_slideshow: true, social_tools: '', deeplinking: false});
</script>