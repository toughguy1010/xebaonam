<?php if (count($albums)) { ?>
    <div class="albums-relation">
        <?php if ($show_widget_title) { ?>
            <div class="title clearfix">
                <div class="title_box">
                    <h2><?php echo $widget_title ?></h2>
                </div>
            </div>
        <?php } ?>

        <div class="list-albums clearfix">
            <?php foreach ($albums as $album) { ?>
                <div class="item-album-small col-sm-3">
                    <a href="<?php echo $album['link'] ?>">
                        <img src="<?php echo ClaHost::getImageHost().$album['avatar_path'].$album['avatar_name'] ?>">
                    </a>
                    <h3><a href="<?php echo $album['link'] ?>"><?php echo $album['album_name'] ?></a></h3>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>