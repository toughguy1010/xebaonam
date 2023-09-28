<?php
if (count($videos)) {
    foreach ($videos as $key => $value) {
        $video_top_id = $key;
        break;
    }
    $video_top = $videos[1];
    ?>
    <div id="gala" class="hide">
        <div class="itemSign itemSignright" style="padding:10px;">
            <div class="main-gl" id="danhmucvideos">
                <?php  foreach ($videos as $video) { ?>
                <iframe id="video" width="100%" height="133" frameborder="0" allowfullscreen="" src="<?= $video['video_embed']; ?>">
                </iframe>
                <?php break;} ?>
            </div>
            <div id="list-videos2">
                <ul id="list-videos" style="float:left; margin-top:5px;">
                    <?php if($videos) foreach ($videos as $video) { ?>
                        <li class="videohome" onclick="return showVideoAuto('<?= $video['video_embed']; ?>?autoplay=1');">
                            <p>
                                <img src="<?= ClaHost::getImageHost(), $video['avatar_path'], 's200_200/', $video['avatar_name']; ?>" alt="<?php echo $video['video_title'] ?>" alt="<?= $video['video_title']; ?>">
                            </p>
                            <h4 class="">
                                <i><?= $video['video_title']; ?> </i>
                            </h4>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
<?php } ?>

<script type="text/javascript">
    function showVideoAuto(link) {
        $('#video').attr('src', link);
    }
</script>