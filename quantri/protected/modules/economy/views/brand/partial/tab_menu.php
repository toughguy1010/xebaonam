<style type="text/css">
    #sortable li{
        list-style-type: none;
        float: left;
        width: 150px;
    }
    #algalley .alimgbox .alimglist .alimgitem{
        width: 100%;
    }
    #sortable1 li{
        list-style-type: none;
        float: left;
        width: 150px;
    }
    #algalley1 .alimgbox .alimglist1 .alimgitem{
        width: 100%;
    }
</style>
<script type="text/javascript">
    var ta = true;
    jQuery(document).ready(function () {
        //
        CKEDITOR.replace("Brand_content_menu", {
            height: 200,
            language: '<?php echo Yii::app()->language ?>'
        });
    });
    jQuery(function ($) {
    });
</script>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'content_menu', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'content_menu', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'content_menu'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo CHtml::label('Gallery', null, array('class' => 'col-sm-2 control-label')); ?>
    <div class="controls col-sm-10">

        <?php
        $this->widget('common.widgets.upload.Upload', array(
            'type' => 'images',
            'id' => 'imageuploadmenu',
            'buttonheight' => 25,
            'path' => array('products', $this->site_id, Yii::app()->user->id),
            'limit' => 100,
            'multi' => true,
            'imageoptions' => array(
                'resizes' => array(array(200, 200))
            ),
            'buttontext' => 'Thêm ảnh',
            'displayvaluebox' => false,
            'oncecomplete' => "return callbackImageMenu(da);",
            'onUploadStart' => 'ta=false;',
            'queuecomplete' => 'ta=true;',
        ));
        ?>

        <div id="algalley1" class="algalley">
            <!--<span style="font-size: 12px;color: blue"><i>* Kéo thả để thay đổi vị trí</i></span>-->
            <div style="display:none" id="Albums_imageitem_em_"
                 class="errorMessage"><?php echo Yii::t('album', 'album_must_one_img'); ?></div>
            <div class="alimgbox">
                <div class="alimglist1 alimglist">
                    <ul id="sortable1">
                        <?php
                        if (!$model->isNewRecord) {
                            $images = $model->getImages(array('type' => BrandImages::IMAGE_MENU));
                            foreach ($images as $image) {
                                $this->renderPartial('imageitem', array('image' => $image));
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

    function callbackImageMenu(da) {
        var firstitem = jQuery('#algalley1 .alimglist1').find('.ui-state-default:first');
        var html = '<li class="ui-state-default">';
        html += '<div class="alimgitem">';
        html += '<div class="alimgitembox">';
        html += '<div class="delimg">';
        html += '<a href="#" class="new_delimgaction">';
        html += '<i class="icon-remove"></i>';
        html += '</a>';
        html += '</div>';
        html += '<div class="alimgthum">';
        html += '<img src="' + da.imgurl + '">';
        html += '</div>';
        html += '<div class="alimgaction">';
        html += '<input class="position_image" type="hidden" name="order_imgmenu[]" value="newimagemenu[]" />';
//        html += '<input type="radio" value="new_' + da.imgid + '" name="setava">';
//        html += '<span>Đặt làm ảnh đại diện</span>';
        html += '</div>';
        html += '<input type="hidden" value="' + da.imgid + '" name="newimagemenu[]" class="newimage" />';
        html += '</div>';
        html += '</div>';
        html += '</li>';


        if (firstitem.html()) {
            firstitem.before(html);
        } else {
            jQuery('#algalley1 #sortable1').append(html);
        }
    }

    $(function () {
        $("#sortable1").sortable({
            stop: function (event, ui) {
                var img_id = $(ui.item).find('.position_image').val();
                if (img_id == 'newimage') {
                    $(ui.item).find('.newimage').attr('name', 'newimage[0][' + ui.item.index() + ']')
                }
            }
        });
        $("#sortable1").disableSelection();
    });
</script>
