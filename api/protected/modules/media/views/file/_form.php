<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js'); ?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<script type="text/javascript">
    var ta = true;
    jQuery(document).ready(function () {
        //
        CKEDITOR.replace("Files_description", {
            height: 400,
            language: '<?php echo Yii::app()->language ?>'
        });
    });
    jQuery(function ($) {
    });
    jQuery(function ($) {
        jQuery('#fileavatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/media/file/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#Files_avatar').val(obj.data.avatar);
                        if (jQuery('#fileavatar_img img').attr('src')) {
                            jQuery('#fileavatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#fileavatar_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#fileavatar_img').css({"margin-right": "10px"});
                    }
                } else {
                    if (obj.message)
                        alert(obj.message);
                }

            }
        });
    });
</script>
<div class="row">
    <div class="col-xs-12 no-padding">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'files-form',
            'htmlOptions' => array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
        ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'folder_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <div class="input-group">
                    <?php echo $form->dropDownList($model, 'folder_id', Folders::getFolderOptionsArr(), array('class' => 'form-control')); ?>
                    <div class="input-group-btn" style="padding-left: 10px;">  
                        <a href="<?php echo Yii::app()->createUrl('media/folder/create');?>" id="addCate" class="btn btn-primary btn-sm" style="line-height: 14px;">
                            <?php echo Yii::t('file', 'folder_add'); ?>
                        </a>
                    </div>
                </div>
                <?php echo $form->error($model, 'folder_id'); ?>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'display_name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'display_name', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'display_name'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
                <div style="clear: both;"></div>
                <div id="fileavatar" style="display: block; margin-top: 10px;">
                    <div id="fileavatar_img"
                         style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">
                        <?php if ($model->image_path && $model->image_name) { ?>
                            <img
                                    src="<?php echo ClaUrl::getImageUrl($model->image_path, $model->image_name, ['width' => 100, 'height' => 100]); ?>"
                                    style="width: 100%;"/>
                        <?php } ?>
                    </div>
                    <div id="fileavatar_form" style="display: inline-block;">
                        <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
                    </div>
                    <?php if ($model->image_path && $model->image_name) { ?>
                        <div style="margin-top: 15px;">
                            <button type="button" onclick="removeAvatar('<?= $model->id ?>')"
                                    class="btn btn-danger btn-xs">Delete avatar
                            </button>
                        </div>
                    <?php } ?>
                </div>
                <?php echo $form->error($model, 'avatar'); ?>
            </div>
        </div>
        <?php if ($model->isNewRecord) { ?>
            <div class="control-group form-group">
                <?php echo $form->labelEx($model, 'file_src', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                <div class="controls col-sm-10">
                    <?php echo $form->hiddenField($model, 'file_src', array('class' => 'span12 col-sm-12')); ?>
                    <div class="row" style="margin: 10px 0px;">
                        <?php echo CHtml::fileField('file_src', ''); ?>
                    </div>
                    <?php echo $form->error($model, 'file_src'); ?>
                </div>
            </div>
        <?php } ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'description', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'description'); ?>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'publicdate_time', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php
                $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                    'model' => $model, //Model object
                    'name' => 'Files[publicdate_time]', //attribute name
                    'mode' => 'datetime', //use "time","date" or "datetime" (default)
                    'value' => ((int)$model->publicdate_time > 0) ? date('d-m-Y H:i:s', (int)$model->publicdate_time) : date('d-m-Y H:i:s'),
                    'language' => 'vi',
                    'options' => array(
                        'showSecond' => true,
                        'dateFormat' => 'dd-mm-yy',
                        'timeFormat' => 'HH:mm:ss',
                        'controlType' => 'select',
                        'stepHour' => 1,
                        'stepMinute' => 1,
                        'stepSecond' => 1,
                        //'showOn' => 'button',
                        'showSecond' => true,
                        'changeMonth' => true,
                        'changeYear' => false,
                        'tabularLevel' => null,
                        //'addSliderAccess' => true,
                        //'sliderAccessArgs' => array('touchonly' => false),
                    ), // jquery plugin options
                    'htmlOptions' => array(
                        'class' => 'span12 col-sm-12',
                    )
                ));
                ?>
                <?php echo $form->error($model, 'publicdate_time'); ?>
            </div>
        </div>

        <div class="control-group form-group buttons" style="border-bottom: none;">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('file', 'file_create') : Yii::t('file', 'file_edit'), array('class' => 'btn btn-info', 'id' => 'savebanner')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div><!-- form -->
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/style3/colorbox.css"></link>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/jquery.colorbox-min.js"></script>
<script type="text/javascript">
    $("#addCate").colorbox({width: "80%", overlayClose: false});

    function removeAvatar(id) {
        if (confirm("Are you sure delete avatar?")) {
            $.getJSON(
                '<?php echo Yii::app()->createUrl('/media/file/deleteAvatar') ?>',
                {id: id},
                function (data) {
                    if (data.code == 200) {
                        $('#fileavatar_img img').remove();
                    }
                }
            );
        }
    }
</script>