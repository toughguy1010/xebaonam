<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        CKEDITOR.replace("Promotions_description", {
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
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'category_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'category_id', $option_category, array('class' => 'span10 col-sm-12')); ?>
        <?php echo $form->error($model, 'category_id'); ?>
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
    <?php echo $form->labelEx($model, 'sortdesc', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'sortdesc', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'sortdesc'); ?>
    </div>
</div>
<div class=" form-group no-margin-left">
    <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
        <div id="promotionavatar" style="display: block; margin-top: 0px;">
            <div id="promotionavatar_img"
                 style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">
                <?php if ($model->image_path && $model->image_name) { ?>
                    <img
                        src="<?php echo ClaHost::getImageHost() . $model->image_path . 's100_100/' . $model->image_name; ?>"
                        style="width: 100%;"/>
                <?php } ?>
            </div>
            <div id="promotionavatar_form" style="display: inline-block;">
                <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'avatar'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'description', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'description'); ?>
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
    <?php echo $form->labelEx($model, 'ishot', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->checkBox($model, 'ishot'); ?>
        <?php echo $form->error($model, 'ishot'); ?>
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
    <?php echo $form->labelEx($model, 'applydate', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <div class="row">
            <div class="controls col-sm-6">
                <?php echo $form->labelEx($model, 'startdate', array('class' => 'col-sm-3 control-label no-padding-left')); ?>
                <div class="input-group input-group-sm">
                    <?php
                    $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                        'model' => $model, //Model object
                        'name' => 'Promotions[startdate]', //attribute name
                        'mode' => 'datetime',
                        'value' => ((int) $model->startdate > 0 ) ? date('d-m-Y H:i:s', (int) $model->startdate) : '',
                        'language' => Yii::app()->language,
                        'options' => array(
                            'showSecond' => true,
                            'dateFormat' => 'dd-mm-yy',
                            'timeFormat' => 'HH:mm:ss',
                            'controlType' => 'select',
                            //'showOn' => 'button',
                            'tabularLevel' => null,
                            'addSliderAccess' => true,
                            'sliderAccessArgs' => array('touchonly' => false),
                        ), // jquery plugin options
                        'htmlOptions' => array(
                            'class' => 'form-control',
                        )
                    ));
                    ?>
                    <span class="input-group-addon">
                        <i class="icon-calendar"></i>
                    </span>
                </div>
                <?php echo $form->error($model, 'startdate'); ?>
            </div>
            <div class="controls col-sm-6">
                <?php echo $form->labelEx($model, 'enddate', array('class' => 'col-sm-3 control-label no-padding-left', 'style' => 'text-align:right;')); ?>
                <div class="input-group input-group-sm">
                    <?php
                    $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                        'model' => $model, //Model object
                        'name' => 'Promotions[enddate]', //attribute name
                        'mode' => 'datetime',
                        'value' => ((int) $model->enddate > 0 ) ? date('d-m-Y H:i:s', (int) $model->enddate) : '',
                        'language' => Yii::app()->language,
                        'options' => array(
                            'showSecond' => true,
                            'dateFormat' => 'dd-mm-yy',
                            'timeFormat' => 'HH:mm:ss',
                            'controlType' => 'select',
                            //'showOn' => 'button',
                            'tabularLevel' => null,
                            'addSliderAccess' => true,
                            'sliderAccessArgs' => array('touchonly' => false),
                        ), // jquery plugin options
                        'htmlOptions' => array(
                            'class' => 'form-control',
                        )
                    ));
                    ?>
                    <span class="input-group-addon">
                        <i class="icon-calendar"></i>
                    </span>
                </div>
                <?php echo $form->error($model, 'enddate'); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'applydate'); ?>
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
    <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('product', 'promotion_create') : Yii::t('product', 'promotion_update'), array('class' => 'btn btn-primary', 'id' => 'btnAddCate')); ?>
</div>
<script type="text/javascript">
    jQuery(function ($) {
        jQuery('#promotionavatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/economy/promotion/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#Promotions_avatar').val(obj.data.avatar);
                        if (jQuery('#promotionavatar_img img').attr('src')) {
                            jQuery('#promotionavatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#promotionavatar_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#promotionavatar_img').css({"margin-right": "10px"});
                    }
                }
            }
        });
    });
</script>