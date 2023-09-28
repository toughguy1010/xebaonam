<div class="menu-lever2 trademark">
    <div class="panel panel-default manufacturers">
        <div class="panel-heading">
            <h2><?php echo Yii::t('product', 'manufacturer'); ?></h2>
        </div>
        <div class="panel-body">
            <?php foreach ($manufacturers_options as $option) { ?>
                <a title="<?php echo $option['option']['name'] ?>" class="<?php echo $option['checked'] ? 'checked-manufacturer' : '' ?> item-manufacturer" href="<?php echo $option['link'] ?>">
                    <img alt="<?php echo $option['option']['name'] ?>" src="<?php echo ClaHost::getImageHost() . $option['option']['image_path'] . $option['option']['image_name'] ?>" />
                </a>
            <?php } ?>
        </div>
    </div>
</div>
