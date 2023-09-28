<li class="ui-state-default">
    <div class="alimgitem">
        <div class="alimgitembox">
            <div class="delimg">
                <a href="<?php echo Yii::app()->createUrl('/bds/bdsProjectConfig/delimage', array('iid' => $image['img_id'])); ?>"
                   class="delimgaction"><i class="icon-remove"></i></a>
            </div>
            <div class="alimgthum" style="height: 150px;">
                <img src="<?php echo Images::getAbsoluteLink($image); ?>" style="max-height: 100%"/>
            </div>
            <div class="alimgaction">
                <input class="position_image" type="hidden" name="order_img[<?php echo $image['type'] ?>][]"
                       value="<?php echo $image['img_id'] ?>"/>
            </div>
            <div class="imgAlt">
                <input class="controls" name="ImageAlt[<?php echo $image['img_id'] ?>]" type="text" maxlength="250" value="<?php echo $image['title']; ?>" placeHolder="<?php echo Yii::t('common', 'title') ?>">
            </div>
        </div>
    </div>
</li>