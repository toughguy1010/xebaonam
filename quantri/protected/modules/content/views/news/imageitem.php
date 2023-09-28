<li class="ui-state-default">
    <div class="alimgitem <?php echo ($image['img_id'] == $cover_id) ? 'active' : '' ?>">
        <div class="alimgitembox">
            <div class="delimg">
                <a href="<?php echo Yii::app()->createUrl('/content/news/delimagenews', array('iid' => $image['img_id'])); ?>" class="delimgaction"><i class="icon-remove"></i></a>
            </div>
            <div class="alimgthum">
                <img src="<?php echo Images::getAbsoluteLink($image); ?>" />
            </div>
            <div class="alimgaction">
                <input class="position_image" type="hidden" name="order_img[]" value="<?php echo $image['img_id'] ?>" />
                <input type="radio" name="setava" value="<?php echo $image['img_id'] ?>" <?php echo ($image['img_id'] == $cover_id) ? 'checked="checked"' : '' ?>><span><?php echo Yii::t('album', 'album_set_cover'); ?></span>
            </div>
        </div>
    </div>
</li>