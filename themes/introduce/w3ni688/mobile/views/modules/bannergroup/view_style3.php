<div class="title">
    <div class="title-cont">
        <?php if ($show_widget_title) { ?>
            <h2><?php echo $widget_title ?></h2>
        <?php } ?>
    </div>
</div>
<?php if ($banners && count($banners)) { ?>
    <div class="box-js">
        <div class="js">
            <div class="jcarousel-wrapper"> 
                <div class="jcarousel" data-jcarousel="true" data-jcarouselautoscroll="true">
                    <ul style="left: -220.376328959382px; top: 0px;">
                        <?php foreach ($banners as $banner) { ?>
                            <li> 
                                <a href="<?php echo $banner['banner_link'] ?>" <?php echo Banners::getTarget($banner) ?> target="_blank" title="<?php echo $banner['banner_name'] ?>"> 
                                    <img alt="<?php echo $banner['banner_name'] ?>" src="<?php echo $banner['banner_src']; ?>" <?php if ($height) { ?> height="<?php echo $height ?>" <?php } if ($width) { ?> width="<?php echo $width; ?>" <?php } ?> alt="<?php echo $banner['banner_name']; ?>">
                                </a> 
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
