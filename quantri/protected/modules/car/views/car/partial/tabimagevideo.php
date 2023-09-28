<style>
    #sortable, 
    #sortable_interior, 
    #sortable_exterior, 
    #sortable_safety, 
    #sortable_operate { 
        list-style-type: none; margin: 0; padding: 0; width: 100%;
    }
    #sortable li, 
    #sortable_interior li, 
    #sortable_exterior li, 
    #sortable_safety li, 
    #sortable_operate li{ 
        margin: 3px 3px 3px 0; padding: 1px; float: left; width: 250px; height: 410px; text-align: center; 
    }
    #algalley .alimgbox .alimglist .alimgitem, 
    #algalley_interior .alimgbox .alimglist .alimgitem, 
    #algalley_exterior .alimgbox .alimglist .alimgitem, 
    #algalley_safety .alimgbox .alimglist .alimgitem, 
    #algalley_operate .alimgbox .alimglist .alimgitem{
        width: 100%;
    }
    #algalley .alimgbox .alimglist .alimgitem .alimgitembox, 
    #algalley_interior .alimgbox .alimglist .alimgitem .alimgitembox, 
    #algalley_exterior .alimgbox .alimglist .alimgitem .alimgitembox, 
    #algalley_safety .alimgbox .alimglist .alimgitem .alimgitembox, 
    #algalley_operate .alimgbox .alimglist .alimgitem .alimgitembox{
        height: 400px;
        position: relative;
    }
    #algalley .alimgbox .alimglist .alimgitem .alimgaction, 
    #algalley_interior .alimgbox .alimglist .alimgitem .alimgaction, 
    #algalley_exterior .alimgbox .alimglist .alimgitem .alimgaction, 
    #algalley_safety .alimgbox .alimglist .alimgitem .alimgaction, 
    #algalley_operate .alimgbox .alimglist .alimgitem .alimgaction{
        position: absolute;
        bottom: 0px;
    }
    .alimgbox .alimglist .alimgitem img{
        height: 200px;
        margin-bottom: 20px;
        border-bottom: 1px solid #ddd !important;
    }
</style>

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'video_link', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'video_link', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'video_link'); ?>
    </div>
</div>

<?php
if (!$model->isNewRecord) {
    $images = $model->getImages();
    $count_images = count($images);
}
?>
<div class="form-group no-margin-left">
    <?php echo CHtml::label(Yii::t('car', 'car_image'), null, array('class' => 'col-sm-2 control-label')); ?>
    <div class="controls col-sm-10">

        <?php
        $this->widget('common.widgets.upload.Upload', array(
            'type' => 'images',
            'id' => 'imageupload',
            'buttonheight' => 25,
            'path' => array('cars', $this->site_id, Yii::app()->user->id),
            'limit' => 100,
            'multi' => true,
            'imageoptions' => array(
                'resizes' => array(array(200, 200))
            ),
            'buttontext' => 'Thêm ảnh',
            'displayvaluebox' => false,
            'oncecomplete' => "var firstitem   = jQuery('#algalley .alimglist').find('.ui-state-default:first');var alimgitem   = '<li class=\"ui-state-default\"><div class=\"alimgitem\"><div class=\"alimgitembox\"> <div class=\"delimg\"><a href=\"#\" class=\"new_delimgaction\"><i class=\"icon-remove\"></i></a></div><div class=\"alimgthum\"><img src=\"'+da.imgurl+'\"></div><div ><input class=\"position_image\" type=\"hidden\" name=\"order_img[]\" value=\"newimage\" /><input type=\"radio\" value=\"new_'+da.imgid+'\" name=\"setava\"><span>" . Yii::t('album', 'album_set_avatar') . "</span><input placeholder=\"Tiêu đề\" type=\"text\" name=\"setinfonew['+da.imgid+'][title]\" /><textarea placeholder=\"Mô tả\" name=\"setinfonew['+da.imgid+'][description]\"></textarea></div><input type=\"hidden\" value=\"'+da.imgid+'\" name=\"newimage[1][]\" class=\"newimage\" /></div></div></li>';if(firstitem.html()){firstitem.before(alimgitem);}else{jQuery('#algalley #sortable').append(alimgitem);}; updateImgBox();",
            'onUploadStart' => 'ta=false;',
            'queuecomplete' => 'ta=true;',
        ));
        ?>

        <div id="algalley" class="algalley">
            <span style="font-size: 12px;color: blue"><i>* Kéo thả để thay đổi vị trí</i></span>
            <div style="display:none" id="Albums_imageitem_em_" class="errorMessage"><?php echo Yii::t('album', 'album_must_one_img'); ?></div>
            <div class="alimgbox">
                <div class="alimglist">
                    <ul id="sortable">
                        <?php
                        if ($count_images) {
                            foreach ($images as $key => $image) {
                                if ($image['type'] == 1) { // 1 là kiểu ảnh tổng quan
                                    $this->renderPartial('imageitem', array('image' => $image, 'avatar_id' => $model->avatar_id));
                                    unset($images[$key]);
                                }
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $("#sortable").sortable({
            stop: function (event, ui) {
                var img_id = $(ui.item).find('.position_image').val();
                if (img_id == 'newimage') {
                    $(ui.item).find('.newimage').attr('name', 'newimage[' + ui.item.index() + ']')
                }
            }
        });
        $("#sortable").disableSelection();
    });
</script>
<hr>
<div class="form-group no-margin-left">
    <?php echo CHtml::label(Yii::t('car', 'car_image_interior'), null, array('class' => 'col-sm-2 control-label')); ?>
    <div class="controls col-sm-10">

        <?php
        $this->widget('common.widgets.upload.Upload', array(
            'type' => 'images',
            'id' => 'imageupload_interior',
            'buttonheight' => 25,
            'path' => array('cars', $this->site_id, Yii::app()->user->id),
            'limit' => 100,
            'multi' => true,
            'imageoptions' => array(
                'resizes' => array(array(200, 200))
            ),
            'buttontext' => 'Thêm ảnh',
            'displayvaluebox' => false,
            'oncecomplete' => "var firstitem   = jQuery('#algalley_interior .alimglist').find('.ui-state-default:first');var alimgitem   = '<li class=\"ui-state-default\"><div class=\"alimgitem\"><div class=\"alimgitembox\"> <div class=\"delimg\"><a href=\"#\" class=\"new_delimgaction\"><i class=\"icon-remove\"></i></a></div><div class=\"alimgthum\"><img src=\"'+da.imgurl+'\"></div><div ><input class=\"position_image\" type=\"hidden\" name=\"order_img[]\" value=\"newimage\" /><input type=\"radio\" value=\"new_'+da.imgid+'\" name=\"setava\"><span>" . Yii::t('album', 'album_set_avatar') . "</span><input placeholder=\"Tiêu đề\" type=\"text\" name=\"setinfonew['+da.imgid+'][title]\" /><textarea placeholder=\"Mô tả\" name=\"setinfonew['+da.imgid+'][description]\"></textarea></div><input type=\"hidden\" value=\"'+da.imgid+'\" name=\"newimage[2][]\" class=\"newimage\" /></div></div></li>';if(firstitem.html()){firstitem.before(alimgitem);}else{jQuery('#algalley_interior #sortable_interior').append(alimgitem);}; updateImgBox();",
            'onUploadStart' => 'ta=false;',
            'queuecomplete' => 'ta=true;',
        ));
        ?>

        <div id="algalley_interior" class="algalley">
            <span style="font-size: 12px;color: blue"><i>* Kéo thả để thay đổi vị trí</i></span>
            <div style="display:none" id="Albums_imageitem_em_" class="errorMessage"><?php echo Yii::t('album', 'album_must_one_img'); ?></div>
            <div class="alimgbox">
                <div class="alimglist">
                    <ul id="sortable_interior">
                        <?php
                        if ($count_images) {
                            foreach ($images as $key => $image) {
                                if ($image['type'] == 2) { // 1 là kiểu ảnh nội thất
                                    $this->renderPartial('imageitem', array('image' => $image, 'avatar_id' => $model->avatar_id));
                                    unset($images[$key]);
                                }
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $("#sortable_interior").sortable({
            stop: function (event, ui) {
                var img_id = $(ui.item).find('.position_image').val();
                if (img_id == 'newimage') {
                    $(ui.item).find('.newimage').attr('name', 'newimage[' + ui.item.index() + ']')
                }
            }
        });
        $("#sortable_interior").disableSelection();
    });
</script>
<hr>
<div class="form-group no-margin-left">
    <?php echo CHtml::label(Yii::t('car', 'car_image_exterior'), null, array('class' => 'col-sm-2 control-label')); ?>
    <div class="controls col-sm-10">

        <?php
        $this->widget('common.widgets.upload.Upload', array(
            'type' => 'images',
            'id' => 'imageupload_exterior',
            'buttonheight' => 25,
            'path' => array('cars', $this->site_id, Yii::app()->user->id),
            'limit' => 100,
            'multi' => true,
            'imageoptions' => array(
                'resizes' => array(array(200, 200))
            ),
            'buttontext' => 'Thêm ảnh',
            'displayvaluebox' => false,
            'oncecomplete' => "var firstitem   = jQuery('#algalley_exterior .alimglist').find('.ui-state-default:first');var alimgitem   = '<li class=\"ui-state-default\"><div class=\"alimgitem\"><div class=\"alimgitembox\"> <div class=\"delimg\"><a href=\"#\" class=\"new_delimgaction\"><i class=\"icon-remove\"></i></a></div><div class=\"alimgthum\"><img src=\"'+da.imgurl+'\"></div><div ><input class=\"position_image\" type=\"hidden\" name=\"order_img[]\" value=\"newimage\" /><input type=\"radio\" value=\"new_'+da.imgid+'\" name=\"setava\"><span>" . Yii::t('album', 'album_set_avatar') . "</span><input placeholder=\"Tiêu đề\" type=\"text\" name=\"setinfonew['+da.imgid+'][title]\" /><textarea placeholder=\"Mô tả\" name=\"setinfonew['+da.imgid+'][description]\"></textarea></div><input type=\"hidden\" value=\"'+da.imgid+'\" name=\"newimage[3][]\" class=\"newimage\" /></div></div></li>';if(firstitem.html()){firstitem.before(alimgitem);}else{jQuery('#algalley_exterior #sortable_exterior').append(alimgitem);}; updateImgBox();",
            'onUploadStart' => 'ta=false;',
            'queuecomplete' => 'ta=true;',
        ));
        ?>

        <div id="algalley_exterior" class="algalley">
            <span style="font-size: 12px;color: blue"><i>* Kéo thả để thay đổi vị trí</i></span>
            <div style="display:none" id="Albums_imageitem_em_" class="errorMessage"><?php echo Yii::t('album', 'album_must_one_img'); ?></div>
            <div class="alimgbox">
                <div class="alimglist">
                    <ul id="sortable_exterior">
                        <?php
                        if ($count_images) {
                            foreach ($images as $key => $image) {
                                if ($image['type'] == 3) { // 3 là kiểu ảnh ngoại thất
                                    $this->renderPartial('imageitem', array('image' => $image, 'avatar_id' => $model->avatar_id));
                                    unset($images[$key]);
                                }
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $("#sortable_exterior").sortable({
            stop: function (event, ui) {
                var img_id = $(ui.item).find('.position_image').val();
                if (img_id == 'newimage') {
                    $(ui.item).find('.newimage').attr('name', 'newimage[' + ui.item.index() + ']')
                }
            }
        });
        $("#sortable_exterior").disableSelection();
    });
</script>
<hr>
<div class="form-group no-margin-left">
    <?php echo CHtml::label(Yii::t('car', 'car_image_safety'), null, array('class' => 'col-sm-2 control-label')); ?>
    <div class="controls col-sm-10">

        <?php
        $this->widget('common.widgets.upload.Upload', array(
            'type' => 'images',
            'id' => 'imageupload_safety',
            'buttonheight' => 25,
            'path' => array('cars', $this->site_id, Yii::app()->user->id),
            'limit' => 100,
            'multi' => true,
            'imageoptions' => array(
                'resizes' => array(array(200, 200))
            ),
            'buttontext' => 'Thêm ảnh',
            'displayvaluebox' => false,
            'oncecomplete' => "var firstitem   = jQuery('#algalley_safety .alimglist').find('.ui-state-default:first');var alimgitem   = '<li class=\"ui-state-default\"><div class=\"alimgitem\"><div class=\"alimgitembox\"> <div class=\"delimg\"><a href=\"#\" class=\"new_delimgaction\"><i class=\"icon-remove\"></i></a></div><div class=\"alimgthum\"><img src=\"'+da.imgurl+'\"></div><div ><input class=\"position_image\" type=\"hidden\" name=\"order_img[]\" value=\"newimage\" /><input type=\"radio\" value=\"new_'+da.imgid+'\" name=\"setava\"><span>" . Yii::t('album', 'album_set_avatar') . "</span><input placeholder=\"Tiêu đề\" type=\"text\" name=\"setinfonew['+da.imgid+'][title]\" /><textarea placeholder=\"Mô tả\" name=\"setinfonew['+da.imgid+'][description]\"></textarea></div><input type=\"hidden\" value=\"'+da.imgid+'\" name=\"newimage[4][]\" class=\"newimage\" /></div></div></li>';if(firstitem.html()){firstitem.before(alimgitem);}else{jQuery('#algalley_safety #sortable_safety').append(alimgitem);}; updateImgBox();",
            'onUploadStart' => 'ta=false;',
            'queuecomplete' => 'ta=true;',
        ));
        ?>

        <div id="algalley_safety" class="algalley">
            <span style="font-size: 12px;color: blue"><i>* Kéo thả để thay đổi vị trí</i></span>
            <div style="display:none" id="Albums_imageitem_em_" class="errorMessage"><?php echo Yii::t('album', 'album_must_one_img'); ?></div>
            <div class="alimgbox">
                <div class="alimglist">
                    <ul id="sortable_safety">
                        <?php
                        if ($count_images) {
                            foreach ($images as $key => $image) {
                                if ($image['type'] == 4) { // 4 là kiểu ảnh an toàn & vận hành
                                    $this->renderPartial('imageitem', array('image' => $image, 'avatar_id' => $model->avatar_id));
                                    unset($images[$key]);
                                }
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $("#sortable_safety").sortable({
            stop: function (event, ui) {
                var img_id = $(ui.item).find('.position_image').val();
                if (img_id == 'newimage') {
                    $(ui.item).find('.newimage').attr('name', 'newimage[' + ui.item.index() + ']')
                }
            }
        });
        $("#sortable_safety").disableSelection();
    });
</script>
<hr>
<div class="form-group no-margin-left">
    <?php echo CHtml::label(Yii::t('car', 'car_image_operate'), null, array('class' => 'col-sm-2 control-label')); ?>
    <div class="controls col-sm-10">

        <?php
        $this->widget('common.widgets.upload.Upload', array(
            'type' => 'images',
            'id' => 'imageupload_operate',
            'buttonheight' => 25,
            'path' => array('cars', $this->site_id, Yii::app()->user->id),
            'limit' => 100,
            'multi' => true,
            'imageoptions' => array(
                'resizes' => array(array(200, 200))
            ),
            'buttontext' => 'Thêm ảnh',
            'displayvaluebox' => false,
            'oncecomplete' => "var firstitem   = jQuery('#algalley_operate .alimglist').find('.ui-state-default:first');var alimgitem   = '<li class=\"ui-state-default\"><div class=\"alimgitem\"><div class=\"alimgitembox\"> <div class=\"delimg\"><a href=\"#\" class=\"new_delimgaction\"><i class=\"icon-remove\"></i></a></div><div class=\"alimgthum\"><img src=\"'+da.imgurl+'\"></div><div ><input class=\"position_image\" type=\"hidden\" name=\"order_img[]\" value=\"newimage\" /><input type=\"radio\" value=\"new_'+da.imgid+'\" name=\"setava\"><span>" . Yii::t('album', 'album_set_avatar') . "</span><input placeholder=\"Tiêu đề\" type=\"text\" name=\"setinfonew['+da.imgid+'][title]\" /><textarea placeholder=\"Mô tả\" name=\"setinfonew['+da.imgid+'][description]\"></textarea></div><input type=\"hidden\" value=\"'+da.imgid+'\" name=\"newimage[5][]\" class=\"newimage\" /></div></div></li>';if(firstitem.html()){firstitem.before(alimgitem);}else{jQuery('#algalley_operate #sortable_operate').append(alimgitem);}; updateImgBox();",
            'onUploadStart' => 'ta=false;',
            'queuecomplete' => 'ta=true;',
        ));
        ?>

        <div id="algalley_operate" class="algalley">
            <span style="font-size: 12px;color: blue"><i>* Kéo thả để thay đổi vị trí</i></span>
            <div style="display:none" id="Albums_imageitem_em_" class="errorMessage"><?php echo Yii::t('album', 'album_must_one_img'); ?></div>
            <div class="alimgbox">
                <div class="alimglist">
                    <ul id="sortable_operate">
                        <?php
                        if ($count_images) {
                            foreach ($images as $key => $image) {
                                if ($image['type'] == 5) { // 5 là kiểu ảnh vận hành
                                    $this->renderPartial('imageitem', array('image' => $image, 'avatar_id' => $model->avatar_id));
                                    unset($images[$key]);
                                }
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $("#sortable_operate").sortable({
            stop: function (event, ui) {
                var img_id = $(ui.item).find('.position_image').val();
                if (img_id == 'newimage') {
                    $(ui.item).find('.newimage').attr('name', 'newimage[' + ui.item.index() + ']')
                }
            }
        });
        $("#sortable_operate").disableSelection();
    });
</script>