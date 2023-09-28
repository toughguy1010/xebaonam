<?php if (count($videos)) { ?>
    <div class="panel panel-default videoho">
        <?php if ($show_widget_title) { ?>
            <div class="panel-heading">
                <h3><a href="<?php echo $link; ?>"><?php echo $widget_title; ?></a></h3>
            </div>
        <?php } ?>
        <div class="panel-body">
            <div class="videos">
                <?php
                foreach ($videos as $video) {
                    ?>
                    <iframe width="100%" height="100%" frameborder="0" src="<?php echo $video['video_embed']; ?>?autohide=1" allowfullscreen="1" allowtransparency="true">
                    </iframe>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>