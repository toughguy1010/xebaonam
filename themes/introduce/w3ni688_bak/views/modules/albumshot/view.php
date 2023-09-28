<?php
if (count($albums)) {
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/prettyphoto/js/jquery.prettyPhoto.js');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/plugins/prettyphoto/css/prettyPhoto.css');
    ?>
    <div class="col-xs-6 col-level1 row clearfix">
        <?php
        $i = 0;
        foreach ($albums as $album) {
            $i++;
            $tag_open = '<div class="row">';
            $tag_close = '</div>';
            $count_album = count($albums);
            if ($i == 3) {
                ?>
                <div class="col-xs-12">
                    <a href="<?php echo ClaHost::getImageHost(), $album['avatar_path'] . 's1000_1000/', $album['avatar_name'] ?>" rel="prettyPhoto<?php echo $album['album_id'] ?>[]">
                        <img src="<?php echo ClaHost::getImageHost(), $album['avatar_path'], 's550_550/', $album['avatar_name']; ?>" alt="<?php echo $video['video_title'] ?>" />
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
                </div>
                <script>
                    $("a[rel^='prettyPhoto<?php echo $album['album_id'] ?>']").prettyPhoto({overlay_gallery: false, slideshow: 10000, hideflash: false, show_title: false, autoplay_slideshow: true, social_tools: '', deeplinking: false});
                </script>
                <?php
            } else {
                if ($i == 1) {
                    echo $tag_open;
                }
                ?>
                <div class="col-xs-6">
                    <a href="<?php echo ClaHost::getImageHost(), $album['avatar_path'] . 's1000_1000/', $album['avatar_name'] ?>" rel="prettyPhoto<?php echo $album['album_id'] ?>[]">
                        <img src="<?php echo ClaHost::getImageHost(), $album['avatar_path'], 's250_0/', $album['avatar_name']; ?>" alt="<?php echo $video['video_title'] ?>" />
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
                </div>
                <script>
                    $("a[rel^='prettyPhoto<?php echo $album['album_id'] ?>']").prettyPhoto({overlay_gallery: false, slideshow: 10000, hideflash: false, show_title: false, autoplay_slideshow: true, social_tools: '', deeplinking: false});
                </script>
                <?php
                if ($count_album == 1 && $i == 1) {
                    echo $tag_close;
                } else if ($count_album >=2 && $i == 2) {
                    echo $tag_close;
                }
            }
        }
        ?>
    </div>

    <?php
} 