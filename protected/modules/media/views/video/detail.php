<div class="video-detail">
    <div class="video-player">
        <iframe width="100%" height="100%" frameborder="0" allowtransparency="true" allowfullscreen="1" src="<?php echo $video['video_embed'] . '?autohide=1&autoplay=1&rel=0'; ?>" id="videlplayer" class="lfloat">
        </iframe>
    </div>
    <div class="video-info">
        <div class="video-title">
            <h2><?php echo $video['video_title']; ?></h2>
        </div>
        <?php if($video['video_description']){ ?>
        <div class="video-description">
            <?php echo $video['video_description']; ?>
        </div>
        <?php } ?>
    </div>
</div>