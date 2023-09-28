<div class="theme-item">
    <div class="theme-box">
        <div class="theme-image">
            <img src="<?php echo ClaHost::getImageHost() . $theme['avatar_path'] . 's500_500/' . $theme['avatar_name']; ?>" alt="<?php echo $theme['theme_name']; ?>" />
        </div>
        <?php if ($theme['status'] == Themes::STATUS_AVAILABLE) { ?>
            <a class="btn btn-primary theme-action" href="<?php echo Yii::app()->createUrl('/site/build/install', array('theme' => $theme['theme_id'])) ?>">
                <?php echo Yii::t('theme', 'choicetheme'); ?>
            </a>
        <?php } ?>
        <?php if ($theme['status'] == Themes::STATUS_DEMO) { ?>
            <a href="<?php echo Yii::app()->createUrl('site/build/order', array('theme' => $theme['theme_id'])); ?>" class="btn btn-info theme-action">
                <?php echo Yii::t('request', 'request_design'); ?>
            </a>
        <?php } ?>
        <div class="theme-info">
            <div class="theme-info-box">
                <h3 class="theme-info-title"><?php echo $theme['theme_name']; ?></h3>
                <div class="theme-info-view">
                    <?php if ($theme['status'] == Themes::STATUS_AVAILABLE && $theme['previewlink']) { ?>
                        <a href="<?php echo $theme['previewlink']; ?>" class="btn btn-sm btn-success" target="_blank">
                            <?php echo Yii::t('common', 'preview'); ?>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="theme-cover"></div>
        <i class="theme-icon <?php echo ($theme['status'] == Themes::STATUS_DEMO) ? 'theme-waiting' : ''; ?>"></i>
    </div>
</div>