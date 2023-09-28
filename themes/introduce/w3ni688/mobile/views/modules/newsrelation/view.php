<?php if (count($listnews)) { ?>
    <div class="box-right products-lq">
        <?php if ($show_widget_title) { ?>
            <div class="title">
                <h2><?php echo $widget_title ?></h2>
            </div>
        <?php } ?>
        <div class="cont">
            <?php foreach ($listnews as $news) { ?>
                <div class="item">
                    <div class="box-cont">
                        <div class="box-img">
                            <a href="<?php echo $news['link']; ?>" title="<?php echo $news['news_title']; ?>">
                                <img src="<?php echo ClaHost::getImageHost() . $news['image_path'] . 's280_280/' . $news['image_name'] ?>" alt="<?php echo $news['news_title'] ?>">
                            </a>
                        </div>
                        <div class="product-information clearfix">
                            <div class="title-news-relation">
                                <h3 title="<?php echo $news['news_title']; ?>">
                                    <a href="<?php echo $news['link']; ?>"><?php echo $news['news_title']; ?></a>
                                </h3> 
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>