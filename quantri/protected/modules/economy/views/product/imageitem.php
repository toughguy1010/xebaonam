<li class="ui-state-default" style="float: left;">
    <div class="alimgitem <?php echo ($image['img_id'] == $avatar_id) ? 'active' : '' ?>">
        <div class="alimgitembox">
            <div class="delimg">
                <a href="<?php echo Yii::app()->createUrl('/economy/product/delimage', array('iid' => $image['img_id'])); ?>"
                   class="delimgaction"><i class="icon-remove"></i>
                </a>
                <a href="<?php echo Yii::app()->createUrl('/economy/imagetag/loadtag', array('iid' => $image['img_id'])) ?>" class="show-tag-action" onclick="return imageTag.showTag(this);">
                    <i class="icon-tag"></i>
                </a>
                <a href="<?php echo Yii::app()->createUrl('/economy/imagetag/embed', array('iid' => $image['img_id'])) ?>" class="embed-action" onclick="return imageTag.embed(this);">
                    <i class="icon-link"></i>
                </a>
            </div>
            <div class="alimgthum">
                <div class="imgBox">
                    <img src="<?php echo Images::getAbsoluteLink($image); ?>"/>
                </div>
                <?php
                echo CHtml::hiddenField('imageTag['.$image['img_id'].']', '', array('class' => 'imgTagData'));
                ?>
            </div>
            <div class="alimgaction">
                <input class="position_image" type="hidden" name="order_img[<?php echo $group_img ?>][]"
                       value="<?php echo $image['img_id'] ?>"/>
                <input type="radio" name="setava"
                       value="<?php echo $image['img_id'] ?>" <?php echo ($image['img_id'] == $avatar_id) ? 'checked="checked"' : '' ?>><span><?php echo Yii::t('album', 'album_set_avatar'); ?></span>
            </div>
        </div>
    </div>
</li>