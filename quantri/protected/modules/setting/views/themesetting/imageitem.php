<div class="alimgitem <?php echo ($image['img_id']==$avatar_id)?'active':'' ?>">
    <div class="alimgitembox">
        <div class="delimg">
            <a href="<?php echo Yii::app()->createUrl('/setting/themesetting/delimage',array('iid'=>$image['img_id'])); ?>" class="delimgaction"><i class="icon-remove"></i></a>
        </div>
        <div class="alimgthum">
            <img src="<?php echo Images::getAbsoluteLink($image); ?>" />
        </div>
        <div class="alimgaction">
            <input type="radio" name="setava" value="<?php echo $image['img_id'] ?>" <?php echo ($image['img_id']==$avatar_id)?'checked="checked"':'' ?>><span><?php echo Yii::t('album', 'album_set_avatar'); ?></span>
        </div>
    </div>
</div>