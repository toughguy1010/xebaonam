<?php if (count($shops)) { ?>
    <div class="row">
        <div class="wrap_all_shop">
            <?php foreach ($shops as $shop) { ?>
                <div class="item-shop col-xs-4">
                    <div class="avatar-shop">
                        <a href="<?php echo $shop['link'] ?>">
                            <img src="<?php echo ClaHost::getImageHost() . $shop['image_path'] . 's200_200/' . $shop['image_name']; ?>" />
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class='product-page'>
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
<?php } ?>
