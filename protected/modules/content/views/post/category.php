<div class="posts">
    <div class="list">
        <?php if (count($posts)) { ?>
            <?php
            foreach ($posts as $post) {
                ?>
                <div class="list-item">
                    <div class="list-content">
                        <div class="list-content-box">
                            <?php
                            $hasImage = ($post['image_path'] && $post['image_name']) ? true : false;
                            if ($hasImage) {
                                ?>
                                <div class="list-content-img">
                                    <a href="<?php echo $post['link']; ?>">
                                        <img src="<?php echo ClaHost::getImageHost() . $post['image_path'] . 's200_200/' . $post['image_name']; ?>">
                                    </a>
                                </div>
                            <?php } ?>
                            <div class="list-content-body <?php if (!$hasImage) echo 'no-margin-left'; ?>">
                                <span class="list-content-title">
                                    <a href="<?php echo $post['link']; ?>">
                                        <?php echo $post['title']; ?>
                                    </a>
                                </span>
                                <div class="list-content-detail">
                                    <p>
                                        <?php
                                        echo $post['sortdesc'];
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