<div class="introducebox">
    <?php if ($data['title']) { ?>
        <h3 class="introducetitle">
            <?php $data['title']; ?>
        </h3>
    <?php } ?>
    <div class="introduceinfo">
        <?php $hasImage = ($data['image_path'] && $data['image_name']) ? true : false; ?>
        <?php if ($hasImage) { ?>
            <div class="introduceimage">
                <img src="<?php echo ClaHost::getImageHost() . $data['image_path'] . 's300_300/' . $data['image_name']; ?>">
            </div>
        <?php } ?>
        <div class="introducecontent <?php if (!$hasImage) echo 'no-margin-left'; ?>">
            <?php echo $data['sortdesc']; ?>
            <a class="viewmore" href="<?php echo Yii::app()->createUrl('/site/site/introduce'); ?>">
                <?php echo Yii::t('common', 'viewmore'); ?>
            </a>
        </div>
    </div>
</div>