<li class="ui-state-default" style="float: left;">
    <div class="alimgitem">
        <div class="alimgitembox">
            <div class="delimg">
                <a href="<?php echo Yii::app()->createUrl('/economy/brand/delimage', array('iid' => $image['img_id'])); ?>"
                   class="delimgaction"><i class="icon-remove"></i></a>
            </div>
            <div class="alimgthum">
                <img src="<?php echo Images::getAbsoluteLink($image); ?>"/>
            </div>
            <div class="alimgaction">
                <input class="position_image" type="hidden" name="order_img[]"
                       value="<?php echo $image['img_id'] ?>"/>
            </div>
        </div>
    </div>
</li>