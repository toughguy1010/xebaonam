<div class="listnews">
    <div class="list">
        <?php if (count($listnews)) { ?>
            <?php
            foreach ($listnews as $ne) {
                ?>
                <div class="list-item">
                    <div class="list-content">
                        <div class="list-content-box">
                            <?php if ($ne['image_path'] && $ne['image_name']) { ?>
                                <div class="list-content-img">
                                    <a href="<?php echo $ne['link']; ?>">
                                        <img src="<?php echo ClaHost::getImageHost() . $ne['image_path'] . 's200_200/' . $ne['image_name']; ?>">
                                    </a>
                                </div>
                            <?php } ?>
                            <div class="list-content-body">
                                <span class="list-content-title">
                                    <a href="<?php echo $ne['link']; ?>">
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
            'selectedPageCssClass' => 'active',
        ));
        ?>
    </div>
</div>