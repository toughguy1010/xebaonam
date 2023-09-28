<div class="cateinhome">
    <?php foreach ($cateinhome as $cat) { ?>
        <div class="box-main-one">
            <div class="main-list">
                <h3><?php echo $widget_title; ?></h3>
                <a href="<?php echo $cat['link']; ?>"><?php echo Yii::t('common', 'viewall'); ?></a>
            </div><!--end-main-list-->
            <?php if (isset($data[$cat['cat_id']]['videos'])) { ?>
                <div class="list grid clearfix">
                    <?php foreach ($data[$cat['cat_id']]['videos'] as $video) { ?>
                    <?php

                    } ?>
                </div><!--end-list-gird-->
            <?php } ?>
        </div>
    <?php } ?>
</div>