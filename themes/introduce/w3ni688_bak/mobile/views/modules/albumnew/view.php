<?php if (count($albums)) { ?>
    <div class="col-xs-6 col-level1 row clearfix">
        <?php
        $i = 0;
        foreach ($albums as $album) { 
            $i++;
            if ($i == 3) {
                ?>
                <div class="col-xs-12">
                    <a href="javascript:void(0)">
                        <img src="<?php echo ClaHost::getImageHost(), $album['avatar_path'], 's550_550/', $album['avatar_name']; ?>" alt="<?php echo $video['video_title'] ?>" />
                    </a>
                </div>
                <?php
            } else {
                ?>
                <div class="col-xs-6">
                    <a href="javascript:void(0)">
                        <img src="<?php echo ClaHost::getImageHost(), $album['avatar_path'], 's250_0/', $album['avatar_name']; ?>" alt="<?php echo $video['video_title'] ?>" />
                    </a>
                </div>
                <?php
            }
        }
        ?>
    </div>
<?php } ?>