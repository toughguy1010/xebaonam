<style>
    #sortable,
    #sortable_interior,
    #sortable_exterior,
    #sortable_safety,
    #sortable_operate {
        list-style-type: none;
        margin: 0;
        padding: 0;
        width: 100%;
    }

    #sortable li,
    #sortable_interior li,
    #sortable_exterior li,
    #sortable_safety li,
    #sortable_operate li {
        margin: 3px 3px 3px 0;
        padding: 1px;
        float: left;
        width: 250px;
        height: 410px;
        text-align: center;
    }

    #algalley .alimgbox .alimglist .alimgitem,
    #algalley_interior .alimgbox .alimglist .alimgitem,
    #algalley_exterior .alimgbox .alimglist .alimgitem,
    #algalley_safety .alimgbox .alimglist .alimgitem,
    #algalley_operate .alimgbox .alimglist .alimgitem {
        width: 100%;
    }

    #algalley .alimgbox .alimglist .alimgitem .alimgitembox,
    #algalley_interior .alimgbox .alimglist .alimgitem .alimgitembox,
    #algalley_exterior .alimgbox .alimglist .alimgitem .alimgitembox,
    #algalley_safety .alimgbox .alimglist .alimgitem .alimgitembox,
    #algalley_operate .alimgbox .alimglist .alimgitem .alimgitembox {
        height: 400px;
        position: relative;
    }

    #algalley .alimgbox .alimglist .alimgitem .alimgaction,
    #algalley_interior .alimgbox .alimglist .alimgitem .alimgaction,
    #algalley_exterior .alimgbox .alimglist .alimgitem .alimgaction,
    #algalley_safety .alimgbox .alimglist .alimgitem .alimgaction,
    #algalley_operate .alimgbox .alimglist .alimgitem .alimgaction {
        position: absolute;
        bottom: 0px;
    }

    .alimgbox .alimglist .alimgitem img {
        height: 200px;
        margin-bottom: 20px;
        border-bottom: 1px solid #ddd !important;
    }
    #sortable_operate li{
        width: 33.33%;
        height: auto;
    }
    #algalley_operate .alimgbox .alimglist .alimgitem .alimgitembox {
        height: auto;
    }

</style>


<?php
if (!$model->isNewRecord) {
    $images = $model->getImagesHightLights();
    $count_images = count($images);
}
?>
<div class="form-group no-margin-left">
    <?php echo CHtml::label(Yii::t('product', 'product_hightlights'), null, array('class' => 'col-sm-2 control-label')); ?>
    <div class="controls col-sm-10">

        <?php
        $this->widget('common.widgets.upload.Upload', array(
            'type' => 'images',
            'id' => 'imageupload_operate',
            'buttonheight' => 25,
            'path' => array('product', $this->site_id, Yii::app()->user->id),
            'limit' => 100,
            'multi' => true,
            'imageoptions' => array(
                'resizes' => array(array(200, 200))
            ),
            'buttontext' => 'Thêm ảnh',
            'displayvaluebox' => false,
            'oncecomplete' => "var firstitem   = jQuery('#algalley_operate .alimglist').find('.ui-state-default:first');var alimgitem   = '<li class=\"ui-state-default\"><div class=\"alimgitem\"><div class=\"alimgitembox\"> <div class=\"delimg\"><a href=\"#\" class=\"new_delimgaction\"><i class=\"icon-remove\"></i></a></div><div class=\"alimgthum\"><img src=\"'+da.imgurl+'\"></div><div ><input class=\"position_image\" type=\"hidden\" name=\"order_img[]\" value=\"productimages\" /><input placeholder=\"Tiêu đề\" type=\"text\" name=\"setinfonew['+da.imgid+'][title]\" /> <p><input name=\"us-ck\" type=\"checkbox\" class=\"product_detail_hightligh\" class_t=\"'+da.imgid+'\" value=\"\" style=\"\"> <span>Sử dụng trình soạn thảo</span></p><textarea id=\"att_r'+da.imgid+'\"placeholder=\"Mô tả\" name=\"setinfonew['+da.imgid+'][description]\"></textarea></div><input type=\"hidden\" value=\"'+da.imgid+'\" name=\"productimages[5][]\" class=\"productimages\" /></div></div></li>';if(firstitem.html()){firstitem.before(alimgitem);}else{jQuery('#algalley_operate #sortable_operate').append(alimgitem);}; updateImgBox();each_editer();",
            'onUploadStart' => 'ta=false;',
            'queuecomplete' => 'ta=true;',
        ));
        ?>

        <div id="algalley_operate" class="algalley">
            <span style="font-size: 12px;color: blue"><i>* Kéo thả để thay đổi vị trí</i></span>
            <div style="display:none" id="Albums_imageitem_em_"
                 class="errorMessage"><?php echo Yii::t('product', 'product_hightlights'); ?></div>
            <div class="alimgbox">
                <div class="alimglist">
                    <ul id="sortable_operate">
                        <?php
                        if ($count_images) {
                            foreach ($images as $key => $image) {
                                $this->renderPartial('imageitemhightlights', array('image' => $image));
                                unset($images[$key]);
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
                if (img_id == 'productimages') {
                    $(ui.item).find('.productimages').attr('name', 'productimages[' + ui.item.index() + ']')
                }
            }
        });
        $("#sortable_operate").disableSelection();
    });
</script>

<style>
    .alimgitembox input[type=text] {
        width: 90%;
        margin-bottom: 5px;
    }
    .alimgitembox textarea{
        margin: 0px;
        width: 90%;
        height: 100px;
        margin-bottom: 10px;
    }
</style>
<script>
    function each_editer(){
        $(".product_detail_hightligh").each(function(){
            $(this).on("click", function () {
                var key='att_r'+$(this).attr("class_t");
                console.log(key);
                if (this.checked) {
                    CKEDITOR.replace(key, {
                        height: 150,
                        language: '<?php echo Yii::app()->language ?>'
                    });
                } else {
                    var a = CKEDITOR.instances[key];
                    if (a) {
                        a.destroy(true);
                    }

                }
            });
        });
    }
    jQuery(document).ready(function () {
        each_editer();
    });
</script>
