<?php if (count($videos)) { ?>
    <!--<div class="franchise ">-->
    <!--<div class="container clearfix">-->
    <?php foreach ($videos as $video) { ?>
        <div class="box-img-franchise ">
            <iframe id="youtube_video" width="370" height="337" frameborder="0" src="<?php echo $video['video_embed']; ?>?autohide=1" allowfullscreen="1" allowtransparency="true">
            </iframe>
        </div>
        <div class="box-info-franchise">
            <h2><?php echo $widget_title; ?></h2>
            <div class="cont">
                <p>
                    <i><?php echo $video['video_description']; ?> </i>
                </p>
            </div>
        </div>
    <?php } ?>
    <!--</div>-->
    <!--</div>-->
    <?php if (ClaSite::isMobile()) { ?>
        <style>
            #youtube_video {
                bottom: 0;
                margin: auto;
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
            }
        </style>
    <?php } ?>
<?php } ?>