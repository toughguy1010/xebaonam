<li class="ui-state-default">
    <div class="alimgitem <?php echo ($image['img_id'] == $avatar_id) ? 'active' : '' ?>">
        <div class="alimgitembox">
            <div class="delimg">
                <a href="<?php echo Yii::app()->createUrl('/car/car/delimage', array('iid' => $image['img_id'])); ?>" class="delimgaction"><i class="icon-remove"></i></a>
            </div>
            <div class="alimgthum">
                <img src="<?php echo Images::getAbsoluteLink($image); ?>" />
            </div>
            <div class="">
                <input class="position_image" type="hidden" name="order_img[]" value="<?php echo $image['img_id'] ?>" />
                <input type="radio" name="setava" value="<?php echo $image['img_id'] ?>" <?php echo ($image['img_id'] == $avatar_id) ? 'checked="checked"' : '' ?>><span><?php echo Yii::t('album', 'album_set_avatar'); ?></span>
                <input placeholder="Tiêu đề" type="text" name="setinfo[<?= $image['img_id'] ?>][title]" value="<?= $image['title'] ?>" />
                <textarea placeholder="Mô tả" name="setinfo[<?= $image['img_id'] ?>][description]"><?= $image['description'] ?></textarea>
            </div>
        </div>
    </div>
</li>