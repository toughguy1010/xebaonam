<li class="ui-state-default">
    <div class="alimgitem">
        <div class="alimgitembox">
            <div class="delimg">
                <a href="<?php echo Yii::app()->createUrl('/economy/product/delimagecolor', array('iid' => $img_color['img_id'])); ?>"
                   class="delimgaction_color"><i class="icon-remove"></i></a>
            </div>
            <div class="alimgthum">
                <img src="<?php echo Images::getAbsoluteLink($img_color); ?>"/>
            </div>
            <div class="alimgaction">
                <input class="position_image" type="hidden" name="order_img[][]" value="<?php echo $img_color['img_id'] ?>"/>
                <input type="radio" name="setavacolor[<?php echo $color_code ?>]" value="<?php echo $img_color['img_id'] ?>" <?php echo $img_color['is_avatar'] ? 'checked="checked"' : '' ?> ><span><?php echo Yii::t('album', 'album_set_avatar'); ?></span>
            </div>
        </div>
    </div>
</li>