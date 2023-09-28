<li class="ui-state-default">
    <div class="alimgitem <?php echo ($image['img_id'] == $avatar_id) ? 'active' : '' ?>">
        <div class="alimgitembox">
            <div class="delimg">
                <a href="<?php echo Yii::app()->createUrl('/economy/product/delimagehight', array('iid' => $image['img_id'])); ?>" class="delimgaction"><i class="icon-remove"></i></a>
            </div>
            <div class="alimgthum">
                <img src="<?php echo Images::getAbsoluteLink($image); ?>" />
            </div>
            <div class="">


                <input placeholder="Tiêu đề" type="text" name="setinfo[<?= $image['img_id'] ?>][title]" value="<?= $image['title'] ?>" />
                <p>
                    <input name="us-ck" type="checkbox" class="product_detail_hightligh" class_t="<?=$image['img_id']?>" value="" style="">
                    <span>Sử dụng trình soạn thảo</span></p>
                <textarea  id="att_r<?=$image['img_id']?>" placeholder="Mô tả" name="setinfo[<?= $image['img_id'] ?>][description]"><?= $image['description'] ?></textarea>
            </div>
        </div>
    </div>
</li>
