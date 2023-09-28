<style>
    #sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
    #sortable li { margin: 3px 3px 3px 0; padding: 1px; float: left; width: 200px; height: 210px; text-align: center; }
    #sortable_interior { list-style-type: none; margin: 0; padding: 0; width: 100%; }
    #sortable_interior li { margin: 3px 3px 3px 0; padding: 1px; float: left; width: 200px; height: 210px; text-align: center; }
    #algalley_interior .alimgbox .alimglist .alimgitem {
        width: 100%;
    }
    #algalley_interior .alimgbox .alimglist .alimgitem img {
        max-height: 168px;
    }
    #algalley_interior .alimgbox .alimglist .alimgitem .alimgitembox {
        margin: 0;
    }
    #algalley .alimgbox .alimglist .alimgitem{
        width: 100%;
    }
    #algalley .alimgbox .alimglist .alimgitem .alimgitembox{
        height: 200px;
        position: relative;
    }
    #algalley .alimgbox .alimglist .alimgitem .alimgaction{
        position: absolute;
        bottom: 0px;
    }
</style>

<?php
if (!$model->isNewRecord) {
    $images = $model->getImages();
    $count_images = count($images);
}
?>
<div class="form-group no-margin-left">
    <?php echo CHtml::label(Yii::t('tour', 'tour_image'), null, array('class' => 'col-sm-2 control-label')); ?>
    <div class="controls col-sm-10">

        <?php
        $this->widget('common.widgets.upload.Upload', array(
            'type' => 'images',
            'id' => 'imageupload',
            'buttonheight' => 25,
            'path' => array('tours', $this->site_id, Yii::app()->user->id),
            'limit' => 100,
            'multi' => true,
            'imageoptions' => array(
                'resizes' => array(array(200, 200))
            ),
            'buttontext' => 'Thêm ảnh',
            'displayvaluebox' => false,
            'oncecomplete' => "var firstitem   = jQuery('#algalley .alimglist').find('.ui-state-default:first');var alimgitem   = '<li class=\"ui-state-default\"><div class=\"alimgitem\"><div class=\"alimgitembox\"> <div class=\"delimg\"><a href=\"#\" class=\"new_delimgaction\"><i class=\"icon-remove\"></i></a></div><div class=\"alimgthum\"><img src=\"'+da.imgurl+'\"></div><div class=\"alimgaction\"><input class=\"position_image\" type=\"hidden\" name=\"order_img[]\" value=\"newimage\" /><input type=\"radio\" value=\"new_'+da.imgid+'\" name=\"setava\"><span>" . Yii::t('album', 'album_set_avatar') . "</span></div><input type=\"hidden\" value=\"'+da.imgid+'\" name=\"newimage[0][]\" class=\"newimage\" /></div></div></li>';if(firstitem.html()){firstitem.before(alimgitem);}else{jQuery('#algalley #sortable').append(alimgitem);}; updateImgBox();",
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
                                if ($image['type'] == 0) { // 1 là kiểu ảnh nội thất
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
    <?php echo CHtml::label(Yii::t('tour', 'slideImage'), null, array('class' => 'col-sm-2 control-label')); ?>
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
            'oncecomplete' => "var firstitem   = jQuery('#algalley_interior .alimglist').find('.ui-state-default:first');var alimgitem   = '<li class=\"ui-state-default\"><div class=\"alimgitem\"><div class=\"alimgitembox\"> <div class=\"delimg\"><a href=\"#\" class=\"new_delimgaction\"><i class=\"icon-remove\"></i></a></div><div class=\"alimgthum\"><img src=\"'+da.imgurl+'\"></div><div class=\"alimgaction\"><input class=\"position_image\" type=\"hidden\" name=\"order_img[]\" value=\"newimage\" /><input type=\"radio\" value=\"new_'+da.imgid+'\" name=\"setava\"><span>" . Yii::t('album', 'album_set_avatar') . "</span></div><input type=\"hidden\" value=\"'+da.imgid+'\" name=\"newimage[1][]\" class=\"newimage\" /></div></div></li>';if(firstitem.html()){firstitem.before(alimgitem);}else{jQuery('#algalley_interior #sortable_interior').append(alimgitem);}; updateImgBox();",
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
                                if ($image['type'] == 1) { // 1 là kiểu ảnh nội thất
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