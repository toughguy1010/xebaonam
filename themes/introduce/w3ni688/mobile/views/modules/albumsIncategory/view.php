<?php if (count($albums)) { ?>
    <div class="cyclo cyclo4 clearfix">
        <div class="container">
            <div class="cyclo-content cyclo4-content">
                <?php if ($show_widget_title) { ?>
                    <div class="title">
                        <h3><a href="javascript:void(0)" title="<?php echo $widget_title ?>"><?php echo $widget_title ?></a></h3>
                    </div>
                <?php } ?>
                <div class="content">
                    <?php
                    $i = 1;
                    $run = 1;
                    $cAlbum = count($albums);
                    foreach ($albums as $album) {
                        ?>
                        <?php if ($i == 1) { ?>
                            <div class="cyclo4-top">
                            <?php } elseif ($i == 4) { ?>
                                <div class="cyclo4-center">
                                <?php } ?>
                                <div class="dreg_45">
                                    <a href="<?php echo $album['link'] ?>">
                                        <img src="<?php echo ClaHost::getImageHost() . $album['avatar_path'] . 's350_350/' . $album['avatar_name']; ?>" alt="<?php echo $album['album_name']; ?>">
                                    </a>
                                </div>
                                <?php if ($i == 3 || $i == 7 || $run == $cAlbum) { ?>
                                </div>
                            <?php } ?>
                            <?php
                            $run++;
                            $i++;
                            if ($i == 8) {
                                $i = 1;
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>