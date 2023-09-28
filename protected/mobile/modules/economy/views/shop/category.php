<?php if (count($shops)) { ?>
    <?php foreach ($shops as $shop) { ?>
        <div class="col-sm-3">
            <div class="box-stand">
                <div class="box-stand-img">
                    <a href="<?php echo $shop['link'] ?>" title="<?php echo $shop['description'] ?>">
                        <img src="<?php echo ClaHost::getImageHost(), $shop['image_path'], 's300_300/', $shop['image_name']; ?>" />
                    </a>
                </div>
                <div class="box-stand-info">
                    <div class="name-stand">
                        <h3><a href="<?php echo $shop['link'] ?>"><?php echo $shop['name']; ?></a></h3>
                    </div>
                    <div class="name-address">
                        <?php echo $shop['address'], ', ', $shop['ward_name'], ', ', $shop['district_name'], ', ', $shop['province_name'] ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
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
<?php } ?>
