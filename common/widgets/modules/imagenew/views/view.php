<?php if (count($images)) { ?>
    <div class="panel panel-default menu-vertical">
        <?php if ($show_widget_title) { ?>
            <div class="panel-heading">
                <div class="title-main">
                    <a href="<?php echo $link; ?>"><h3><?php echo $widget_title; ?></h3></a>
                </div>
            </div>
        <?php } ?>
        <div class="panel-body">
            <?php foreach ($images as $image) { ?>
                <img src="<?php echo ClaHost::getImageHost() . $image['path'] . 's200_200/' . $image['name']; ?>" />
            <?php } ?>
        </div>
    </div>
<?php } ?>