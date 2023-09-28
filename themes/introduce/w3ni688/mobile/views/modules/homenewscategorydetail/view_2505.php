<div id="box-news-group">
    <?php
    foreach ($cateinhome as $cat) {
        $news = $data[$cat['cat_id']]['listnews'];
        if ($news) {
            ?>
            <div class="list-group-news-item">
                <div class="list-group-name">
                    <h3>
                        <?php echo $cat['cat_name']; ?>
                    </h3>
                </div>
                <div class="list-group-cont">
                    <?php
                    if (isset($data[$cat['cat_id']]['listnews'])) {
                        $first = ClaArray::getFirst($news);
                        $listnews = ClaArray::removeFirstElement($news);
                        ?>
                        <?php if ($first) { ?>
                            <div class="first-news">
                                <div class="first-news clearfix">
                                    <div class="first-news-img" style="">
                                        <a href="<?php echo $first['link']; ?>">
                                            <img src="<?php echo ClaHost::getImageHost() . $first['image_path'] . 's500_500/' . $first['image_name']; ?>">
                                        </a>
                                    </div>
                                    <div class="first-news-cont">
                                        <h4>
                                            <a href="<?php echo $first['link']; ?>" title=" <?php echo $first['news_title']; ?>">
                                                <?php echo $first['news_title']; ?>
                                            </a>
                                        </h4>
                                        <p><?php echo HtmlFormat::subCharacter($first['news_sortdesc'], ' ', 20); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="list-group-list-news">
                            <?php if ($listnews) { ?>
                                <?php foreach ($listnews as $news) { ?>
                                    <div class="box-news-in clearfix">
                                        <div class="box-img img-news-in">
                                            <a href="<?php echo $news['link']; ?>" title=" <?php echo $news['news_title']; ?>">
                                                <img alt=" <?php echo $ne['news_title']; ?>" src="<?php echo ClaHost::getImageHost() . $news['image_path'] . 's200_200/' . $news['image_name']; ?>">
                                            </a>
                                        </div>
                                        <div class="box-info">
                                            <h4> 
                                                <a href="<?php echo $news['link']; ?>">
                                                    <?php echo $news['news_title']; ?>
                                                </a>
                                            </h4>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                            <a href="<?php echo $cat['link']; ?>">Xem thêm các tin khác...</a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>