<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/category/category.css");
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
<div class="widget widget-box">
    <div class="widget-header"><h4>
            <?php echo Yii::app()->controller->action->id != "editcat" ? Yii::t('category', 'category_product_create') : Yii::t('category', 'category_product_update'); ?>
        </h4></div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'category-form',
                        'htmlOptions' => array('class' => 'form-horizontal'),
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
                            <?php echo $form->dropDownList($model, 'cat_parent', $option, array('class' => 'span10 col-sm-4')); ?>
                            <?php echo $form->error($model, 'cat_parent'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'attribute_set_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->dropDownList($model, 'attribute_set_id', array('0' => Yii::t('category', 'category_attribute_set_select')) + ProductAttributeSet::model()->getAttributeSetOptions(), array('class' => 'span10 col-sm-4')); ?>
                            <?php echo $form->error($model, 'attribute_set_id'); ?>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'cat_description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <input name="us-ck" type="checkbox" id="ck-check" value="" style="">
                            <?php echo $form->textArea($model, 'cat_description', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'cat_description'); ?>
                        </div>
                    </div>
                    <script>
                        jQuery(document).ready(function () {
                            $('#ck-check').on("click", function () {
                                if (this.checked) {
                                    CKEDITOR.replace("ProductCategories_cat_description", {
                                        height: 400,
                                        language: '<?php echo Yii::app()->language ?>'
                                    });
                                } else {
                                    var a = CKEDITOR.instances['ProductCategories_cat_description'];
                                    if (a) {
                                        a.destroy(true);
                                    }

                                }
                            });
                        });
                    </script>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
                            <div id="categoryavatar" style="display: block; margin-top: 0px;">
                                <div id="categoryavatar_img"
                                     style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">
                                    <?php if ($model->image_path && $model->image_name) { ?>
                                        <img src="<?php echo ClaHost::getImageHost(), $model->image_path, 's100_100/', $model->image_name; ?>"
                                             style="width: 100%;"/>
                                    <?php } ?>
                                </div>
                                <div id="categoryavatar_form" style="display: inline-block;">
                                    <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
                                </div>
                                <div style="display: inline-block;">
                                    <?php if ($model->image_path && $model->image_name) { ?>
                                        <button id="btn-rm-icon" type="button"
                                                onclick="removeAva(<?= $model->cat_id ?>)"
                                                class="btn btn-danger btn-xs">Delete
                                        </button>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php echo $form->error($model, 'avatar'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'icon', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->hiddenField($model, 'icon', array('class' => 'span12 col-sm-12')); ?>
                            <div id="categoryicon" style="display: block; margin-top: 0px;">
                                <div id="categoryicon_img"
                                     style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->icon) echo 'margin-right: 10px;'; ?>">
                                    <?php if ($model->icon_path && $model->icon_name) { ?>
                                        <img src="<?php echo ClaHost::getImageHost(), $model->icon_path, 's100_100/', $model->icon_name; ?>"
                                             style="width: 100%;"/>
                                    <?php } ?>
                                </div>
                                <div id="categoryicon_form" style="display: inline-block;">
                                    <?php echo CHtml::button(Yii::t('setting', 'btn_select_icon'), array('class' => 'btn  btn-sm')); ?>
                                </div>
                                <div style="display: inline-block;">
                                    <?php if ($model->icon_path && $model->icon_name) { ?>
                                        <button id="btn-rm-icon" type="button"
                                                onclick="removeIco(<?= $model->cat_id ?>)"
                                                class="btn btn-danger btn-xs">Delete
                                        </button>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php echo $form->error($model, 'icon'); ?>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'size_chart', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->hiddenField($model, 'size_chart', array('class' => 'span12 col-sm-12')); ?>
                            <div id="categorysize_chart" style="display: block; margin-top: 0px;">
                                <div id="categorysize_chart_img"
                                     style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->size_chart) echo 'margin-right: 10px;'; ?>">
                                    <?php if ($model->size_chart_path && $model->size_chart_name) { ?>
                                        <img src="<?php echo ClaHost::getImageHost(), $model->size_chart_path, 's100_100/', $model->size_chart_name; ?>"
                                             style="width: 100%;"/>
                                    <?php } ?>
                                </div>
                                <div id="categorysize_chart_form" style="display: inline-block;">
                                    <?php echo CHtml::button(Yii::t('setting', 'btn_select_size_chart'), array('class' => 'btn  btn-sm')); ?>
                                </div>
                                <div style="display: inline-block;">
                                    <?php if ($model->size_chart_path && $model->size_chart_name) { ?>
                                        <input class="btn btn-sm" type="submit" name="remove_size_chart"
                                               value="Xóa ảnh">
                                    <?php } ?>
                                </div>
                            </div>
                            <?php echo $form->error($model, 'size_chart'); ?>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'showinhome', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->checkBox($model, 'showinhome'); ?>
                            <?php echo $form->error($model, 'showinhome'); ?>
                        </div>
                    </div>
                    <?php // if (ClaUser::isSupperAdmin()) { ?>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'layout_action', array('class' => 'col-sm-2 control-label no-padding-left')); ?>

                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'layout_action', array('class' => 'span10 col-sm-12')); ?>
                            <span style="font-size: 12px;color: blue"><i>* Lưu ý: Để trống nếu bạn không biết.</i></span>
                            <?php echo $form->error($model, 'layout_action'); ?>
                        </div>
                    </div>
                    <?php // } ?>
                    <?php // if (ClaUser::isSupperAdmin()) { ?>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'view_action', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'view_action', array('class' => 'span10 col-sm-12')); ?>
                            <span style="font-size: 12px;color: blue"><i>* Lưu ý: Để trống nếu bạn không biết.</i></span>
                            <?php echo $form->error($model, 'view_action'); ?>
                        </div>
                    </div>
                    <?php // } ?>
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
<script type="text/javascript">
    function removeAva(id) {
        if (confirm("Are you sure delete icon?")) {
            $.getJSON(
                '<?php echo Yii::app()->createUrl('economy/productcategory/DeleteAvatar') ?>',
                {id: id},
                function (data) {
                    if (data.code == 200) {
                        $('#categoryavatar_img img').remove();
                        $('#btn-rm').remove();
                    }
                }
            );
        }
    }

    function removeIco(id) {
        if (confirm("Are you sure delete icon?")) {
            $.getJSON(
                '<?php echo Yii::app()->createUrl('economy/productcategory/DeleteIco') ?>',
                {id: id},
                function (data) {
                    if (data.code == 200) {
                        $('#categoryicon_img img').remove();
                        $('#btn-rm-icon').remove();
                    }
                }
            );
        }
    }
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
            'beforeSend': function () {
                w3ShowLoading(jQuery('#btnAddCate'), 'right', 60, 0);
            },
            'url': thi.attr('action'),
            'data': thi.serialize(),
            'success': function (res) {
                if (res.code != "200") {
                    if (res.errors) {
                        parseJsonErrors(res.errors);
                    }
                } else {
                    jQuery.ajax({
                        'type': 'POST',
                        'dataType': 'JSON',
                        'url': '<?php echo Yii::app()->createUrl('suggest/suggest/category', array('type' => ClaCategory::CATEGORY_PRODUCT)); ?>',
                        'success': function (res) {
                            if (res.code == '200') {
                                if (res.html)
                                    jQuery('#Product_product_category_id').html(res.html);
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
    jQuery(function ($) {
        jQuery('#categoryavatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/economy/productcategory/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#ProductCategories_avatar').val(obj.data.avatar);
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
        jQuery('#categoryicon_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/economy/productcategory/uploadfileicon"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#ProductCategories_icon').val(obj.data.icon);
                        if (jQuery('#categoryicon_img img').attr('src')) {
                            jQuery('#categoryicon_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#categoryicon_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#categoryicon_img').css({"margin-right": "10px"});
                    }
                }
            }
        });
        jQuery('#categorysize_chart_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/economy/productcategory/uploadfileSizechart"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#ProductCategories_size_chart').val(obj.data.size_chart);
                        if (jQuery('#categorysize_chart_img img').attr('src')) {
                            jQuery('#categorysize_chart_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#categorysize_chart_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#categorysize_chart_img').css({"margin-right": "10px"});
                    }
                }
            }
        });


    });


    function removeImage(type_image) {
        var url_request = "<?php echo Yii::app()->createUrl('economy/productcategory/removeImageCat') ?>";
        jQuery.getJSON(
            url_request,
            {type: type_image},
            function (data) {
                console.log(data);
            }
        );
    }


</script>