<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'name', array('class' => 'span12 col-sm-10')); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'code', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'code', array('class' => 'span12 col-sm-10')); ?>
        <?php echo $form->error($model, 'code'); ?>
    </div>
</div>
<?php
$attSetpoptions = ProductAttributeSet::getAttributeSetOptions();
?>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'attribute_set_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'attribute_set_id', array('' => Yii::t('attribute', 'attribute_att_set_select')) + $attSetpoptions, array('class' => 'span12 col-sm-3')); ?>
        <?php echo $form->error($model, 'attribute_set_id'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->label($model, 'frontend_input', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'frontend_input', ProductAttribute::$_dataTypeInput, array('class' => 'span12 col-sm-3')); ?>
        <?php echo $form->error($model, 'frontend_input'); ?>
    </div>
</div>
<?php if ($model->frontend_input == 'textarea') { ?>
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'is_editor', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->checkBox($model, 'is_editor'); ?>
            <?php echo $form->error($model, 'is_editor'); ?>
        </div>
    </div>
<?php } ?>
<div class="control-group form-group">
    <?php echo $form->label($model, 'type_option', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'type_option', ProductAttribute::$_dataTypeOption, array('class' => 'span12 col-sm-3')); ?>
        <?php echo $form->error($model, 'type_option'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'default_value', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'default_value', array('class' => 'span12 col-sm-10')); ?>
        <?php echo $form->error($model, 'default_value'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'sort_order', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'sort_order', array('class' => 'span2 col-sm-1 ')); ?>
        <?php echo $form->error($model, 'sort_order', array('class' => 'errorMessage')); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'is_configurable', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->checkBox($model, 'is_configurable'); ?>
        <?php echo $form->error($model, 'is_configurable'); ?>
        <span class="hint" style="font-size:11px;color:#d19d59;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Chỉ "Màu sắc" và "Kích cỡ" nên tick (Nhớ chọn loại "Lựa chọn nhiều giá trị")</span>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'is_filterable', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->checkBox($model, 'is_filterable'); ?>
        <?php echo $form->error($model, 'is_filterable'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'is_frontend', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->checkBox($model, 'is_frontend'); ?>
        <?php echo $form->error($model, 'is_frontend'); ?>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'is_children_option', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->checkBox($model, 'is_children_option'); ?>
        <?php echo $form->error($model, 'is_children_option'); ?>
        <span class="hint" style="font-size:11px;color:#d19d59;">&nbsp;&nbsp;&nbsp;VD: CPU máy tính nên chọn (thông số kỹ thuật khác với giá trị filter)</span>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'is_system', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->checkBox($model, 'is_system'); ?>
        <?php echo $form->error($model, 'is_system'); ?>
        <span class="hint" style="font-size:11px;color:#d19d59;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Thuộc tính sẽ áp cho toàn bộ các nhóm - hạn chế dùng</span>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'is_change_price', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->checkBox($model, 'is_change_price'); ?>
        <?php echo $form->error($model, 'is_change_price'); ?>
        <span class="hint" style="font-size:11px;color:#d19d59;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Hiện tại chỉ hỗ trợ loại thuộc tính "Lựa chọn một giá trị"</span>
    </div>
</div>
<!---->
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
        <div style="clear: both;"></div>
        <div id="productattributeavatar" style="display: block; margin-top: 10px;">
            <div id="productattributeavatar_img"
                 style="position: relative; display: inline-block; max-width: 150px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">
                <?php if ($model->avatar_path && $model->avatar_name) { ?>
                    <img
                            src="<?php echo ClaHost::getImageHost() . $model->avatar_path . 's150_150/' . $model->avatar_name; ?>"
                            style="width: 100%;"/>
                <?php } ?>
            </div>
            <div id="productattributeavatar_form" style="display: inline-block;">
                <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
            </div>
            <?php if ($model->avatar_path && $model->avatar_name) { ?>
                <div style="margin-top: 15px;">
                    <button type="button" onclick="removeAvatar(<?= $model->id ?>)"
                            class="btn btn-danger btn-xs">Delete avatar
                    </button>
                </div>
            <?php } ?>
        </div>
        <?php echo $form->error($model, 'avatar'); ?>
    </div>
</div>
<!---->
<script>
    jQuery(function () {
        if (jQuery('#ProductAttribute_is_system').is(":checked")) {
            jQuery('#ProductAttribute_attribute_set_id').attr('disabled', 'disabled');
        } else {
            jQuery('#ProductAttribute_attribute_set_id').removeAttr('disabled');
        }
        jQuery('#ProductAttribute_is_system').click(function () {
            if (jQuery(this).is(":checked")) {
                jQuery('#ProductAttribute_attribute_set_id').attr('disabled', 'disabled');
            } else {
                jQuery('#ProductAttribute_attribute_set_id').removeAttr('disabled');
            }
        });

        jQuery('#ProductAttribute_is_change_price').click(function () {
            if (jQuery('#ProductAttribute_is_configurable').is(":checked")) {
                alert("Không thể vừa là thuộc tính đăng hoán vị vừa là thuộc tính thay đổi giá sp");
                return false;
            } else {
//                if (jQuery('#ProductAttribute_is_change_price').is(":checked")) {
//                    jQuery('#ProductAttribute_type_option').val(3) // chang price
//                    jQuery('#att_options .ext-value').html("Giá (+/-) thêm vào giá sp (VNĐ)");
//                        
//                }else{
//                    jQuery('#ProductAttribute_type_option').val(0) // chang price
//                    jQuery('#att_options .ext-value').html("Mở rộng")
//                }
            }
        });

        jQuery('#ProductAttribute_is_configurable').click(function () {
            if (jQuery('#ProductAttribute_is_change_price').is(":checked")) {
                alert("Không thể vừa là thuộc tính đăng hoán vị vừa là thuộc tính thay đổi giá sp");
                return false;
            }

        });
        //
        jQuery(function ($) {
            jQuery('#productattributeavatar_form').ajaxUpload({
                url: '<?php echo Yii::app()->createUrl("/content/news/uploadfile"); ?>',
                name: 'file',
                onSubmit: function () {
                },
                onComplete: function (result) {
                    var obj = $.parseJSON(result);
                    if (obj.status == '200') {
                        if (obj.data.realurl) {
                            jQuery('#ProductAttribute_avatar').val(obj.data.avatar);
                            if (jQuery('#productattributeavatar_img img').attr('src')) {
                                jQuery('#productattributeavatar_img img').attr('src', obj.data.realurl);
                            } else {
                                jQuery('#productattributeavatar_img').append('<img style="width: 100%;" src="' + obj.data.realurl + '" />');
                            }
                            jQuery('#productattributeavatar_img').css({"margin-right": "10px"});
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
                    if (jQuery('#productattributeavatar_img img').length) {
                        jQuery('#ImgInDetail').show();
                    } else {
                        jQuery('#ImgInDetail').hide();
                    }
                }, 500);
            }
        });
    });

</script>
<script type="text/javascript">
    function removeAvatar(id) {
        if (confirm("Are you sure delete avatar?")) {
            $.getJSON(
                '<?php echo Yii::app()->createUrl('economy/productAttribute/deleteAvatar') ?>',
                {id: id},
                function (data) {
                    if (data.code == 200) {
                        $('#productattributeavatar_img img').remove();
                    }
                }
            );
        }
    }
</script>