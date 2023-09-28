<div class="page-range">
    <?php if ($show_widget_title) { ?>
        <div class="page-range">
            <h3><?php echo $widget_title; ?></h3>
        </div>
    <?php } ?>
    <ul class="list-group">
        <?php foreach ($range as $ra) { ?>
            <li class="list-group-item">
                <a href="<?php echo $ra['link']; ?>" title="<?php echo $ra['priceText']; ?>">
                    <?php echo $ra['priceText']; ?>
                </a>
            </li>
        <?php } ?>
            <li class="list-group-item">
                <a href="<?php echo $linkAll; ?>">
                    <?php echo Yii::t('common','all'); ?>
                </a>
            </li>
    </ul>
</div>