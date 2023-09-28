<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/category/category.css");
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<div class="widget widget-box">
    <div class="widget-header"><h4>
            <?php echo Yii::app()->controller->action->id != "update" ? Yii::t('car', 'create') : Yii::t('car', 'update'); ?>
        </h4></div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'province-form',
                        'htmlOptions' => array('class' => 'form-horizontal'),
                        'enableAjaxValidation' => false,
                    ));
                    ?>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($province, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($province, 'name', array('class' => 'span10 col-sm-12', 'readonly' => true)); ?>
                            <?php echo $form->error($province, 'name'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($province, 'type', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($province, 'type', array('class' => 'span10 col-sm-12', 'readonly' => true)); ?>
                            <?php echo $form->error($province, 'type'); ?>
                        </div>
                    </div>
                    
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($province_info, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->dropDownList($province_info, 'status', ActiveRecord::statusArray(), array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($province_info, 'status'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($province_info, 'showinhome', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->checkBox($province_info, 'showinhome'); ?>
                            <?php echo $form->error($province_info, 'showinhome'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($province_info, 'position', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($province_info, 'position', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($province_info, 'position'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($province_info, 'description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textArea($province_info, 'description', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($province_info, 'description'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($province_info, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->hiddenField($province_info, 'avatar', array('class' => 'span12 col-sm-12')); ?>
                            <div id="tourprovinceavatar" style="display: block; margin-top: 0px;">
                                <div id="tourprovinceavatar_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($province_info->avatar) echo 'margin-right: 10px;'; ?>">  
                                    <?php if ($province_info->image_path && $province_info->image_name) { ?>
                                        <img src="<?php echo ClaHost::getImageHost(), $province_info->image_path, 's100_100/', $province_info->image_name; ?>" style="width: 100%;" />
                                    <?php } ?>
                                </div>
                                <div id="tourprovinceavatar_form" style="display: inline-block;">
                                    <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
                                </div>
                            </div>
                            <?php echo $form->error($province_info, 'avatar'); ?>
                        </div>
                    </div>
                    
                    <div class="control-group form-group buttons">
                        <?php echo CHtml::submitButton(Yii::t('common', 'save'), array('class' => 'btn btn-primary', 'id' => 'btnAddCate')); ?>
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
    jQuery(function ($) {
        jQuery('#tourprovinceavatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/tour/province/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#TourProvinceInfo_avatar').val(obj.data.avatar);
                        if (jQuery('#tourprovinceavatar_img img').attr('src')) {
                            jQuery('#tourprovincevatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#tourprovinceavatar_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#tourprovinceavatar_img').css({"margin-right": "10px"});
                    }
                }
            }
        });


    });
</script>
