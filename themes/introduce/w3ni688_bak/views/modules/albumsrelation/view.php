<?php if (count($albums)) { ?>
    <div class="box-right products-lq">
        <?php if ($show_widget_title) { ?>
            <div class="title">
                <h2><?php echo $widget_title ?></h2>
            </div>
        <?php } ?>
        <div class="cont">
            <?php foreach ($albums as $album) { ?>
                <div class="item">
                    <div class="box-cont">
                        <div class="box-img">
                            <a href="<?php echo $album['link'] ?>">
                                <img src="<?php echo ClaHost::getImageHost() . $album['avatar_path'] . 's300_300/' . $album['avatar_name'] ?>">
                            </a>
                        </div>
                        <div class="product-information clearfix">
                            <div class="title-news-relation">
                                <h3><a href="<?php echo $album['link'] ?>"><?php echo $album['album_name'] ?></a></h3> 
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>