<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'name', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>
</div>

<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
        <div id="brandavatar" style="display: block; margin-top: 0px;">
            <div id="brandavatar_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">  
                <?php if ($model->avatar_path && $model->avatar_name) { ?>
                    <img src="<?php echo ClaHost::getImageHost() . $model->avatar_path . 's100_100/' . $model->avatar_name; ?>" style="width: 100%;" />
                <?php } ?>
            </div>
            <div id="brandavatar_form" style="display: inline-block;">
                <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'avatar'); ?>
    </div>
</div>

<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'cover', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->hiddenField($model, 'cover', array('class' => 'span12 col-sm-12')); ?>
        <div id="brandcover" style="display: block; margin-top: 0px;">
            <div id="brandcover_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->cover) echo 'margin-right: 10px;'; ?>">  
                <?php if ($model->cover_path && $model->cover_name) { ?>
                    <img src="<?php echo ClaHost::getImageHost() . $model->cover_path . 's100_100/' . $model->cover_name; ?>" style="width: 100%;" />
                <?php } ?>
            </div>
            <div id="brandcover_form" style="display: inline-block;">
                <?php echo CHtml::button(Yii::t('setting', 'btn_select_cover'), array('class' => 'btn  btn-sm')); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'cover'); ?>
    </div>
</div>

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArray(), array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>
</div>

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'order', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'order', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'order'); ?>
    </div>
</div>

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'link_site', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'link_site', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'link_site'); ?>
    </div>
</div>

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'address', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'address', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'address'); ?>
    </div>
</div>

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'phone', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'phone', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'phone'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'email', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'email', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>
</div>

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'link_facebook', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'link_facebook', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'link_facebook'); ?>
    </div>
</div>

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'link_instagram', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'link_instagram', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'link_instagram'); ?>
    </div>
</div>

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'map_iframe', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'map_iframe', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'map_iframe'); ?>
    </div>
</div>
<?php
//
$category = new ClaCategory();
$category->type = ClaCategory::CATEGORY_NEWS;
$category->generateCategory();
$arr = array('' => Yii::t('category', 'category_parent_0'));
//
$option = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $arr);
//
?>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'news_category_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'news_category_id', $option, array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'news_category_id'); ?>
    </div>
</div>

<script type="text/javascript">
    jQuery(function ($) {
        jQuery('#brandavatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/economy/brand/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#Brand_avatar').val(obj.data.avatar);
                        if (jQuery('#brandavatar_img img').attr('src')) {
                            jQuery('#brandavatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#brandavatar_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#brandavatar_img').css({"margin-right": "10px"});
                    }
                }
            }
        });

        jQuery('#brandcover_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/economy/brand/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#Brand_cover').val(obj.data.avatar);
                        if (jQuery('#brandcover_img img').attr('src')) {
                            jQuery('#brandcover_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#brandcover_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#brandcover_img').css({"margin-right": "10px"});
                    }
                }
            }
        });
    });
</script>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
<script type="text/javascript">
    var ta = true;
    jQuery(document).ready(function () {
        //
        CKEDITOR.replace("Brand_description", {
            height: 400,
            language: '<?php echo Yii::app()->language ?>'
        });
    });
    jQuery(function ($) {
    });
</script>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'description', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>
</div>