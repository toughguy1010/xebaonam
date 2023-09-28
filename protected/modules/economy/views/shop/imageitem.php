<li class="ui-state-default">
    <div class="alimgitem <?php echo ($image['img_id'] == $avatar_id) ? 'active' : '' ?>">
        <div class="alimgitembox" style="height: 180px;">
            <div class="delimg">
                <a href="<?php echo Yii::app()->createUrl('/economy/shop/delimage', array('iid' => $image['img_id'])); ?>" class="delimgaction"><i class="icon-remove"></i></a>
            </div>
            <div class="alimgthum">
                <img src="<?php echo Images::getAbsoluteLink($image); ?>" />
            </div>
        </div>
    </div>
</li>