<?php
Yii::app()->clientScript->registerScript('sitesettings', "
    jQuery('#sitelogo_img').css({\"margin-right\":\"10px\"});
    jQuery('#sitelogo_form').ajaxUpload({
        url : '" . Yii::app()->createUrl("/setting/setting/uploadfile") . "',
        name: 'file',
        onSubmit: function() {
                //$('#loader-shopping').show();                     
        },
        onComplete: function(result) {
            var obj = $.parseJSON(result);
            if(obj.status == '200') {
                if(obj.data.realurl){
                    jQuery('#SiteSettings_site_logo').val(obj.data.realurl);
                    if(jQuery('#sitelogo_img img').attr('src')){
                        jQuery('#sitelogo_img img').attr('src',obj.data.realurl);
                    }else{
                        jQuery('#sitelogo_img').append('<img src=\"'+obj.data.realurl+'\" />');
                    }
                    jQuery('#sitelogo_img').css({\"margin-right\":\"10px\"});
                }
            }
        }
    });
    jQuery('#sitewater_form').ajaxUpload({
        url : '" . Yii::app()->createUrl("/setting/setting/uploadfilewater") . "',
        name: 'file',
        onSubmit: function() {
                //$('#loader-shopping').show();                     
        },
        onComplete: function(result) {
            var obj = $.parseJSON(result);
            if(obj.status == '200') {
                if(obj.data.realurl){
                    jQuery('#SiteSettings_site_watermark').val(obj.data.realurl);
                    if(jQuery('#sitewater_img img').attr('src')){
                        jQuery('#sitewater_img img').attr('src',obj.data.realurl);
                    }else{
                        jQuery('#sitewater_img').append('<img src=\"'+obj.data.realurl+'\" />');
                    }
                    jQuery('#sitewater_img').css({\"margin-right\":\"10px\"});
                }
            }
        }
    });
    
    jQuery('#sitefavicon_form').ajaxUpload({
        url : '" . Yii::app()->createUrl("/setting/setting/uploadfavicon") . "',
        name: 'file',
        onSubmit: function() {
                //$('#loader-shopping').show();                     
        },
        onComplete: function(result) {
            var obj = $.parseJSON(result);
            if(obj.status == '200') {
                if(obj.data.realurl){
                    jQuery('#SiteSettings_favicon').val(obj.data.realurl);
                    if(jQuery('#sitefavicon_img img').attr('src')){
                        jQuery('#sitefavicon_img img').attr('src',obj.data.realurl);
                    }else{
                        jQuery('#sitefavicon_img').append('<img src=\"'+obj.data.realurl+'\" />');
                    }
                    jQuery('#sitefavicon_img').css({\"margin-right\":\"10px\"});
                }
            }
        }
    });

");
?>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'site_title', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'site_title', array('class' => 'span9 col-sm-12')); ?>
        <span class="help-inline">
            <?php echo $form->error($model, 'site_title'); ?>
        </span>
    </div>
</div>

<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'title_call', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'title_call', array('class' => 'span9 col-sm-12')); ?>
        <span class="help-inline">
            <?php echo $form->error($model, 'title_call'); ?>
        </span>
    </div>
</div>

<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'site_logo', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->hiddenField($model, 'site_logo', array('class' => 'span9 col-sm-12')); ?>
        <div style="clear: both;"></div>
        <div id="sitelogo" style="display: block; margin-top: 10px;">
            <div id="sitelogo_img" style="display: inline-block; max-width: 100px; overflow: hidden; vertical-align: top; <?php if ($model->site_logo) echo 'margin-right: 10px;'; ?>">  
                <?php if ($model->site_logo) { ?>
                    <img src="<?php echo $model->site_logo; ?>" style="width: 100%;" />
                <?php } ?>
            </div>
            <div id="sitelogo_form" style="display: inline-block;">
                <?php echo CHtml::button(Yii::t('setting', 'btn_select_logo'), array('class' => 'btn  btn-sm')); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'site_logo'); ?>
    </div>
</div>

<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'favicon', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->hiddenField($model, 'favicon', array('class' => 'span9 col-sm-12')); ?>
        <div style="clear: both;"></div>
        <div id="sitefavicon" style="display: block; margin-top: 10px;">
            <div id="sitefavicon_img" style="display: inline-block; max-width: 100px; overflow: hidden; vertical-align: top; <?php if ($model->favicon) echo 'margin-right: 10px;'; ?>">  
                <?php if ($model->favicon) { ?>
                    <img src="<?php echo $model->favicon; ?>" style="width: 100%;" />
                <?php } ?>
            </div>
            <div id="sitefavicon_form" style="display: inline-block;">
                <?php echo CHtml::button(Yii::t('setting', 'btn_select_favicon'), array('class' => 'btn  btn-sm')); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'favicon'); ?>
    </div>
</div>

<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
        <div style="clear: both;"></div>
        <div id="siteavatar" style="display: block; margin-top: 10px;">
            <div id="siteavatar_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">  
                <?php if ($model->avatar_path && $model->avatar_name) { ?>
                    <img src="<?php echo ClaHost::getImageHost() . $model->avatar_path . 's100_100/' . $model->avatar_name; ?>" style="width: 100%;" />
                <?php } ?>
            </div>
            <div id="siteavatar_form" style="display: inline-block;">
                <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'avatar'); ?>
    </div>
</div>

<!--<div class="control-group form-group">-->
<!--    --><?php //echo $form->labelEx($model, 'site_watermark', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
<!--    <div class="controls col-sm-10">-->
<!--        --><?php //echo $form->hiddenField($model, 'site_watermark', array('class' => 'span9 col-sm-12')); ?>
<!--        <div style="clear: both;"></div>-->
<!--        <div id="sitewater" style="display: block; margin-top: 10px;">-->
<!--            <div id="sitewater_img" style="    float: left;display: inline-block; max-width: 100px; overflow: hidden; vertical-align: top; --><?php //if ($model->site_logo) echo 'margin-right: 10px;'; ?><!--">-->
<!--                --><?php //if ($model->site_watermark) { ?>
<!--                    <img src="--><?php //echo $model->site_watermark; ?><!--" style="width: 100%;" />-->
<!--                --><?php //} ?>
<!--            </div>-->
<!--            <div id="sitewater_form" style="display: inline-block;">-->
<!--                --><?php //echo CHtml::button(Yii::t('setting', 'btn_select_water_mark'), array('class' => 'btn  btn-sm')); ?>
<!--            </div>-->
<!--        </div>-->
<!--        --><?php //echo $form->error($model, 'site_watermark'); ?>
<!--    </div>-->
<!--</div>-->

<?php if (ClaUser::isSupperAdmin()) { ?>
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'site_skin', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->textField($model, 'site_skin', array('class' => 'span9 col-sm-12')); ?>
            <span class="help-inline">
                <?php echo $form->error($model, 'site_skin'); ?>
            </span>
        </div>
    </div>
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'language', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->dropDownList($model, 'language', array('' => '') + ClaSite::getLanguageSupport(), array('class' => 'span9 col-sm-12')); ?>
            <span class="help-inline">
                <?php echo $form->error($model, 'language'); ?>
            </span>
        </div>
    </div>
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'admin_language', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->dropDownList($model, 'admin_language', array('' => '') + ClaSite::getLanguageSupport(), array('class' => 'span9 col-sm-12')); ?>
            <span class="help-inline">
                <?php echo $form->error($model, 'admin_language'); ?>
            </span>
        </div>
    </div>
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'languages_for_site', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php
            $selected = array();
            if (!$model->isNewRecord) {
                $languages_for_sites = $model->getLanguageForSite();
                foreach ($languages_for_sites as $key => $languages_for_site)
                    $selected[$key] = array('selected' => 'selected');
            }
            $this->widget('common.extensions.echosen.Chosen', array(
                'model' => $model,
                'attribute' => 'languages_for_site',
                'multiple' => true,
                'placeholderMultiple' => $model->getAttributeLabel('languages_for_site'),
                'data' => ClaSite::getLanguageSupport(),
                'htmlOptions' => array(
                    'class' => 'span12 col-sm-12',
                    'options' => $selected,
                ),
            ));
            ?>
            <?php echo $form->error($model, 'languages_for_site'); ?>
        </div>
    </div>
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'pagesize', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->textField($model, 'pagesize', array('class' => 'span9 col-sm-12')); ?>
            <span class="help-inline">
                <?php echo $form->error($model, 'pagesize'); ?>
            </span>
        </div>
    </div>
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'admin_default', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->dropDownList($model, 'admin_default', ClaSite::getAdminDefaultOptions(), array('class' => 'span9 col-sm-12')); ?>
            <span class="help-inline">
                <?php echo $form->error($model, 'admin_default'); ?>
            </span>
        </div>
    </div>
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->dropDownList($model, 'status', $model->getStatusArr(), array('class' => 'span9 col-sm-12')); ?>
            <span class="help-inline">
                <?php echo $form->error($model, 'status'); ?>
            </span>
        </div>
    </div>
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'site_type', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->dropDownList($model, 'site_type', ClaSite::getSiteTypes(), array('class' => 'span9 col-sm-12')); ?>
            <span class="help-inline">
                <?php echo $form->error($model, 'site_type'); ?>
            </span>
        </div>
    </div>
<?php } ?>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'admin_email', array('class' => 'col-sm-2 control-label no-padding-left')); ?>

    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'admin_email', array('class' => 'span9 col-sm-12')); ?>
        <span class="help-inline">
            (Hỗ trợ tối đa 3 email, cách nhau bởi dấu ",")
            <?php echo $form->error($model, 'admin_email'); ?>
        </span>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'admin_phone', array('class' => 'col-sm-2 control-label no-padding-left')); ?>

    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'admin_phone', array('class' => 'span9 col-sm-12')); ?>
        <span class="help-inline">
            (Chỉ hiển thị trong admin. Hỗ trợ tối đa 3 email, cách nhau bởi dấu ",")
            <?php echo $form->error($model, 'admin_phone'); ?>
        </span>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'phone', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'phone', array('class' => 'span9 col-sm-12')); ?>
        <span class="help-inline">
            (Có thể đươc hiển thị ngoài frontend. Hỗ trợ tối đa 3 số điện thoại, Cách nhau bởi dấu ",")
            <?php echo $form->error($model, 'phone'); ?>
        </span>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'phone_sell', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'phone_sell', array('class' => 'span9 col-sm-12')); ?>
        <span class="help-inline">
            <?php echo $form->error($model, 'phone_sell'); ?>
        </span>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'phone_callback', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'phone_callback', array('class' => 'span9 col-sm-12')); ?>
        <span class="help-inline">
            <?php echo $form->error($model, 'phone_callback'); ?>
        </span>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'phone_safe', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'phone_safe', array('class' => 'span9 col-sm-12')); ?>
        <span class="help-inline">
            <?php echo $form->error($model, 'phone_safe'); ?>
        </span>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'address', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'address', array('class' => 'span9 col-sm-12')); ?>
        <span class="help-inline">
            <?php echo $form->error($model, 'address'); ?>
        </span>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'zipcode', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'zipcode', array('class' => 'span9 col-sm-12')); ?>
        <span class="help-inline">
            <?php echo $form->error($model, 'zipcode'); ?>
        </span>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'time_zone', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'time_zone', ClaDateTime::getTimeZones(array('none' => true)), array('class' => 'span9 col-sm-12')); ?>
        <span class="help-inline">
            <?php echo $form->error($model, 'time_zone'); ?>
        </span>
    </div>
</div>

<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'google_analytics', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'google_analytics', array('class' => 'span9 col-sm-12')); ?>
        <span class="help-inline">
            <?php echo $form->error($model, 'google_analytics'); ?>
        </span>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'post_end_script', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'post_end_script', array('class' => 'span9 col-sm-12')); ?>
        <span class="help-inline">
            <?php echo $form->error($model, 'post_end_script'); ?>
        </span>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'app_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'app_id', array('class' => 'span9 col-sm-12')); ?>
        <span class="help-inline">
            <?php echo $form->error($model, 'app_id'); ?>
        </span>
    </div>
</div>
<?php if ($model->app_id) { ?>
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'fb_admins_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->textField($model, 'fb_admins_id', array('class' => 'span9 col-sm-12')); ?>
            <span class="help-inline">
                (Các tài khoản cách nhau bởi dấu ",")
                <?php echo $form->error($model, 'fb_admins_id'); ?>
            </span>
        </div>
    </div>
<?php } ?>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'dealers_discount', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'dealers_discount', array('class' => 'span9 col-sm-12')); ?>
        <span class="help-inline">
            <?php echo $form->error($model, 'dealers_discount'); ?>
        </span>
    </div>
</div>
<?php if (ClaUser::isSupperAdmin()) {
    ?>
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'percent_vat', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->textField($model, 'percent_vat', array('class' => 'span9 col-sm-12')); ?>
            <span class="help-inline">
                <?php echo $form->error($model, 'percent_vat'); ?>
            </span>
        </div>
    </div>
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'related_products_module', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->checkbox($model, 'related_products_module', array('class' => 'span10 col-sm-1')); ?>
            <span class="help-inline">
                <?php echo $form->error($model, 'related_products_module'); ?>
            </span>
        </div>
    </div>
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'products_360_module', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->checkbox($model, 'products_360_module', array('class' => 'span10 col-sm-1')); ?>
            <span class="help-inline">
                <?php echo $form->error($model, 'products_360_module'); ?>
            </span>
        </div>
    </div>
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'multi_store', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->checkbox($model, 'multi_store', array('class' => 'span10 col-sm-1')); ?>
            <span class="help-inline">
                <?php echo $form->error($model, 'multi_store'); ?>
            </span>
        </div>
    </div>
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'sim_store', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->checkbox($model, 'sim_store', array('class' => 'span10 col-sm-1')); ?>
            <span class="help-inline">
                <?php echo $form->error($model, 'sim_store'); ?>
            </span>
        </div>
    </div>
    <?php
    $options_store = array('' => 'Chọn cửa hàng mặc định');
    $options_store += array_column($shop_store, 'name', 'id');
    ?>
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'store_default', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->dropDownList($model, 'store_default', $options_store, array('class' => 'span10 col-sm-5')); ?>
            <span class="help-inline">
                <?php echo $form->error($model, 'store_default'); ?>
            </span>
        </div>
    </div>
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'type_service', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->dropDownList($model, 'type_service', SiteSettings::arrayTypeService(), array('class' => 'span10 col-sm-5')); ?>
            <span class="help-inline">
                <?php echo $form->error($model, 'type_service'); ?>
            </span>
        </div>
    </div>
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'map_api_key', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->textField($model, 'map_api_key', array('class' => 'span10 col-sm-12')); ?>
            <span class="help-inline">
                <?php echo $form->error($model, 'map_api_key'); ?>
            </span>
        </div>
    </div>
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'secret_key', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->textField($model, 'secret_key', array('class' => 'span10 col-sm-12')); ?>
            <span class="help-inline">
                <?php echo $form->error($model, 'secret_key'); ?>
            </span>
        </div>
    </div>
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'load_main_css', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->checkbox($model, 'load_main_css', array('class' => 'span10 col-sm-1')); ?>
            <span class="help-inline">
                <?php echo $form->error($model, 'load_main_css'); ?>
            </span>
        </div>
    </div>
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'show_adsnano', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->checkbox($model, 'show_adsnano', array('class' => 'span10 col-sm-1')); ?>
            <span class="help-inline">
                <?php echo $form->error($model, 'show_adsnano'); ?>
            </span>
        </div>
    </div>
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'enable_snow', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->checkbox($model, 'enable_snow', array('class' => 'span10 col-sm-1')); ?>
            <span class="help-inline">
                <?php echo $form->error($model, 'enable_snow'); ?>
            </span>
        </div>
    </div>
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'product_highlights', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->checkbox($model, 'product_highlights', array('class' => 'span10 col-sm-1')); ?>
            <span class="help-inline">
                <?php echo $form->error($model, 'product_highlights'); ?>
            </span>
        </div>
    </div>
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'wholesale', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->checkbox($model, 'wholesale', array('class' => 'span10 col-sm-1')); ?>
            <span class="help-inline">
                <?php echo $form->error($model, 'wholesale'); ?>
            </span>
        </div>
    </div>
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'load_new_url', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->checkbox($model, 'load_new_url', array('class' => 'span10 col-sm-1')); ?>
            <span class="help-inline">
                <?php echo $form->error($model, 'load_new_url'); ?>
            </span>
        </div>
    </div>
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'use_shoppingcart_set', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->checkbox($model, 'use_shoppingcart_set', array('class' => 'span10 col-sm-1')); ?>
            <span class="help-inline">
                <?php echo $form->error($model, 'use_shoppingcart_set'); ?>
            </span>
        </div>
    </div>
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'search_exact', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->checkbox($model, 'search_exact', array('class' => 'span10 col-sm-1')); ?>
            <span class="help-inline">
                <?php echo $form->error($model, 'search_exact'); ?>
            </span>
        </div>
    </div>
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'config_mail_send', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->checkbox($model, 'config_mail_send', array('class' => 'span10 col-sm-1')); ?>
            <span class="help-inline">
                <?php echo $form->error($model, 'config_mail_send'); ?>
            </span>
        </div>
    </div>
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'news_in_multi_cat', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->checkbox($model, 'news_in_multi_cat', array('class' => 'span10 col-sm-1')); ?>
            <span class="help-inline">
                <?php echo $form->error($model, 'news_in_multi_cat'); ?>
            </span>
        </div>
    </div>
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'fake_access', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->textField($model, 'fake_access', array('class' => 'span9 col-sm-12')); ?>
            <span class="help-inline">
                <?php echo $form->error($model, 'fake_access'); ?>
            </span>
        </div>
    </div>
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'currency', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->dropDownList($model, 'currency', array('' => '') + Product::$_dataCurrency, array('class' => 'span9 col-sm-12')); ?>
            <span class="help-inline">
                <?php echo $form->error($model, 'currency'); ?>
            </span>
        </div>
    </div>
<?php } ?>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'day_send_sms_jobs', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'day_send_sms_jobs', array('class' => 'span9 col-sm-12')); ?>
        <span class="help-inline">
            <?php echo $form->error($model, 'day_send_sms_jobs'); ?>
        </span>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'iframe_map', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'iframe_map', array('class' => 'span9 col-sm-12')); ?>
        <span class="help-inline">
            <?php echo $form->error($model, 'iframe_map'); ?>
        </span>
    </div>
</div>
<div class="control-group form-group buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'update') : Yii::t('common', 'update'), array('class' => 'btn btn-info')); ?>
</div>


<script type="text/javascript">
    jQuery(function ($) {
        jQuery('#siteavatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/setting/setting/uploadfileavatar"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#SiteSettings_avatar').val(obj.data.avatar);
                        if (jQuery('#siteavatar_img img').attr('src')) {
                            jQuery('#siteavatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#siteavatar_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#siteavatar_img').css({"margin-right": "10px"});
                    }
                } else {
                    if (obj.message)
                        alert(obj.message);
                }

            }
        });
    });
</script>