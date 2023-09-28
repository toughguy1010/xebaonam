<?php if (count($videos)) { ?>
    <div class="video-hot-home">
        <?php foreach ($videos as $video) { ?>
            <iframe width="560" height="315" src="<?php echo $video['video_embed']; ?>" frameborder="0"
                    allowfullscreen="">
            </iframe>
        <?php } ?>
    </div>
<?php } ?>