<?php if (count($videos)) { ?>
    <div class="video-right">
        <?php if ($show_widget_title) { ?>
            <div class="title-cmr">
                <h2> 
                    <a href="<?php echo Yii::app()->createUrl('media/video/all') ?>" title="<?php echo $widget_title ?>"><?php echo $widget_title ?></a> 
                    <span class="triangle"></span>
                </h2>
            </div>
        <?php } ?>
        <div class="video-cont">
            <?php
            foreach ($videos as $video) {
                ?>
                <iframe width="390" height="196" frameborder="0" src="<?php echo $video['video_embed']; ?>?autohide=1" allowfullscreen="1" allowtransparency="true">
                </iframe>
            <?php } ?>
        </div>
    </div>
<?php
} 