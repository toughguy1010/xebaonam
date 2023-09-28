<div class="videobox">
    <div class="list grid media">
        <?php foreach ($videos as $video) { ?>
            <div class="list-item">
                <div class="list-content">
                    <div class="list-content-box">
                        <div class="list-content-img">
                            <a href="<?php echo $video['link'] ?>" title="<?php echo $video['video_title']; ?>">
                                <img src="<?php echo ClaHost::getImageHost() . $video['avatar_path'] . 's150_150/' . $video['avatar_name']; ?>" alt="<?php echo $video['video_title']; ?>">
                            </a>
                        </div>
                        <div class="list-content-body">
                            <span class="list-content-title">
                                <a href="<?php echo $video['link'] ?>" title="<?php echo $video['video_title']; ?>">
                                    <?php echo $video['video_title']; ?>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
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