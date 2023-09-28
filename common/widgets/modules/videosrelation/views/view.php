<?php if (count($videos)) { 
     ?>

    <div class="videos-relation">
        <?php if ($show_widget_title) { ?>
            <div class="title clearfix">
                <div class="title_box">
                    <h2><?php echo $widget_title ?></h2>
                </div>
            </div>
        <?php } ?>

        <div class="list-videos clearfix">
            <?php foreach ($videos as $video) { ?>
                <div class="item-video-small col-sm-3">
                    <a href="<?php echo $video['link'] ?>">
                        <img src="<?php echo ClaHost::getImageHost() . $video['avatar_path'] . $video['avatar_name'] ?>">
                    </a>
                    <h3><a href="<?php echo $video['link'] ?>"><?php echo $video['video_title'] ?></a></h3>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>