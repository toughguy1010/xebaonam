<div class="lecturer_detail">
    <div class="info_lecturer clearfix">
        <?php if ($lecturer['avatar_path'] != '' && $lecturer['avatar_name'] != '') { ?>
            <div class="avatar">
                <img src="<?php echo ClaHost::getImageHost() . $lecturer['avatar_path'] . 's300_300/' . $lecturer['avatar_name'] ?>" />
            </div>    
        <?php } ?>
        <div class="detail_info">
            <h1 class="name"><?php echo $lecturer['name'] ?></h1>
            <?php if ($lecturer->bod) { ?>
                <div><label><?php echo Yii::t('user', 'birthday') ?>:</label> <span><?php echo date('d-m-Y', $lecturer->bod) ?></span></div>
            <?php } ?>
            <?php if ($lecturer->job_title) { ?>
                <div><label><?php echo Yii::t('common', 'job_title') ?>:</label> <span><?php echo $lecturer->job_title ?></span></div>
            <?php } ?>
            <?php if ($lecturer->company) { ?>
                <div><label><?php echo Yii::t('common', 'company') ?>:</label> <span><?php echo $lecturer->company ?></span></div>
            <?php } ?>
            <?php if ($lecturer->subject) { ?>
                <div><label><?php echo Yii::t('course', 'subject_lecturer') ?>:</label> <span><?php echo $lecturer->subject ?></span></div>
            <?php } ?>
            <?php if ($lecturer->experience) { ?>
                <div><label><?php echo Yii::t('common', 'experience') ?>:</label> <span><?php echo $lecturer->experience . ' ' . Yii::t('common', 'year') ?></span></div>
            <?php } ?>
            <?php if ($lecturer->add) { ?>
                <div><label><?php echo Yii::t('common', 'address') ?>:</label> <span><?php echo $lecturer->add ?></span></div>
            <?php } ?>
        </div>
    </div>
    <div class="description">
        <?php echo $lecturer['description'] ?>
    </div>
</div>