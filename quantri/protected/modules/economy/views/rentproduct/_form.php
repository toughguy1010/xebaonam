<?php
// Css
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/js/colorbox/style3/colorbox.css');
// JS
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/upload/ajaxupload.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/colorbox/jquery.colorbox-min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/upload/ajaxupload.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/effects/imagesloaded.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/effects/masonry.min.js');

// Load Cat
$category = new ClaCategory();
$category->type = ClaCategory::CATEGORY_RENT;
$category->generateCategory();
$arr = array('' => Yii::t('category', 'category_parent_0'));
$option = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $arr);
?>
<div class="widget-main">
    <div class="row">
        <div class="col-sm-12 col-xs-12 no-padding">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'rentproduct-form',
                'htmlOptions' => array('class' => 'form-horizontal'),
                'enableAjaxValidation' => false,
                'enableClientValidation' => true,
            ));
            ?>

            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active">
                        <a data-toggle="tab" href="#basicinfo">
                            <?php echo Yii::t('rent', 'basicinfo') . ' (*)'; ?>
                        </a>
                    </li>
                    <li>
                        <a data-toggle='tab' href="#rentprice">
                            Giá thuê
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#desc">
                            <?php echo Yii::t('rent', 'desc') . ' (*)'; ?>
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#seo">
                            <?php echo Yii::t('rent', 'seo'); ?>
                        </a>
                    </li>

                </ul>
                <div class="tab-content">
                    <div id="basicinfo" class="tab-pane active">
                        <?php
                        $this->renderPartial('partial/basicinfo', array(
                            'form' => $form,
                            'model' => $model,
                            'option' => $option
                        ));
                        ?>
                    </div>
                    <div id="rentprice" class='tab-pane'>
                        <?php
                        $this->renderPartial('partial/price', array(
                            'form' => $form,
                            'model' => $model,
                            'option_category' => $option
                        ));
                        ?>
                    </div>
                    <div id="desc" class="tab-pane">
                        <?php
                        $this->renderPartial('partial/description', array(
                            'form' => $form,
                            'model' => $model
                        ));
                        ?>
                    </div>
                    <div id="seo" class="tab-pane">
                        <?php
                        $this->renderPartial('partial/seo', array(
                            'form' => $form,
                            'model' => $model
                        ));
                        ?>
                    </div>
                    <div class="control-group form-group buttons">
                        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('rent', 'create') : Yii::t('rent', 'edit'), array('class' => 'btn btn-info', 'id' => 'saverentproduct')); ?>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    function removeAvatar(id) {
        if (confirm("Are you sure delete avatar?")) {
            $.getJSON(
                    '<?php echo Yii::app()->createUrl('economy/rentproduct/deleteAvatar') ?>',
                    {id: id},
                    function (data) {
                        if (data.code == 200) {
                            $('#rentproductavatar_img img').remove();
                        }
                    }
            );
        }
    }
    function removeLanguage(id) {
        if (confirm("Are you sure delete avatar?")) {
            $.getJSON(
                    '<?php echo Yii::app()->createUrl('economy/rentproduct/deleteLanguage') ?>',
                    {id: id},
                    function (data) {
                        if (data.code == 200) {
                            $('#rentproductlanguage_img img').remove();
                        }
                    }
            );
        }
    }
    jQuery(document).ready(function () {
        $("#addCate").colorbox({width: "80%", overlayClose: false});
        CKEDITOR.replace("RentProduct_description", {
            height: 400,
            language: '<?php echo Yii::app()->language ?>'
        });
        $('#ck-check').on("click", function () {
            if (this.checked) {
                CKEDITOR.replace("RentProduct_sortdesc", {
                    height: 400,
                    language: '<?php echo Yii::app()->language ?>'
                });
            } else {
                var a = CKEDITOR.instances['RentProduct_sortdesc'];
                if (a) {
                    a.destroy(true);
                }

            }
        });
    });
    //    rentproductavatar_form
    jQuery(function ($) {
        jQuery('#rentproductavatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/economy/rentproduct/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#RentProduct_avatar').val(obj.data.avatar);
                        if (jQuery('#rentproductavatar_img img').attr('src')) {
                            jQuery('#rentproductavatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#rentproductavatar_img').append('<img style="width: 100%;" src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#rentproductavatar_img').css({"margin-right": "10px"});
                        showImgInDetail();
                    }
                } else {
                    if (obj.message)
                        alert(obj.message);
                }

            }
        });
        jQuery('#rentproductlanguage_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/economy/rentproduct/uploadfilelanguage"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#RentProduct_language').val(obj.data.language);
                        if (jQuery('#rentproductlanguage_img img').attr('src')) {
                            jQuery('#rentproductlanguage_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#rentproductlanguage_img').append('<img style="width: 100%;" src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#rentproductlanguage_img').css({"margin-right": "10px"});
                        showImgInDetail();
                    }
                } else {
                    if (obj.message)
                        alert(obj.message);
                }

            }
        });
        showImgInDetail();
        function showImgInDetail() {
            setTimeout(function () {
                if (jQuery('#rentproductavatar_img img').length) {
                    jQuery('#ImgInDetail').show();
                } else {
                    jQuery('#ImgInDetail').hide();
                }
            }, 500);
        }
    });
</script>
