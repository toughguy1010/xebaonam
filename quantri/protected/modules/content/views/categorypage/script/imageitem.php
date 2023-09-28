<div class="item alimgitem <?php echo ($image['img_id'] == $avatar_id) ? 'active' : '' ?>">
    <div class="alimgitembox">
        <div class="delimg">
            <a href="<?php echo Yii::app()->createUrl('/content/categorypage/delimage', array('iid' => $image['img_id'])); ?>" class="delimgaction"><i class="icon-remove"></i></a>
        </div>
        <div class="alimgthum">
            <img src="<?php echo Images::getAbsoluteLink($image); ?>" />
        </div>
        <div class="alimgaction" style="text-align: left;">
            <input class="position_image" type="hidden" name="order_img[]" value="<?php echo $image['img_id'] ?>" />
            <input type="radio" name="setava" value="<?php echo $image['img_id'] ?>" <?php echo ($image['img_id'] == $avatar_id) ? 'checked="checked"' : '' ?>><span><?php echo Yii::t('album', 'album_set_avatar'); ?></span>
            <br />
        </div>
        <div class="imgAlt">
            <input class="controls" name="ImageAlt[<?php echo $image['img_id'] ?>]" type="text" maxlength="250" value="<?php echo $image['title']; ?>" placeHolder="<?php echo Yii::t('common', 'title') ?>">
        </div>
    </div>
</div>