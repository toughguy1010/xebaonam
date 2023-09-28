<?php
//
$category = new ClaCategory();
$category->type = ClaCategory::CATEGORY_SERVICE;
$category->generateCategory();
$arr = array('' => Yii::t('category', 'category_parent_0'));
//
$option = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $arr);
$timeOptions = ClaService::getWorkTimeDuration(array('none' => true));
//
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/style3/colorbox.css"></link>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/jquery.colorbox-min.js"></script>

<script type="text/javascript">
    jQuery(document).ready(function () {
        $("#addCate").colorbox({width: "80%", overlayClose: false});
        CKEDITOR.replace("SeServicesInfo_description", {
            height: 300,
            language: '<?php echo Yii::app()->language ?>'
        });
        $('#ck-check').on("click", function () {
            if (this.checked) {
                CKEDITOR.replace("SeServicesInfo_sort_description", {
                    height: 400,
                    language: '<?php echo Yii::app()->language ?>'
                });
            } else {
                var a = CKEDITOR.instances['SeServicesInfo_sort_description'];
                if (a) {
                    a.destroy(true);
                }

            }
        });
    });

    jQuery(function ($) {
        jQuery('#newsavatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/service/service/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#SeServices_avatar').val(obj.data.avatar);
                        if (jQuery('#newsavatar_img img').attr('src')) {
                            jQuery('#newsavatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#newsavatar_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#newsavatar_img').css({"margin-right": "10px"});
                    }
                } else {
                    if (obj.message)
                        alert(obj.message);
                }

            }
        });
    });</script>
<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'news-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
        ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'name', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </div>
        </div>
        <?php // if (!$model->isNewRecord) {  ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'alias', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'alias', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'alias'); ?>
            </div>
        </div>
        <?php // }  ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'category_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <div class="input-group">
                    <?php echo $form->dropDownList($model, 'category_id', $option, array('class' => 'form-control')); ?>
                    <div class="input-group-btn" style="padding-left: 10px;">  
                        <a href="<?php echo Yii::app()->createUrl('service/category/addcat', array('pa' => ClaCategory::CATEGORY_ROOT) + $_GET) ?>" id="addCate" class="btn btn-primary btn-sm" style="line-height: 16px;">
                            <?php echo Yii::t('category', 'category_add'); ?>
                        </a>
                    </div>
                </div>
                <?php echo $form->error($model, 'category_id'); ?>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
                <div style="clear: both;"></div>
                <div id="newsavatar" style="display: block; margin-top: 10px;">
                    <div id="newsavatar_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">  
                        <?php if ($model->image_path && $model->image_name) { ?>
                            <img src="<?php echo ClaHost::getImageHost() . $model->image_path . 's100_100/' . $model->image_name; ?>" style="width: 100%;" />
                        <?php } ?>
                    </div>
                    <div id="newsavatar_form" style="display: inline-block;">
                        <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
                    </div>
                    <?php if ($model->image_path && $model->image_name) { ?>
                        <div style="margin-top: 15px;">
                            <button type="button" onclick="removeAvatar(<?= $model->id ?>)" class="btn btn-danger btn-xs">Delete avatar</button>
                        </div>
                    <?php } ?>
                </div>
                <?php echo $form->error($model, 'avatar'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'price', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->numberField($model, 'price', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'price'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'price_market', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->numberField($model, 'price_market', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'price_market'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'price_text', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'price_text', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'price_text'); ?>
            </div>
        </div>
        <?php
        $durationTimeOptions = $timeOptions;
        if ($model->duration) {
            $durationTimeOptions = $_timeOptions = ClaService::insertWorkTimeDuration($timeOptions, array('time' => $model->duration));
        }
        //
        ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'duration', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'duration', $durationTimeOptions, array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'duration'); ?>
            </div>
        </div>
        <?php
        $padding_leftTimeOptions = $timeOptions;
        if ($model->padding_left) {
            $padding_leftTimeOptions = $_timeOptions = ClaService::insertWorkTimeDuration($timeOptions, array('time' => $model->padding_left));
        }
        //
        ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'padding_left', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'padding_left', $padding_leftTimeOptions, array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'padding_left'); ?>
            </div>
        </div>
        <?php
        $padding_rightTimeOptions = $timeOptions;
        if ($model->padding_right) {
            $padding_rightTimeOptions = $_timeOptions = ClaService::insertWorkTimeDuration($timeOptions, array('time' => $model->padding_right));
        }
        //
        ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'padding_right', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'padding_right', $padding_rightTimeOptions, array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'padding_right'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'order', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->numberField($model, 'order', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'order'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArray(), array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'status'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'ishot', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->checkBox($model, 'ishot'); ?>
                <?php echo $form->error($model, 'ishot'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($serviceInfo, 'description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($serviceInfo, 'description', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($serviceInfo, 'description'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($serviceInfo, 'sort_description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <input name="us-ck" type="checkbox" id="ck-check" value="" style="">
                <label for="ck-check" style="font-size: 12px;color: blue;pointer:cursor">Sử dụng
                    trình soạn thảo</label>
                <?php echo $form->textArea($serviceInfo, 'sort_description', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($serviceInfo, 'sort_description'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($serviceInfo, 'meta_keywords', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <label style="font-size: 12px;font-style: italic"><?php echo Yii::t('common', 'tags_description') ?></label>
                <?php echo $form->textArea($serviceInfo, 'meta_keywords', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($serviceInfo, 'meta_keywords'); ?>
            </div>
            <div style="clear: both;"><br/></div>
            <?php echo $form->labelEx($serviceInfo, 'meta_description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($serviceInfo, 'meta_description', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($serviceInfo, 'meta_description'); ?>
            </div>
            <div style="clear: both;"><br/></div>
            <?php echo $form->labelEx($serviceInfo, 'meta_title', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($serviceInfo, 'meta_title', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($serviceInfo, 'meta_title'); ?>
            </div>
        </div>

        <div class="control-group form-group buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('service', 'service_create') : Yii::t('service', 'service_edit'), array('class' => 'btn btn-info', 'id' => 'savenews')); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>

<script type="text/javascript">
    function removeAvatar(id) {
        if (confirm("Are you sure delete avatar?")) {
            $.getJSON(
                    '<?php echo Yii::app()->createUrl('service/service/deleteAvatar') ?>',
                    {id: id},
                    function (data) {
                        if (data.code == 200) {
                            $('#newsavatar_img img').remove();
                        }
                    }
            );
        }
    }
</script>