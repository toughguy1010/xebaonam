<?php if (count($banners)) { ?>
    <?php if ($show_widget_title) { ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php echo $widget_title; ?>
            </div>
        <?php } ?>
        <div class="banner">
            <?php
            foreach ($banners as $banner) {
                $height = $banner['banner_height'];
                $width = $banner['banner_width'];
                $src = $banner['banner_src'];
                $link = $banner['banner_link'];
                if ($banner['banner_type'] == Banners::BANNER_TYPE_IMAGE) {
                    ?>
                    <a href="<?php echo $link; ?>" <?php echo Banners::getTarget($banner) ?> title="<?php echo $banner['banner_name']; ?>">
                        <img src="<?php echo $src; ?>" <?php if ($height) { ?> height="<?php echo $height ?>" <?php } if ($width) { ?> width="<?php echo $width; ?>" <?php } ?> alt="<?php echo $banner['banner_name']; ?>"/>
                    </a>
                <?php } else { ?>
                    <object <?php if ($height) { ?> height="<?php echo $height ?>" <?php } if ($width) { ?> width="<?php echo $width ?>" <?php } ?> >
                        <param name="wmode" value="transparent">
                        <param name="movie" value="<?php echo $src ?>">
                        <embed <?php if ($height) { ?> height="<?php echo $height ?>" <?php } if ($width) { ?> width="<?php echo $width ?>" <?php } ?> src="<?php echo $src ?>" wmode="transparent">
                    </object>
                <?php } ?>
            <?php } ?>
        </div>
        <?php if ($show_widget_title) { ?>
        </div>
    <?php } ?>
<?php } ?>