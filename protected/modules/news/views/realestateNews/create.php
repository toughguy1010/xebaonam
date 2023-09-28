<?php if ($user_id) { 
    $option_category = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $arr);
    ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/upload/ajaxupload.min.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            CKEDITOR.replace("RealEstateNews_description", {
                height: 400,
                language: '<?php echo Yii::app()->language ?>'
            });
        });
    </script>
    <div class="wrap_create_real_estate">
        <?php if (Yii::app()->user->hasFlash('success')): ?>
            <div class="info">
                <p class="bg-success"><?php echo Yii::app()->user->getFlash('success'); ?></p>
            </div>
        <?php endif; ?>

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'real-estate-news-form',
            'action' => Yii::app()->createUrl('news/realestateNews/create', array('id' => $form_id)),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'htmlOptions' => array('class' => 'form-horizontal w3f-form', 'role' => 'form', 'enctype' => 'multipart/form-data'),
        ));
        ?>

        <div class="form-group w3-form-group">
            <?php echo $form->label($model, 'name', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
            <div class="col-xs-10 w3-form-field">
                <?php echo $form->textField($model, 'name', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('realestate', 'title'))); ?>
                <?php echo $form->error($model, 'name'); ?>
            </div>
        </div>
        <div class="form-group w3-form-group">
            <?php echo $form->labelEx($model, 'cat_id', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
            <div class="col-xs-10 w3-form-field">
                <?php echo $form->dropDownList($model, 'cat_id', $option_category, array('class' => 'form-control w3-form-input input-text',)); ?>
                <?php echo $form->error($model, 'cat_id'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
                <div id="RealEstateNewsravatar" style="display: block; margin-top: 0px;">
                    <div id="RealEstateNewsavatar_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">  
                        <?php if ($model->image_path && $model->image_name) { ?>
                            <img src="<?php echo ClaHost::getImageHost() . $model->image_path . 's100_100/' . $model->image_name; ?>" style="width: 100%;" />
                        <?php } ?>
                    </div>
                    <div id="RealEstateNewsavatar_form" style="display: inline-block;">
                        <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
                    </div>
                </div>
                <?php echo $form->error($model, 'avatar'); ?>
            </div>
        </div>
        <div class="form-group w3-form-group">
            <?php echo $form->label($model, 'price', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
            <div class="col-xs-3 w3-form-field" style="margin-right: 10px;">
                <?php echo $form->textField($model, 'price', array('class' => 'numberFormat form-control w3-form-input input-text', 'placeholder' => Yii::t('product', 'price'))); ?>
                <?php echo $form->error($model, 'price'); ?>
            </div>
            <div class="col-xs-2 w3-form-field">
                <?php echo $form->dropDownList($model, 'unit_price', RealEstateNews::unitPrice(), array('class' => 'form-control w3-form-input input-text')); ?>
            </div>
        </div>
        <div class="form-group w3-form-group">
            <?php echo $form->label($model, 'area', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
            <div class="col-xs-3 w3-form-field" style="margin-right: 10px;">
                <?php echo $form->textField($model, 'area', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('realestate', 'area'))); ?>
                <?php echo $form->error($model, 'area'); ?>
            </div>
            <div class="col-xs-2 w3-form-field">
                <?php echo $form->dropDownList($model, 'unit_price', RealEstateNews::unitArea(), array('class' => 'form-control w3-form-input input-text')); ?>
            </div>
        </div>
        
        <div class="form-group w3-form-group">
            <?php echo $form->label($model, 'address', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
            <div class="col-xs-10 w3-form-field">
                <?php echo $form->textField($model, 'address', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('common', 'address'))); ?>
                <?php echo $form->error($model, 'address'); ?>
            </div>
        </div>
        <div class="form-group w3-form-group">
            <?php echo $form->labelEx($model, 'province_id', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
            <div class="col-xs-10 w3-form-field">
                <?php echo $form->dropDownList($model, 'province_id', $listprovince, array('class' => 'form-control w3-form-input input-text',)); ?>
                <?php echo $form->error($model, 'province_id'); ?>
            </div>
        </div>
        <div class="form-group w3-form-group">
            <?php echo $form->labelEx($model, 'district_id', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
            <div class="col-xs-10 w3-form-field">
                <?php echo $form->dropDownList($model, 'district_id', $listdistrict, array('class' => 'form-control w3-form-input input-text',)); ?>
                <?php echo $form->error($model, 'district_id'); ?>
            </div>
        </div> 
        <div class="form-group w3-form-group">
            <?php echo $form->label($model, 'description', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
            <div class="col-xs-10 w3-form-field">
                <?php echo $form->textArea($model, 'description', array('class' => 'form-control w3-form-input input-text', 'placeholder' => '')); ?>
                <?php echo $form->error($model, 'description'); ?>
            </div>
        </div>

        <div class="w3-form-group form-group">
            <div class="col-xs-2 w3-form-button"></div>
            <div class="col-xs-10 w3-form-button" style="padding: 0px;">
                <button style="width: 100px;" onclick="submit_realestate_news_form();" type="button" class="btn btn-success"><?php echo Yii::t('common', 'create'); ?></button>
            </div>
        </div>

        <?php
        $this->endWidget();
        ?>
        <script>
            function submit_realestate_news_form() {
                document.getElementById("real-estate-news-form").submit();
                return false;
            }
        </script>
    </div>
    <script type="text/javascript">

        jQuery(function ($) {
            jQuery('#RealEstateNewsavatar_form').ajaxUpload({
                url: '<?php echo Yii::app()->createUrl("/news/realestateNews/uploadfile"); ?>',
                name: 'file',
                onSubmit: function () {
                },
                onComplete: function (result) {
                    var obj = $.parseJSON(result);
                    if (obj.status == '200') {
                        if (obj.data.realurl) {
                            jQuery('#RealEstateNews_avatar').val(obj.data.avatar);
                            if (jQuery('#RealEstateNewsavatar_img img').attr('src')) {
                                jQuery('#RealEstateNewsavatar_img img').attr('src', obj.data.realurl);
                            } else {
                                jQuery('#RealEstateNewsavatar_img').append('<img src="' + obj.data.realurl + '" />');
                            }
                            jQuery('#RealEstateNewsavatar_img').css({"margin-right": "10px"});
                        }
                    }
                }
            });

        });
    </script>
    <script type="text/javascript">
        jQuery(document).on('change', '#RealEstateNews_province_id', function () {
            jQuery.ajax({
                url: '<?php echo Yii::app()->createUrl('/suggest/suggest/getdistrict') ?>',
                data: 'pid=' + jQuery('#RealEstateNews_province_id').val(),
                dataType: 'JSON',
                beforeSend: function () {
                    w3ShowLoading(jQuery('#RealEstateNews_province_id'), 'right', 20, 0);
                },
                success: function (res) {
                    if (res.code == 200) {
                        jQuery('#RealEstateNews_district_id').html(res.html);
                    }
                    w3HideLoading();
                },
                error: function () {
                    w3HideLoading();
                }
            });
        });
    </script>
<?php } else { ?>
    <div class="wrap_create_real_estate">
        <span class="do-not-login"><?php echo Yii::t('realestate', 'do_not_login'); ?></span>
    </div>
<?php } ?>