<style type="text/css">
    #sortable2 li{
        list-style-type: none;
        float: left;
        width: 150px;
    }
    #algalley .alimgbox .alimglist .alimgitem{
        width: 100%;
    }
    #sortable2 li{
        list-style-type: none;
        float: left;
        width: 150px;
    }
    #algalley2 .alimgbox .alimglist .alimgitem{
        width: 100%;
    }
    #algalley2 .alimgbox .alimglist .alimgitem .alimgitembox {
        margin: 0px 10px 10px 0px;
        border: 1px solid #DDD;
        position: relative;
    }
    #algalley2 .alimgbox .alimglist .alimgitem .alimgitembox .delimg {
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: #FFF;
        display: none;
    }
    #algalley2 .alimgbox .alimglist .alimgitem .alimgitembox .alimgthum{
        margin: 5px;
        overflow: hidden;
        display: block;
    }
    #algalley2 .alimgbox .alimglist .alimgitem img {
        width: 100%;
        max-width: 100%;
        display: block;
        border: none;
    }
    #algalley2 .alimgbox .alimglist .alimgitem .alimgitembox:hover .delimg{display: block;}
    #algalley2 .alimgbox .alimglist .alimgitem .alimgitembox .delimg a{color: red;font-size:18px;}



    #sortable3 li{
        list-style-type: none;
        float: left;
        width: 150px;
    }
    #algalley .alimgbox .alimglist .alimgitem{
        width: 100%;
    }
    #sortable3 li{
        list-style-type: none;
        float: left;
        width: 150px;
    }
    #algalley3 .alimgbox .alimglist .alimgitem{
        width: 100%;
    }
    #algalley3 .alimgbox .alimglist .alimgitem .alimgitembox {
        margin: 0px 10px 10px 0px;
        border: 1px solid #DDD;
        position: relative;
    }
    #algalley3 .alimgbox .alimglist .alimgitem .alimgitembox .delimg {
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: #FFF;
        display: none;
    }
    #algalley3 .alimgbox .alimglist .alimgitem .alimgitembox .alimgthum{
        margin: 5px;
        overflow: hidden;
        display: block;
    }
    #algalley3 .alimgbox .alimglist .alimgitem img {
        width: 100%;
        max-width: 100%;
        display: block;
        border: none;
    }
    #algalley3 .alimgbox .alimglist .alimgitem .alimgitembox:hover .delimg{display: block;}
    #algalley3 .alimgbox .alimglist .alimgitem .alimgitembox .delimg a{color: red;font-size:18px;}
</style>
<script type="text/javascript">
    var ta = true;
    jQuery(document).ready(function () {
        //
        CKEDITOR.replace("Brand_content_catering", {
            height: 200,
            language: '<?php echo Yii::app()->language ?>'
        });
        CKEDITOR.replace("Brand_catering_serves", {
            height: 200,
            language: '<?php echo Yii::app()->language ?>'
        });
        CKEDITOR.replace("Brand_catering_menu", {
            height: 200,
            language: '<?php echo Yii::app()->language ?>'
        });
    });
    jQuery(function ($) {
    });
</script>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'content_catering', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'content_catering', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'content_catering'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'catering_serves', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'catering_serves', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'catering_serves'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo CHtml::label('Gallery', null, array('class' => 'col-sm-2 control-label')); ?>
    <div class="controls col-sm-10">

        <?php
        $this->widget('common.widgets.upload.Upload', array(
            'type' => 'images',
            'id' => 'imageuploadcatering',
            'buttonheight' => 25,
            'path' => array('products', $this->site_id, Yii::app()->user->id),
            'limit' => 100,
            'multi' => true,
            'imageoptions' => array(
                'resizes' => array(array(200, 200))
            ),
            'buttontext' => 'Thêm ảnh',
            'displayvaluebox' => false,
            'oncecomplete' => "return callbackImageCatering(da);",
            'onUploadStart' => 'ta=false;',
            'queuecomplete' => 'ta=true;',
        ));
        ?>

        <div id="algalley2" class="algalley">
            <!--<span style="font-size: 12px;color: blue"><i>* Kéo thả để thay đổi vị trí</i></span>-->
            <div style="display:none" id="Albums_imageitem_em_"
                 class="errorMessage"><?php echo Yii::t('album', 'album_must_one_img'); ?></div>
            <div class="alimgbox">
                <div class="alimglist2 alimglist">
                    <ul id="sortable2">
                        <?php
                        if (!$model->isNewRecord) {
                            $images = $model->getImages(array('type' => BrandImages::IMAGE_CATERING));
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

    function callbackImageCatering(da) {
        var firstitem = jQuery('#algalley2 .alimglist2').find('.ui-state-default:first');
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
        html += '<input class="position_image" type="hidden" name="order_imgcatering[]" value="newimagecatering[]" />';
//        html += '<input type="radio" value="new_' + da.imgid + '" name="setava">';
//        html += '<span>Đặt làm ảnh đại diện</span>';
        html += '</div>';
        html += '<input type="hidden" value="' + da.imgid + '" name="newimagecatering[]" class="newimage" />';
        html += '</div>';
        html += '</div>';
        html += '</li>';


        if (firstitem.html()) {
            firstitem.before(html);
        } else {
            jQuery('#algalley2 #sortable2').append(html);
        }
    }

    $(function () {
        $("#sortable2").sortable({
            stop: function (event, ui) {
                var img_id = $(ui.item).find('.position_image').val();
                if (img_id == 'newimage') {
                    $(ui.item).find('.newimage').attr('name', 'newimage[0][' + ui.item.index() + ']')
                }
            }
        });
        $("#sortable2").disableSelection();
    });
</script>

<div class="form-group no-margin-left">
    <?php echo CHtml::label('Images menu', null, array('class' => 'col-sm-2 control-label')); ?>
    <div class="controls col-sm-10">

        <?php
        $this->widget('common.widgets.upload.Upload', array(
            'type' => 'images',
            'id' => 'imagemenuuploadcatering',
            'buttonheight' => 25,
            'path' => array('products', $this->site_id, Yii::app()->user->id),
            'limit' => 100,
            'multi' => true,
            'imageoptions' => array(
                'resizes' => array(array(200, 200))
            ),
            'buttontext' => 'Thêm ảnh',
            'displayvaluebox' => false,
            'oncecomplete' => "return callbackImageMenuCatering(da);",
            'onUploadStart' => 'ta=false;',
            'queuecomplete' => 'ta=true;',
        ));
        ?>

        <div id="algalley3" class="algalley">
            <!--<span style="font-size: 12px;color: blue"><i>* Kéo thả để thay đổi vị trí</i></span>-->
            <div style="display:none" id="Albums_imageitem_em_"
                 class="errorMessage"><?php echo Yii::t('album', 'album_must_one_img'); ?></div>
            <div class="alimgbox">
                <div class="alimglist3 alimglist">
                    <ul id="sortable3">
                        <?php
                        if (!$model->isNewRecord) {
                            $images = $model->getImages(array('type' => BrandImages::IMAGE_MENU_CATERING));
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

    function callbackImageMenuCatering(da) {
        var firstitem = jQuery('#algalley3 .alimglist3').find('.ui-state-default:first');
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
        html += '<input class="position_image" type="hidden" name="order_imgmenucatering[]" value="newimagemenucatering[]" />';
//        html += '<input type="radio" value="new_' + da.imgid + '" name="setava">';
//        html += '<span>Đặt làm ảnh đại diện</span>';
        html += '</div>';
        html += '<input type="hidden" value="' + da.imgid + '" name="newimagemenucatering[]" class="newimage" />';
        html += '</div>';
        html += '</div>';
        html += '</li>';


        if (firstitem.html()) {
            firstitem.before(html);
        } else {
            jQuery('#algalley3 #sortable3').append(html);
        }
    }

    $(function () {
        $("#sortable3").sortable({
            stop: function (event, ui) {
                var img_id = $(ui.item).find('.position_image').val();
                if (img_id == 'newimage') {
                    $(ui.item).find('.newimage').attr('name', 'newimage[0][' + ui.item.index() + ']')
                }
            }
        });
        $("#sortable3").disableSelection();
    });
</script>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'catering_menu', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'catering_menu', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'catering_menu'); ?>
    </div>
</div>
