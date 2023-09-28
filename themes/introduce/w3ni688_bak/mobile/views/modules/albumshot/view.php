<?php if (count($albums)) { ?>
    <div id="collection" class="collection collection1">
        <!--<div class="container">-->
        <?php if ($show_widget_title) { ?>
            <div class="title">
                <a href="">
                    <h2 class="title-block-detail"><?php echo $widget_title ?></h2>
                </a>
            </div>
        <?php } ?>
        <div id="demo">
            <div id="owl-demo-album" class="owl-carousel">
                <?php
                foreach ($albums as $album) {
                    ?>
                    <div class="item">
                        <a href="<?php echo $album['link'] ?>">
                            <img src="<?php echo ClaHost::getImageHost(), $album['avatar_path'], 's250_0/', $album['avatar_name']; ?>"
                                 alt="<?php echo $album['album_name']; ?>"/>
                        </a>
                    </div>
                <?php } ?>
            </div>
            <!--</div>-->
        </div>
    </div>
<?php } ?>
