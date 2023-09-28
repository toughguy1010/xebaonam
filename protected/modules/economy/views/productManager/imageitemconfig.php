<div class="alimgitem">
    <div class="alimgitembox">
        <div class="delimg">
            <a href="<?php echo Yii::app()->createUrl('/economy/product/delimageConfig',array('iid'=>$image['img_id'])); ?>" class="delimgaction"><i class="icon-remove"></i></a>
        </div>
        <div class="alimgthum">
            <img src="<?php echo Images::getAbsoluteLinkThumbs($image, 's200_200'); ?>" />
        </div>
    </div>
</div>