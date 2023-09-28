<?php if (!$isAjax) { ?>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<?php } ?>
<div class="widget widget-box">
    <div class="widget-header"><h4>
            <?php echo Yii::app()->controller->action->id != "editcat" ? Yii::t('category', 'category_news_create') : Yii::t('category', 'category_news_update'); ?>
        </h4></div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'category-form',
                        'htmlOptions' => array('class' => 'form-horizontal'),
                        'enableClientValidation' => true,
                        'enableAjaxValidation' => false,
                    ));
                    ?>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'cat_name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'cat_name', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'cat_name'); ?>
                        </div>
                    </div>
                    <?php // if (!$model->isNewRecord) { ?>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'alias', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'alias', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'alias'); ?>
                        </div>
                    </div>
                    <?php // } ?>

                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'cat_parent', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->dropDownList($model, 'cat_parent', $option, array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'cat_parent'); ?>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'cat_description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <input name="us-ck" type="checkbox" id="ck-check" value="" style="">
                            <label for="ck-check" style="font-size: 11px;color: blue;font-weight: bold">Sử dụng trình soạn thảo</label>
                            <?php echo $form->textArea($model, 'cat_description', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'cat_description'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
                            <div id="categoryavatar" style="display: block; margin-top: 0px;">
                                <div id="categoryavatar_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">  
                                    <?php if ($model->image_path && $model->image_name) { ?>
                                        <img src="<?php echo ClaHost::getImageHost() . $model->image_path . 's100_100/' . $model->image_name; ?>" style="width: 100%;" />
                                    <?php } ?>
                                </div>
                                <div id="categoryavatar_form" style="display: inline-block;">
                                    <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
                                </div>
                                 <div style="display: inline-block;">
                                     <?php if ($model->image_path && $model->image_name) { ?>
                                          <input class="btn btn-sm" type="submit" name="remove_avatar" value="Xóa ảnh">
                                     <?php } ?>
                                 </div>
                            </div>
                            <?php echo $form->error($model, 'avatar'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'cover', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->hiddenField($model, 'cover', array('class' => 'span12 col-sm-12')); ?>
                            <div id="categorycover" style="display: block; margin-top: 0px;">
                                <div id="categorycover_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->cover) echo 'margin-right: 10px;'; ?>">
                                    <?php if ($model->cover_path && $model->cover_name) { ?>
                                        <img src="<?php echo ClaHost::getImageHost() . $model->cover_path . 's100_100/' . $model->cover_name; ?>" style="width: 100%;" />
                                    <?php } ?>
                                </div>
                                <div id="categorycover_form" style="display: inline-block;">
                                    <?php echo CHtml::button(Yii::t('setting', 'btn_select_cover'), array('class' => 'btn  btn-sm')); ?>
                                </div>
                                 <div style="display: inline-block;">
                                     <?php if ($model->cover_path && $model->cover_name) { ?>
                                          <input class="btn btn-sm" type="submit" name="remove_cover" value="Xóa ảnh">
                                     <?php } ?>
                                 </div>
                            </div>
                            <?php echo $form->error($model, 'cover'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'showinhome', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->checkBox($model, 'showinhome'); ?>
                            <?php echo $form->error($model, 'showinhome'); ?>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'meta_keywords', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textArea($model, 'meta_keywords', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'meta_keywords'); ?>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'meta_description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textArea($model, 'meta_description', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'meta_description'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'meta_title', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textArea($model, 'meta_title', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'meta_title'); ?>
                        </div>
                    </div>
                    <?php if (ClaUser::isSupperAdmin()) { ?>
                        <div class="control-group form-group">
                            <?php echo $form->labelEx($model, 'layout_action', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                            <div class="controls col-sm-10">
                                <?php echo $form->textField($model, 'layout_action', array('class' => 'span10 col-sm-12')); ?>
                                <?php echo $form->error($model, 'layout_action'); ?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (ClaUser::isSupperAdmin()) { ?>
                        <div class="control-group form-group">
                            <?php echo $form->labelEx($model, 'view_action', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                            <div class="controls col-sm-10">
                                <?php echo $form->textField($model, 'view_action', array('class' => 'span10 col-sm-12')); ?>
                                <?php echo $form->error($model, 'view_action'); ?>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArray(), array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'status'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group buttons">
                        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('category', 'category_create') : Yii::t('category', 'category_save'), array('class' => 'btn btn-primary', 'id' => 'btnAddCate')); ?>
                    </div>
                    <?php
                    $this->endWidget();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js?ver=' . VERSION); ?>
<script type="text/javascript">
    jQuery(function ($) {
        $('#ck-check').on("click", function () {
            if (this.checked) {
                CKEDITOR.replace("NewsCategories_cat_description", {
                    height: 300,
                    language: '<?php echo Yii::app()->language ?>'
                });
            } else {
                var a = CKEDITOR.instances['NewsCategories_cat_description'];
                if (a) {
                    a.destroy(true);
                }

            }
        });
<?php if ($isAjax) { ?>
            var formSubmit = true;
            jQuery('#category-form').on('submit', function () {
                if (!formSubmit)
                    return false;
                formSubmit = false;
                var thi = jQuery(this);
                jQuery.ajax({
                    'type': 'POST',
                    'dataType': 'JSON',
                    'url': thi.attr('action'),
                    'data': thi.serialize(),
                    'beforeSend': function () {
                        w3ShowLoading(jQuery('#btnAddCate'), 'right', 60, 0);
                    },
                    'success': function (res) {
                        if (res.code != "200") {
                            if (res.errors) {
                                parseJsonErrors(res.errors);
                            }
                        } else {
                            jQuery.ajax({
                                'type': 'POST',
                                'dataType': 'JSON',
                                'url': '<?php echo Yii::app()->createUrl('suggest/suggest/category', array('type' => ClaCategory::CATEGORY_NEWS)); ?>',
                                'success': function (res) {
                                    if (res.code == '200') {
                                        if (res.html)
                                            jQuery('#News_news_category_id').html(res.html);
                                        jQuery.colorbox.close();
                                    }
                                }
                            });
                        }
                        w3HideLoading();
                        formSubmit = true;
                    },
                    'error': function () {
                        w3HideLoading();
                        formSubmit = true;
                    }
                });
                return false;
            });
<?php } ?>
        //
        jQuery('#categoryavatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/content/newscategory/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#NewsCategories_avatar').val(obj.data.avatar);
                        if (jQuery('#categoryavatar_img img').attr('src')) {
                            jQuery('#categoryavatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#categoryavatar_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#categoryavatar_img').css({"margin-right": "10px"});
                    }
                }
            }
        });
        jQuery('#categorycover_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/content/newscategory/uploadCoverfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#NewsCategories_cover').val(obj.data.cover);
                        if (jQuery('#categorycover_img img').attr('src')) {
                            jQuery('#categorycover_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#categorycover_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#categorycover_img').css({"margin-right": "10px"});
                    }
                }
            }
        });
    });
</script>