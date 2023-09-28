<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/effects/imagesloaded.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/effects/masonry.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js');
?>
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
<script type="text/javascript">
    var ta = true;
    jQuery(document).ready(function () {
        //
        CKEDITOR.replace("Albums_album_description", {
            height: 300,
            language: '<?php echo Yii::app()->language ?>'
        });
    });
    jQuery(function ($) {
    });
</script>
<div class="form" style="padding: 10px;">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'albums-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'htmlOptions' => array('class' => 'form-horizontal'),
    ));
    ?>

    <div class="albox">
        <div class="alheader">
            <div class="altitle">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'album_name', array('class' => 'col-sm-3 control-label no-padding-left')); ?>
                    <div class="col-sm-9">
                        <?php echo $form->textField($model, 'album_name', array('class' => 'col-sm-11')); ?>
                        <div class="col-sm-12 help-block no-padding">
                            <?php echo $form->error($model, 'album_name'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ishot', array('class' => 'col-sm-3 control-label no-padding-left')); ?>
                    <div class="col-sm-9">
                        <?php echo $form->checkBox($model, 'ishot'); ?>
                        <div class="col-sm-12 help-block no-padding">
                            <?php echo $form->error($model, 'ishot'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'order', array('class' => 'col-sm-3 control-label no-padding-left')); ?>
                    <div class="col-sm-9">
                        <?php echo $form->textField($model, 'order', array('class' => 'col-sm-11')); ?>
                        <div class="col-sm-12 help-block no-padding">
                            <?php echo $form->error($model, 'order'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'cat_id', array('class' => 'col-sm-3 control-label no-padding-left')); ?>
                    <div class="col-sm-9">
                        <?php echo $form->dropDownList($model, 'cat_id', $option_category, array('class' => 'span10 col-sm-12')); ?>
                        <div class="col-sm-12 help-block no-padding">
                            <?php echo $form->error($model, 'cat_id'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-3 control-label no-padding-left')); ?>
                    <div class="col-sm-9">
                        <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArray(), array('class' => 'span10 col-sm-12')); ?>
                        <?php echo $form->error($model, 'status'); ?>
                    </div>
                </div>

            </div>
            <div class="alaction">
                <div class="buttons">
                    <?php
                    $this->widget('common.widgets.upload.Upload', array(
                        'type' => 'images',
                        'id' => 'imageupload',
                        'buttonheight' => 25,
                        'path' => array('albums', $this->site_id, Yii::app()->user->id),
                        'limit' => 100,
                        'fileSizeLimit' => '10MB',
                        'multi' => true,
                        'imageoptions' => array(
                            'resizes' => array(array(200, 200))
                        ),
                        'buttontext' => 'Thêm ảnh',
                        'displayvaluebox' => false,
                        'oncecomplete' => "callbackUpload(da);"
                    ));
                    ?>
                    <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'create') : Yii::t('common', 'update'), array('class' => 'btn btn-info', 'id' => 'savealbum')); ?>
                </div>
            </div>
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
                    html += '<input type="checkbox" name="ImageHotNew[' + da.imgid + ']" value="1" /> <span> Hot</span>';
                    html += '</div>';
                    html += '<div class="imgAlt">';
                    html += '<input class="controls" name="NewImageAlt[' + da.imgid + ']" type="text" maxlength="250" value="" placeHolder="<?php echo Yii::t('common', 'title') ?>">';
                    html += '</div>';
                    html += '<input type="hidden" value="' + da.imgid + '" name="newimage[]" class="newimage" />';
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

            <div style="clear: both;"></div>
        </div>
        <div id="algalley_interior" class="algalley">
            <div id="algalley">
                <div style="display:none" id="Albums_imageitem_em_" class="errorMessage"><?php echo Yii::t('album', 'album_must_one_img'); ?></div>
                <div class="alimgbox">
                    <div class="grid alimglist">
                        <?php
                        foreach ($images as $image) {
                            $this->renderPartial('imageitem', array('image' => $image, 'avatar_id' => $model->avatar_id));
                        }
                        ?>

                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <script>
//        $(function () {
//            $("#algalley_interior").sortable({
//                stop: function (event, ui) {
//                    var img_id = $(ui.item).find('.position_image').val();
//                    if (img_id == 'newimage') {
//                        $(ui.item).find('.newimage').attr('name', 'newimage[' + ui.item.index() + ']')
//                    }
//                }
//            });
//            $("#algalley_interior").disableSelection();
//        });
    </script>
    <div class="form-group" style="border-top: 1px solid #ddd;padding: 20px 0px;margin-top: 20px;">
        <?php echo $form->labelEx($model, 'album_description', array('class' => 'col-sm-12 control-label no-padding-left')); ?>
        <div class="col-sm-12">
            <?php echo $form->textArea($model, 'album_description', array('class' => 'col-sm-11')); ?>
            <div class="col-sm-12 help-block no-padding">
                <?php echo $form->error($model, 'album_description'); ?>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->
<?php
$this->renderPartial('script/mainscript');
?>