<?php
if (count($listnews)) {
    if ($listnews) {
        ?>
        <div class="content-repairs clearfix">

            <?php
            foreach ($listnews as $ne) {
                ?>
                <div class="col-sm-4">
                    <div class="item-repairs clearfix">
                        <div class="box-img-repairs">
                            <a href="<?php echo $ne['link']; ?>" title=" <?php echo $ne['news_title']; ?>">
                                <img alt=" <?php echo $ne['news_title']; ?>" src="<?php echo ClaHost::getImageHost() . $ne['image_path'] . 's200_200/' . $ne['image_name']; ?>">
                            </a>
                        </div>
                        <div class="box-info">
                            <h4 class="title-item-repairs"> <a href="<?php echo $ne['link']; ?>">
                                    <?php echo $ne['news_title']; ?>
                                </a></h4>
                            <div class="description-repairs">
                                <?php
                                echo HtmlFormat::subCharacter($ne['news_sortdesc'], ' ', 20);
                                ?>
                            </div>
                            <a href="<?php echo $ne['link']; ?>" title=" <?php echo $ne['news_title']; ?>">Chi tiết</a>
                        </div>
                    </div>
                </div>
            <?php }
            ?>
        </div>
        <?php
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
    <?php
} 