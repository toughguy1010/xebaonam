<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js?ver=' . VERSION); ?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/chosen/chosen.css">
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/chosen/chosen.jquery.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function () {
        CKEDITOR.replace("CategoryPage_content", {
            height: 400,
            language: '<?php echo Yii::app()->language ?>'
        });
    });
</script>

<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'category-page-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
        ));
        ?>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'title', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'title', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'title'); ?>
            </div>
        </div>
        <?php if (!$model->isNewRecord) { ?>
            <div class="control-group form-group">
                <?php echo $form->labelEx($model, 'alias', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                <div class="controls col-sm-10">
                    <?php echo $form->textField($model, 'alias', array('class' => 'span12 col-sm-12')); ?>
                    <?php echo $form->error($model, 'alias'); ?>
                </div>
            </div>
        <?php } ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
                <div id="coursecategoryravatar" style="display: block; margin-top: 0px;">
                    <div id="coursecategoryavatar_img"
                         style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">
                        <?php if ($model->image_path && $model->image_name) { ?>
                            <img
                                    src="<?php echo ClaHost::getImageHost() . $model->image_path . 's100_100/' . $model->image_name; ?>"
                                    style="width: 100%;"/>
                        <?php } ?>
                    </div>
                    <div id="coursecategoryavatar_form" style="display: inline-block;">
                        <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
                    </div>
                </div>
                <?php echo $form->error($model, 'avatar'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'short_description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'short_description', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'short_description'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'content', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'content', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'content'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'product_id', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <!--asort($option_hotel);-->
                <select data-placeholder="Chọn sản phẩm" name="CategoryPage[product_id]" id="CategoryPage_product_id"
                        class="chosen-product span12 col-sm-6" tabindex="2">
                    <?php foreach ($option_product as $option_product_id => $option_product_name) { ?>
                        <option <?php echo $model->product_id == $option_product_id ? 'selected' : '' ?>
                                value="<?php echo $option_product_id ?>"><?php echo $option_product_name ?></option>
                    <?php } ?>
                </select>
                <!--                    --><?php
                //echo $form->hiddenField($model, 'product_id',
                //                        array('class' => 'span12 col-sm-6'));
                //
                ?>
                <?php echo $form->error($model, 'product_id'); ?>
            </div>
            <div class="controls col-sx-2">
            </div>
        </div>
        <style>
            .imgAlt{padding: 5px;}
            .imgAlt .controls{width: 100%;}
            .masonry {
                padding: 0;
                -moz-column-gap: 1.5em;
                -webkit-column-gap: 1.5em;
                column-gap: 1.5em;
                font-size: .85em;
                -moz-column-count: 4;
                -webkit-column-count: 4;
                column-count: 4;
            }

            .masonry .item {
                float: none !important;
                display: inline-block;
                width: 100% !important;
                box-sizing: border-box;
                -moz-box-sizing: border-box;
                -webkit-box-sizing: border-box;
            }
            #sortable, #sortable_interior, #sortable_exterior, #sortable_safety { list-style-type: none; margin: 0; padding: 0; width: 100%; }
            #sortable li, #sortable_interior li, #sortable_exterior li, #sortable_safety li{
                margin: 3px 3px 3px 0; padding: 1px; float: left; width: 200px; height: 210px; text-align: center;
            }
            #algalley .alimgbox .alimglist .alimgitem, #algalley_interior .alimgbox .alimglist .alimgitem, #algalley_exterior .alimgbox .alimglist .alimgitem, #algalley_safety .alimgbox .alimglist .alimgitem{
                /*width: 100%;*/
            }
            #algalley .alimgbox .alimglist .alimgitem .alimgitembox, #algalley_interior .alimgbox .alimglist .alimgitem .alimgitembox, #algalley_exterior .alimgbox .alimglist .alimgitem .alimgitembox, #algalley_safety .alimgbox .alimglist .alimgitem .alimgitembox{
                height: 100%;
                position: relative;
            }
            #algalley .alimgbox .alimglist .alimgitem .alimgaction, #algalley_interior .alimgbox .alimglist .alimgitem .alimgaction, #algalley_exterior .alimgbox .alimglist .alimgitem .alimgaction, #algalley_safety .alimgbox .alimglist .alimgitem .alimgaction{
                /*position: absolute;*/
                /*bottom: 0px;*/
            }
        </style>

        <?php
        if (!$model->isNewRecord) {
            $images = $model->getImages();
            $count_images = (isset($images)) ? count($images) : 0;
        }
        ?>
        <hr>
        <div class="form-group no-margin-left">
            <?php echo CHtml::label(Yii::t('categorypage', 'categorypageImage'), null, array('class' => 'col-sm-2 control-label')); ?>
            <div class="controls col-sm-10">

                <?php
                $this->widget('common.widgets.upload.Upload', array(
                    'type' => 'images',
                    'id' => 'imageupload',
                    'buttonheight' => 25,
                    'path' => array('content', $this->site_id, Yii::app()->user->id),
                    'limit' => 100,
                    'multi' => true,
                    'imageoptions' => array(
                        'resizes' => array(array(200, 200))
                    ),
                    'buttontext' => 'Thêm ảnh',
                    'displayvaluebox' => false,
                    'onUploadStart' => 'ta=false;',
                    'queuecomplete' => 'ta=true;',
                    'oncecomplete' => 'callbackUpload(da)',
                ));
                ?>

                <script type="text/javascript">
                    function callbackUpload(da) {
                        var firstitem = jQuery('#algalley .alimglist').find('.alimgitem:first');
                        var html = '<div class="alimgitem">';
                        html += '<div class="alimgitembox">';
                        html += '<div class="delimg">';
                        html += '<a href="#" class="new_delimgaction">';
                        html += '<i class="icon-remove"></i>';
                        html += '</a>';
                        html += '</div>';
                        html += '<div class="alimgthum">';
                        html += '<img src="' + da.imgurl + '">';
                        html += '</div>';
                        html += '<div class="alimgaction" style="text-align: left;">';
                        html += '<input type="radio" value="new_' + da.imgid + '" name="setava">';
                        html += '<span><?php echo Yii::t('album', 'album_set_avatar') ?></span>';
                        html += '<br />';
                        html += '</div>';
                        html += '<div class="imgAlt">';
                        html += '<input class="controls" name="NewImageAlt[' + da.imgid + ']" type="text" maxlength="250" value="" placeHolder="<?php echo Yii::t('common', 'title') ?>">';
                        html += '</div>';
                        html += '<input type="hidden" value="' + da.imgid + '" name="newimage[1][]" class="newimage" />';
                        html += '</div>';
                        html += '</div>';
                        if (firstitem.html()) {
                            firstitem.before(html);
                        } else {
                            jQuery('#algalley .alimglist').append(html);
                        }
                        updateImgBox();
                    }
                </script>

                <div id="algalley_interior" class="algalley">
                    <div id="algalley">
                        <div style="display:none" id="Albums_imageitem_em_" class="errorMessage"><?php echo Yii::t('album', 'album_must_one_img'); ?></div>
                        <div class="alimgbox">
                            <div class="grid alimglist">
                                <?php
                                foreach ($images as $image) {
                                    $this->renderPartial('script/imageitem', array('image' => $image, 'avatar_id' => $model->avatar_id));
                                }
                                ?>

                            </div>
                            <div class="clearfix"></div>
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

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'layout_action', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'layout_action', array('class' => 'span10 col-sm-12')); ?>
                <?php echo $form->error($model, 'layout_action'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'view_action', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'view_action', array('class' => 'span10 col-sm-12')); ?>
                <?php echo $form->error($model, 'view_action'); ?>
            </div>
        </div>

        <hr>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'meta_keywords', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'meta_keywords', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'meta_keywords'); ?>
            </div>
            <div style="clear: both;"><br/></div>
            <?php echo $form->labelEx($model, 'meta_description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'meta_description', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'meta_description'); ?>
            </div>
            <div style="clear: both;"><br/></div>
            <?php echo $form->labelEx($model, 'meta_title', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'meta_title', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'meta_title'); ?>
            </div>
        </div>

        <div class="control-group form-group buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'create') : Yii::t('common', 'update'), array('class' => 'btn btn-info')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div><!-- form -->
<script type="text/javascript">
    jQuery(function ($) {
        jQuery('#coursecategoryavatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/content/categorypage/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#CategoryPage_avatar').val(obj.data.avatar);
                        if (jQuery('#coursecategoryavatar_img img').attr('src')) {
                            jQuery('#coursecategoryvatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#coursecategoryavatar_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#coursecategoryavatar_img').css({"margin-right": "10px"});
                    }
                }
            }
        });


    });
</script>
<?php
$this->renderPartial('script/mainscript', array('model' => $model));
?>
<script type="text/javascript">
    var config = {
        '.chosen-product': {}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
    //    $('#CategoryPage_product_id').on('change', function (e) {
    //         triggers when whole value changed
    //        $('#CategoryPage_product_name').val($("form .chosen-single span").text());
    //    });
</script>
