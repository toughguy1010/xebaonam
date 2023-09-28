<li class="ui-state-default">
    <div class="alimgitem">
        <div class="alimgitembox">
            <div class="delimg">
                <a href="<?php echo Yii::app()->createUrl('/car/car/delacces', array('iid' => $acs['id'])); ?>" class="delimgaction"><i class="icon-remove"></i></a>
            </div>
            <div class="alimgthum">
                <img src="<?php echo CarAccessories::getAbsoluteLink($acs); ?>" />
            </div>
            <div class="">
                <input class="position_image" type="hidden" />
                <input class="" type="hidden" name="acces_key[]" value="<?= $acs['id'] ?>" />
                <input placeholder="Tên linh kiện" type="text" name="CarAccessories[<?= $acs['id'] ?>][name]" value="<?= $acs['name'] ?>" />
                <input placeholder="Loại" type="hidden" name="CarAccessories[<?= $acs['id'] ?>][type]" value="<?= $type ?>" />
                <input placeholder="Giá" type="text" name="CarAccessories[<?= $acs['id'] ?>][price]" value="<?= $acs['price'] ?>" />
                <textarea placeholder="Mô tả" name="CarAccessories[<?= $acs['id'] ?>][description]"><?= $acs['description'] ?></textarea>
            </div>
        </div>
    </div>
</li>