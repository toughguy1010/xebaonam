<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        CKEDITOR.replace("TourGroups_description", {
            height: 200,
            language: '<?php echo Yii::app()->language ?>'
        });
    });
</script>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'name', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>
</div>
<?php if (!$model->isNewRecord) { ?>
    <div class="form-group no-margin-left">
        <?php echo $form->labelEx($model, 'alias', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->textField($model, 'alias', array('class' => 'span10 col-sm-12')); ?>
            <?php echo $form->error($model, 'alias'); ?>
        </div>
    </div>
<?php } ?>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'description', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>
</div>
<div class=" form-group no-margin-left">
    <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
        <div id="tourgroupsavatar" style="display: block; margin-top: 0px;">
            <div id="tourgroupsavatar_img"
                 style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">
                <?php if ($model->image_path && $model->image_name) { ?>
                    <img
                            src="<?php echo ClaHost::getImageHost() . $model->image_path . 's100_100/' . $model->image_name; ?>"
                            style="width: 100%;"/>
                <?php } ?>
            </div>
            <div id="tourgroupsavatar_form" style="display: inline-block;">
                <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
            </div>
            <div style="display: inline-block;">
                <?php if ($model->image_name && $model->image_path) { ?>
                    <div style="margin-top: 15px;">
                        <button type="button" onclick="removeAvatar(<?= $model->group_id ?>)" class="btn btn-danger btn-xs">Delete avatar</button>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php echo $form->error($model, 'avatar'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'showinhome', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->checkBox($model, 'showinhome'); ?>
        <?php echo $form->error($model, 'showinhome'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArray(), array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'meta_keywords', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'meta_keywords', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'meta_keywords'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'meta_description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'meta_description', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'meta_description'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'meta_title', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'meta_title', array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'meta_title'); ?>
    </div>
</div>
<div class="form-group no-margin-left ">
    <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('tour', 'tour_group_create') : Yii::t('tour', 'tour_group_update'), array('class' => 'btn btn-primary', 'id' => 'btnAddCate')); ?>
</div>
<script type="text/javascript">
    jQuery(function ($) {
        jQuery('#tourgroupsavatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/economy/tourgroups/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#TourGroups_avatar').val(obj.data.avatar);
                        if (jQuery('#tourgroupsavatar_img img').attr('src')) {
                            jQuery('#tourgroupsavatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#tourgroupsavatar_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#tourgroupsavatar_img').css({"margin-right": "10px"});
                    }
                }
            }
        });
    });
</script>
<script type="text/javascript">
    function removeAvatar(id) {
        if (confirm("Are you sure delete avatar?")) {
            $.getJSON(
                '<?php echo Yii::app()->createUrl('economy/tourgroups/deleteAvatar') ?>',
                {id: id},
                function (data) {
                    if (data.code == 200) {
                        $('#tourgroupsavatar_img img').remove();
                    }
                }
            );
        }
    }
</script>