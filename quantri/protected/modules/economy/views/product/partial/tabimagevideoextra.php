<style>
    #sortable, #sortable_interior {
        list-style-type: none;
        margin: 0;
        padding: 0;
        width: 100%;
    }

    #sortable li, #sortable_interior li {
        margin: 3px 3px 3px 0;
        padding: 1px;
        float: left;
        width: 200px;
        height: 210px;
        text-align: center;
    }

    #algalley .alimgbox .alimglist .alimgitem, #algalley_interior .alimgbox .alimglist .alimgitem {
        width: 100%;
    }

    #algalley .alimgbox .alimglist .alimgitem .alimgitembox, #algalley_interior .alimgbox .alimglist .alimgitem .alimgitembox {
        height: 200px;
        position: relative;
    }

    #algalley .alimgbox .alimglist .alimgitem .alimgaction, #algalley_interior .alimgbox .alimglist .alimgitem .alimgaction {
        position: absolute;
        bottom: 0px;
    }
</style>
<div class="form-group no-margin-left">
    <?php echo CHtml::label(Yii::t('product', 'product_detail_image'), null, array('class' => 'col-sm-2 control-label')); ?>
    <div class="controls col-sm-10">

        <?php
        $this->widget('common.widgets.upload.Upload', array(
            'type' => 'images',
            'id' => 'imageuploadgroup1',
            'buttonheight' => 25,
            'path' => array('products', $this->site_id, Yii::app()->user->id),
            'limit' => 100,
            'multi' => true,
            'imageoptions' => array(
                'resizes' => array(array(200, 200))
            ),
            'buttontext' => 'Thêm ảnh',
            'displayvaluebox' => false,
            'oncecomplete' => "var firstitem   = jQuery('#algalley_interior .alimglist').find('.ui-state-default:first');var alimgitem   = '<li class=\"ui-state-default\"><div class=\"alimgitem\"><div class=\"alimgitembox\"> <div class=\"delimg\"><a href=\"#\" class=\"new_delimgaction\"><i class=\"icon-remove\"></i></a></div><div class=\"alimgthum\"><img src=\"'+da.imgurl+'\"></div><div class=\"alimgaction\"><input class=\"position_image\" type=\"hidden\" name=\"order_img[1][]\" value=\"newimage[1][]\" /><input type=\"radio\" value=\"new_'+da.imgid+'\" name=\"setava\"><span>" . Yii::t('album', 'album_set_avatar') . "</span></div><input type=\"hidden\" value=\"'+da.imgid+'\" name=\"newimage[1][]\" class=\"newimage\" /></div></div></li>';if(firstitem.html()){firstitem.before(alimgitem);}else{jQuery('#algalley_interior #sortable_interior').append(alimgitem);}; updateImgBox();",
            'onUploadStart' => 'ta=false;',
            'queuecomplete' => 'ta=true;',
        ));
        ?>

        <div id="algalley_interior" class="algalley">
            <span style="font-size: 12px;color: blue"><i>* Kéo thả để thay đổi vị trí</i></span>
            <div style="display:none" id="Albums_imageitem_em_"
                 class="errorMessage"><?php echo Yii::t('album', 'album_must_one_img'); ?></div>
            <div class="alimgbox">
                <div class="alimglist">
                    <ul id="sortable_interior">
                        <?php
                        if (!$model->isNewRecord) {
                            $images = $model->getImages(array('group_img' => 1));
                            foreach ($images as $image) {
                                $this->renderPartial('imageitem', array('image' => $image, 'avatar_id' => $model->avatar_id, 'group_img' => 1));
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
                    $(ui.item).find('.newimage').attr('name', 'newimage[1][' + ui.item.index() + ']')
                }
            }
        });
        $("#sortable").disableSelection();
    });
</script>