<div class="alimgitem">
    <div class="alimgitembox">
        <div class="delimg">
            <a href="<?php echo Yii::app()->createUrl('/banner/banner/delimage',array('iid'=>$image['id'])); ?>" class="delimgaction"><i class="icon-remove"></i></a>
        </div>
        <div class="alimgthum">
            <img src="<?php echo Images::getAbsoluteLink($image); ?>" />
        </div>
        <div class="alimgaction" style="margin-top: 20px;">
            <label>Vị trí: </label>
            <input style="width: 50px;margin-left: 10px;" type="text" name="banner_partial[<?php echo $image['id'] ?>]" value="<?php echo $image['position'] ?>" />
        </div>
    </div>
</div>