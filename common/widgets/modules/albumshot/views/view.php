<?php if (count($albums)) { ?>
    <div class="panel panel-default menu-vertical">
        <?php if ($show_widget_title) { ?>
            <div class="panel-heading">
                <div class="title-main">
                    <h3><?php echo $widget_title; ?></h3>
                </div>
            </div>
        <?php } ?>
        <div class="panel-body">
            <?php foreach ($albums as $album) { ?>
                <a class="img" href="<?php echo $album['link']; ?>">
                    <img src="<?php echo ClaHost::getImageHost() . $album['avatar_path'] . 's250_250/' . $album['avatar_name']; ?>" />
                    <p><?php echo $album['album_name']; ?></p>
                </a>
            <?php } ?>
        </div>
    </div>
<?php } ?>