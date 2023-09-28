<div class="news">
    <div class="list">
        <?php if (count($news)) { ?>
            <?php
            foreach ($news as $ne) {
                ?>
                <div class="list-item">
                    <div class="list-content">
                        <div class="list-content-box">
                            <?php if ($ne['image_path'] && $ne['image_name']) { ?>
                                <div class="list-content-img">
                                    <a href="<?php echo $ne['link']; ?>" title="<?php echo $ne['news_title']; ?>">
                                        <img src="<?php echo ClaHost::getImageHost() . $ne['image_path'] . 's200_200/' . $ne['image_name']; ?>" alt="<?php echo $ne['news_title']; ?>" />
                                    </a>
                                </div>
                            <?php } ?>
                            <div class="list-content-body">
                                <span class="list-content-title">
                                    <a href="<?php echo $ne['link']; ?>" title="<?php echo $ne['news_title']; ?>">
                                        <?php echo $ne['news_title']; ?>
                                    </a>
                                </span>
                                <div class="list-content-detail">
                                    <p>
                                        <?php
                                        echo $ne['news_sortdesc'];
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
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
            'htmlOptions' => array('class' => 'W3NPager',), // Class for ul
            'selectedPageCssClass' => 'active',
        ));
        ?>
    </div>
</div>