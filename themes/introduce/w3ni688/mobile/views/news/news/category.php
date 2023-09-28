<?php if (count($listnews)) { ?>
    <?php
    $first = ClaArray::getFirst($listnews);
    $listnews = ClaArray::removeFirstElement($listnews);
    ?>
    <?php if ($first) {
        ?>
        <div class="col-sm-6">
            <a href="<?php echo $first['link']; ?>" title="<?php echo $first['news_title']; ?>" class="item-news clearfix">
                <div class="box-img-news">
                    <img src="<?php echo ClaHost::getImageHost() . $first['image_path'] . 's300_300/' . $first['image_name']; ?>">
                </div>
                <div class="box-info">
                    <h4 class="title-item-news"><?php echo $first['news_title']; ?></h4>
                </div>
            </a>
        </div>

        <?php
    }
    if ($listnews) {
        foreach ($listnews as $ne) {
            ?>
            <div class="col-sm-6">
                <a href="<?php echo $ne['link']; ?>" title="<?php echo $ne['news_title']; ?>" class="item-news clearfix">
                    <div class="box-img-news">
                        <img src="<?php echo ClaHost::getImageHost() . $ne['image_path'] . 's300_300/' . $ne['image_name']; ?>">
                    </div>
                    <div class="box-info">
                        <h4 class="title-item-news"><?php echo $ne['news_title']; ?></h4>
                    </div>
                </a>
            </div>
            <?php
        }
    }
    ?>
    <div class="wpager">
        <?php
        $this->widget('common.extensions.LinkPager.LinkPager', array(
            'itemCount' => $totalitem,
            'pageSize' => $limit,
            'header' => '',
            'selectedPageCssClass' => 'active',
        ));
        ?>
    </div>
<?php } ?>