<?php if (count($videos)) { ?>
    <div class="video-hot-mobile">
        <div class="title-vhm">
            <?php if ($show_widget_title) { ?>
                <h2><?php echo $widget_title ?></h2>
            <?php } ?>
        </div>
        <div class="content-vhm">
            <?php foreach ($videos as $video) { ?>
                <div class="box-img-franchise ">
                    <iframe id="youtube_video" width="100%" height="337" frameborder="0"
                            src="<?php echo $video['video_embed']; ?>?autohide=1" allowfullscreen="1"
                            allowtransparency="true">
                    </iframe>
                </div>
                <div class="box-info-franchise">
                    <div class="cont">
                        <?php echo $video['video_description']; ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>