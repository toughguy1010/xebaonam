<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'name', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'slogan', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'slogan', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'slogan'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
        <div style="clear: both;"></div>
        <div id="caravatar" style="display: block; margin-top: 10px;">
            <div id="caravatar_img"
                 style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">
                     <?php if ($model->avatar_path && $model->avatar_name) { ?>
                    <img
                        src="<?php echo ClaUrl::getImageUrl($model->avatar_path, $model->avatar_name, ['width' => 100, 'height' => 100]); ?>"
                        style="width: 100%;"/>
                    <?php } ?>
            </div>
            <div id="caravatar_form" style="display: inline-block;">
                <?php echo CHtml::button(Yii::t('car', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
            </div>
            <?php if ($model->avatar_path && $model->avatar_name) { ?>
<!--                <div style="margin-top: 15px;">
                    <button type="button" onclick="removeAvatar(<?= $model->id ?>)"
                            class="btn btn-danger btn-xs">Delete avatar
                    </button>
                </div>-->
            <?php } ?>
        </div>
        <?php echo $form->error($model, 'avatar'); ?>
    </div>
</div>
<script type="text/javascript">
    jQuery(function ($) {
        jQuery('#caravatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/car/car/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#Car_avatar').val(obj.data.avatar);
                        if (jQuery('#caravatar_img img').attr('src')) {
                            jQuery('#caravatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#caravatar_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#caravatar_img').css({"margin-right": "10px"});
                    }
                } else {
                    if (obj.message)
                        alert(obj.message);
                }

            }
        });
    });
</script>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'avatar2', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->hiddenField($model, 'avatar2', array('class' => 'span12 col-sm-12')); ?>
        <div style="clear: both;"></div>
        <div id="caravatar2" style="display: block; margin-top: 10px;">
            <div id="caravatar2_img"
                 style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar2) echo 'margin-right: 10px;'; ?>">
                     <?php if ($model->avatar2_path && $model->avatar2_name) { ?>
                    <img
                        src="<?php echo ClaUrl::getImageUrl($model->avatar2_path, $model->avatar2_name, ['width' => 100, 'height' => 100]); ?>"
                        style="width: 100%;"/>
                    <?php } ?>
            </div>
            <div id="caravatar2_form" style="display: inline-block;">
                <?php echo CHtml::button(Yii::t('car', 'btn_select_avatar2'), array('class' => 'btn  btn-sm')); ?>
            </div>
            <?php if ($model->avatar2_path && $model->avatar2_name) { ?>
<!--                <div style="margin-top: 15px;">
                    <button type="button" onclick="removeAvatar(<?= $model->id ?>)"
                            class="btn btn-danger btn-xs">Delete avatar2
                    </button>
                </div>-->
            <?php } ?>
        </div>
        <?php echo $form->error($model, 'avatar2'); ?>
    </div>
</div>
<script type="text/javascript">
    jQuery(function ($) {
        jQuery('#caravatar2_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/car/car/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#Car_avatar2').val(obj.data.avatar);
                        if (jQuery('#caravatar2_img img').attr('src')) {
                            jQuery('#caravatar2_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#caravatar2_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#caravatar2_img').css({"margin-right": "10px"});
                    }
                } else {
                    if (obj.message)
                        alert(obj.message);
                }

            }
        });
    });
</script>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'cover', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->hiddenField($model, 'cover', array('class' => 'span12 col-sm-12')); ?>
        <div style="clear: both;"></div>
        <div id="carcover" style="display: block; margin-top: 10px;">
            <div id="carcover_img"
                 style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->cover) echo 'margin-right: 10px;'; ?>">
                     <?php if ($model->cover_path && $model->cover_name) { ?>
                    <img
                        src="<?php echo ClaUrl::getImageUrl($model->cover_path, $model->cover_name, ['width' => 100, 'height' => 100]); ?>"
                        style="width: 100%;"/>
                    <?php } ?>
            </div>
            <div id="carcover_form" style="display: inline-block;">
                <?php echo CHtml::button(Yii::t('car', 'btn_select_cover'), array('class' => 'btn  btn-sm')); ?>
            </div>
            <?php if ($model->cover_path && $model->cover_name) { ?>
<!--                <div style="margin-top: 15px;">
                    <button type="button" onclick="removeAvatar(<?= $model->id ?>)"
                            class="btn btn-danger btn-xs">Delete cover
                    </button>
                </div>-->
            <?php } ?>
        </div>
        <?php echo $form->error($model, 'cover'); ?>
    </div>
</div>
<script type="text/javascript">
    jQuery(function ($) {
        jQuery('#carcover_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/car/car/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#Car_cover').val(obj.data.avatar);
                        if (jQuery('#carcover_img img').attr('src')) {
                            jQuery('#carcover_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#carcover_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#carcover_img').css({"margin-right": "10px"});
                    }
                } else {
                    if (obj.message)
                        alert(obj.message);
                }

            }
        });
    });
</script>
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
    <?php echo $form->labelEx($model, 'code', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'code', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'code'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'car_category_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <div class="input-group">
            <?php echo $form->dropDownList($model, 'car_category_id', $option, array('class' => 'form-control')); ?>
            <div class="input-group-btn" style="padding-left: 10px;">  
                <a href="<?php echo Yii::app()->createUrl('car/carcategories/addcat', array('pa' => ClaCategory::CATEGORY_ROOT) + $_GET) ?>" id="addCate" class="btn btn-primary btn-sm" style="line-height: 14px;">
                    <?php echo Yii::t('category', 'category_add'); ?>
                </a>
            </div>
        </div>
        <?php echo $form->error($model, 'car_category_id'); ?>
    </div>
</div>
<!--<div class="form-group no-margin-left">
<?php // echo $form->labelEx($model, 'include_vat', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">                            
<?php // echo $form->checkBox($model, 'include_vat'); ?>
        <span class="lbl" style="padding:0px 5px 4px 5px; color: #999; font-size: 12px; font-style: italic;"><?php echo Yii::t('product', 'product_include_vat_help') ?></span>
<?php // echo $form->error($model, 'include_vat'); ?>
    </div>
</div>-->
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'allow_try_drive', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">                            
        <?php echo $form->checkBox($model, 'allow_try_drive'); ?>
        <?php echo $form->error($model, 'allow_try_drive'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'isnew', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">                            
        <?php echo $form->checkBox($model, 'isnew'); ?>
        <?php echo $form->error($model, 'isnew'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'ishot', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">                            
        <?php echo $form->checkBox($model, 'ishot'); ?>
        <?php echo $form->error($model, 'ishot'); ?>
    </div>
</div>
<!--<div class="form-group no-margin-left">
<?php // echo $form->labelEx($model, 'quantity', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
<?php // echo $form->textField($model, 'quantity', array('class' => 'span12 col-sm-12', 'placeholder' => Yii::t('product', 'product_quantity_placeholder'))); ?>
<?php // echo $form->error($model, 'quantity'); ?>
    </div>
</div>-->
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'fuel', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'fuel', Car::optionFuel(), array('class' => 'span12 col-sm-12', 'prompt' => '--- Chọn ---')); ?>
        <?php echo $form->error($model, 'fuel'); ?>
    </div>
</div>

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'seat', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'seat', Car::optionSeat(), array('class' => 'span12 col-sm-12', 'prompt' => '--- Chọn ---')); ?>
        <?php echo $form->error($model, 'seat'); ?>
    </div>
</div>

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'style', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'style', Car::optionStyle(), array('class' => 'span12 col-sm-12', 'prompt' => '--- Chọn ---')); ?>
        <?php echo $form->error($model, 'style'); ?>
    </div>
</div>

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'madein', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'madein', Car::optionMadein(), array('class' => 'span12 col-sm-12', 'prompt' => '--- Chọn ---')); ?>
        <?php echo $form->error($model, 'madein'); ?>
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
    <?php echo $form->labelEx($model, 'position', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'position', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'position'); ?>
    </div>
</div>

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'sortdesc', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'sortdesc', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'sortdesc'); ?>
    </div>
</div>