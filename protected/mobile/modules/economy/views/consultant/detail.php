<div class="lecturer_detail">
    <div class="info_lecturer clearfix">
        <?php if ($consultant['avatar_path'] != '' && $consultant['avatar_name'] != '') { ?>
            <div class="avatar">
                <img src="<?php echo ClaHost::getImageHost() . $consultant['avatar_path'] . 's300_300/' . $consultant['avatar_name'] ?>" />
            </div>    
        <?php } ?>
        <div class="detail_info">
            <h1 class="name"><?php echo $consultant['name'] ?></h1>
            <?php if ($consultant->bod) { ?>
                <div><label><?php echo Yii::t('user', 'birthday') ?>:</label> <span><?php echo date('d-m-Y', $consultant->bod) ?></span></div>
            <?php } ?>
            <?php if ($consultant->job_title) { ?>
                <div><label><?php echo Yii::t('common', 'job_title') ?>:</label> <span><?php echo $consultant->job_title ?></span></div>
            <?php } ?>
            <?php if ($consultant->company) { ?>
                <div><label><?php echo Yii::t('common', 'company') ?>:</label> <span><?php echo $consultant->company ?></span></div>
            <?php } ?>
            <?php if ($consultant->subject) { ?>
                <div><label><?php echo Yii::t('course', 'subject_lecturer') ?>:</label> <span><?php echo $consultant->subject ?></span></div>
            <?php } ?>
            <?php if ($consultant->experience) { ?>
                <div><label><?php echo Yii::t('common', 'experience') ?>:</label> <span><?php echo $consultant->experience . ' ' . Yii::t('common', 'year') ?></span></div>
            <?php } ?>
            <?php if ($consultant->add) { ?>
                <div><label><?php echo Yii::t('common', 'address') ?>:</label> <span><?php echo $consultant->add ?></span></div>
            <?php } ?>
        </div>
    </div>
    <div class="description">
        <?php echo $consultant['description'] ?>
    </div>
</div>