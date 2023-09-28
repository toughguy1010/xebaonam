<?php 
    $types = CarAccessories::optionType();
    unset($types['']);
?>
<style>
    .alimgthum {
        overflow: hidden;
    }
    .alimgitembox input[type=text]{
        width: 90%;
        margin-bottom: 5px;
    }
    .alimgitembox textarea {
        width: 90%;
    }

    .algalley .alimgbox .alimglist .active .alimgitembox {
        border: 1px solid #999;
    }
    .algalley .alimgbox .alimglist .alimgitem .alimgitembox {
        margin: 0px 10px 10px 0px;
        border: 1px solid #DDD;
        position: relative;
    }
    .sortable, 
    .sortable_interior, 
    .sortable_exterior, 
    .sortable_safety, 
    .sortable_operate { 
        list-style-type: none; margin: 0; padding: 0; width: 100%;
    }
    .sortable li, 
    .sortable_interior li, 
    .sortable_exterior li, 
    .sortable_safety li, 
    .sortable_operate li{ 
        margin: 3px 3px 3px 0; padding: 1px; float: left; width: 250px; height: 410px; text-align: center; 
    }
    .algalley .alimgbox .alimglist .alimgitem, 
    .algalley_interior .alimgbox .alimglist .alimgitem, 
    .algalley_exterior .alimgbox .alimglist .alimgitem, 
    .algalley_safety .alimgbox .alimglist .alimgitem, 
    .algalley_operate .alimgbox .alimglist .alimgitem{
        width: 100%;
    }
    .algalley .alimgbox .alimglist .alimgitem .alimgitembox, 
    .algalley_interior .alimgbox .alimglist .alimgitem .alimgitembox, 
    .algalley_exterior .alimgbox .alimglist .alimgitem .alimgitembox, 
    .algalley_safety .alimgbox .alimglist .alimgitem .alimgitembox, 
    .algalley_operate .alimgbox .alimglist .alimgitem .alimgitembox{
        height: 425px;
        position: relative;
    }
    .algalley .alimgbox .alimglist .alimgitem .alimgaction, 
    .algalley_interior .alimgbox .alimglist .alimgitem .alimgaction, 
    .algalley_exterior .alimgbox .alimglist .alimgitem .alimgaction, 
    .algalley_safety .alimgbox .alimglist .alimgitem .alimgaction, 
    .algalley_operate .alimgbox .alimglist .alimgitem .alimgaction{
        position: absolute;
        bottom: 0px;
    }
    .alimgbox .alimglist .alimgitem img{
        height: 200px;
        margin-bottom: 20px;
        border-bottom: 1px solid #ddd !important;
    }
</style>
<?php foreach ($types as $key => $value) { ?>
    <div class="form-group no-margin-left">
        <?php echo CHtml::label($value, null, array('class' => 'col-sm-2 control-label')); ?>
        <div class="controls col-sm-10">
            <?php
            $this->widget('common.widgets.upload.Upload', array(
                'type' => 'images',
                'id' => 'imageupload-'.$key,
                'buttonheight' => 25,
                'path' => array('cars_accessory', $this->site_id, Yii::app()->user->id),
                'limit' => 100,
                'multi' => true,
                'imageoptions' => array(
                    'resizes' => array(array(200, 200))
                ),
                'buttontext' => 'Thêm linh kiện',
                'displayvaluebox' => false,
                'oncecomplete' => "var firstitem   = jQuery('#box-accessory-$key .alimglist').find('.ui-state-default:first');var alimgitem   = '<li class=\"ui-state-default\"><div class=\"alimgitem\"><div class=\"alimgitembox\"> <div class=\"delimg\"><a href=\"#\" class=\"new_delimgaction\"><i class=\"icon-remove\"></i></a></div><div class=\"alimgthum\"><img src=\"'+da.imgurl+'\"></div><div ><input class=\"position_image\" type=\"hidden\"/><input type=\"hidden\" name=\"CarAccessories['+da.imgid+'][type]\" value=\"$key\" /><input placeholder=\"Tên linh kiện\" type=\"text\" name=\"CarAccessories['+da.imgid+'][name]\" /><input placeholder=\"Giá\" type=\"text\" name=\"CarAccessories['+da.imgid+'][price]\" value=\"\" /><textarea placeholder=\"Mô tả\" name=\"CarAccessories['+da.imgid+'][description]\"></textarea></div><input type=\"hidden\" value=\"'+da.imgid+'\" name=\"acces_key[]\" class=\"newimage\" /></div></div></li>';if(firstitem.html()){firstitem.before(alimgitem);}else{jQuery('#box-accessory-$key #sortable-$key').append(alimgitem);}; updateImgBox();",
                'onUploadStart' => 'ta=false;',
                'queuecomplete' => 'ta=true;',
            ));
            ?>
            <div id="box-accessory-<?= $key ?>" class="algalley">
                <span style="font-size: 12px;color: blue"><i>* Kéo thả để thay đổi vị trí</i></span>
                <div style="display:none" id="Albums_imageitem_em_" class="errorMessage"><?php echo Yii::t('album', 'album_must_one_img'); ?></div>
                <div class="alimgbox">
                    <div class="alimglist">
                        <ul id="sortable-<?= $key ?>" class="sortable">
                            <?php
                            $items = CarAccessories::findByType($model->id, $key);
                            if ($items) {
                                foreach ($items as $acs) {
                                    $this->renderPartial('itemaccessory', array('acs' => $acs, 'type' => $key));
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
            $("#sortable-<?= $key ?>").sortable({
                stop: function (event, ui) {
                    var img_id = $(ui.item).find('.position_image').val();
                    if (img_id == 'newimage') {
                        $(ui.item).find('.newimage').attr('name', 'newimage[' + ui.item.index() + ']')
                    }
                }
            });
            $("#sortable-<?= $key ?>").disableSelection();
        });
    </script>
    <hr>
<?php } ?>