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
    <?php echo $form->labelEx($model, 'slogan', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'slogan', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'slogan'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
        <div id="BdsCompanyavatar" style="display: block; margin-top: 0px;">
            <div id="BdsCompanyavatar_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">  
                <?php if ($model->avatar_path && $model->avatar_name) { ?>
                    <img src="<?php echo ClaHost::getImageHost(), $model->avatar_path, 's100_100/', $model->avatar_name; ?>" style="width: 100%;" />
                <?php } ?>
            </div>
            <div id="BdsCompanyavatar_form" style="display: inline-block;">
                <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'avatar'); ?>
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
    <?php echo $form->labelEx($model, 'hotline', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'hotline', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'hotline'); ?>
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
    <?php echo $form->labelEx($model, 'address', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'address', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'address'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'short_description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'short_description', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'short_description'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArray(), array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>
</div>
<script type="text/javascript">
    jQuery(function ($) {
        jQuery('#BdsCompanyavatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/bds/bdsCompany/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#BdsCompany_avatar').val(obj.data.avatar);
                        if (jQuery('#BdsCompanyavatar_img img').attr('src')) {
                            jQuery('#BdsCompanyavatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#BdsCompanyavatar_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#BdsCompanyavatar_img').css({"margin-right": "10px"});
                    }
                }
            }
        });
    });
</script>
