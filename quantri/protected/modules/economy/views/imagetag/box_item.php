<div class="imageTagBox" style="position: absolute; left:_vari_real_left_px; top:_vari_real_top_px;" data-left="_vari_left_" data-top="_vari_top_" data-update="update" data-tag="<?php echo $tag['id']; ?>">
    <div class="imageTagAction">
        <a href="<?php echo Yii::app()->createUrl('/economy/imagetag/delete',array('tag'=>$tag['id'])); ?>" onclick="return imageTag.removeItem(this);" class="act-delete"><i class="icon-remove"></i></a>
    </div>
    <div class="imageTagAction edit">
        <a href="<?php echo Yii::app()->createUrl('/economy/imagetag/getbox',array('tag'=>$tag['id'])); ?>" onclick="return imageTag.editItem(this);" class="act-delete"><i class="icon-edit"></i></a>
    </div>
    <a href="javascript:void(0);" class="imgTag"><i class="icon-tag"></i></a>
    <div class="imageTagProduct hidden">
        <span class="iconConect"><i class="icon-caret-left"></i></span>
        <a href="#" class="iconHide" onclick="jQuery(this).parent().addClass('hidden'); return false;"><i class="icon-remove"></i></a>
        <div class="itpBody"></div>
    </div>
</div>