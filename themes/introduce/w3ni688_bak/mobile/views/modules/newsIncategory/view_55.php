<?php if (count($news)) { ?>
    <div id="introduce-mobile" class="introduce-mobile">
        <div class="title">
            <?php if ($show_widget_title) { ?>
                <h2><?php echo $widget_title ?></h2>
            <?php } ?>
            <div class="box-img-introduce">
                <img src="<?php echo ClaHost::getImageHost() . $category['image_path'] . 's400_400/' . $category['image_name'] ?>"/>
            </div>
            <div class="box-info-introduce">
                <a href="<?php echo $category['link'] ?>">
                    <?php echo $category['cat_name'] ?>
                </a>
            </div>
        </div>
        <div class="content-intro-mobile">
            <ul>
                <?php foreach ($news as $new) { ?>
                    <li>
                        <div class="img-intro">
                            <a href="<?php echo $new['link'] ?>" title="<?php echo $new['news_title'] ?>">
                                <img alt="<?php echo $new['news_title'] ?>"
                                     src="<?php echo ClaHost::getImageHost(), $new['image_path'], 's300_300/', $new['image_name'] ?>"/>
                            </a>
                        </div>
                        <div class="info-intro">
                            <h3>
                                <a href="<?php echo $new['link'] ?>"
                                   title="<?php echo $new['news_title'] ?>"><?php echo $new['news_title'] ?></a>
                            </h3>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
<?php } ?>
