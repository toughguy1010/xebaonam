<div class="list-news">
    <?php if (count($listnews)) { ?>
        <?php
        foreach ($listnews as $ne) {
            ?>
            <div class="box-news-in clearfix">
                <div class="box-img img-news-in">
                    <a href="<?php echo $ne['link']; ?>">
                        <img src="<?php echo ClaHost::getImageHost() . $ne['image_path'] . 's200_200/' . $ne['image_name']; ?>">
                    </a>
                </div>
                <div class="box-info">
                    <h4><a href="<?php echo $ne['link']; ?>">
                            <?php echo $ne['news_title']; ?>
                        </a></h4>
                    <p><?php
                        echo $ne['news_sortdesc'];
                        ?>
                    </p>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>
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