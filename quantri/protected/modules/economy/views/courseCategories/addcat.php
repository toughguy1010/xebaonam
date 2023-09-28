<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/category/category.css");
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<div class="widget widget-box">
    <div class="widget-header"><h4>
            <?php echo Yii::app()->controller->action->id != "update" ? Yii::t('category', 'category_course_create') : Yii::t('category', 'category_course_update'); ?>
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
                    <?php if (!$model->isNewRecord) { ?>
                        <div class="control-group form-group">
                            <?php echo $form->labelEx($model, 'alias', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                            <div class="controls col-sm-10">
                                <?php echo $form->textField($model, 'alias', array('class' => 'span10 col-sm-12')); ?>
                                <?php echo $form->error($model, 'alias'); ?>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'cat_parent', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->dropDownList($model, 'cat_parent', $option, array('class' => 'span10 col-sm-4')); ?>
                            <?php echo $form->error($model, 'cat_parent'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'cat_description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textArea($model, 'cat_description', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'cat_description'); ?>
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
                        <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
                            <div id="coursecategoryravatar" style="display: block; margin-top: 0px;">
                                <div id="coursecategoryavatar_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">  
                                    <?php if ($model->image_path && $model->image_name) { ?>
                                        <img src="<?php echo ClaHost::getImageHost() . $model->image_path . 's100_100/' . $model->image_name; ?>" style="width: 100%;" />
                                    <?php } ?>
                                </div>
                                <div id="coursecategoryavatar_form" style="display: inline-block;">
                                    <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
                                </div>
                            </div>
                            <?php echo $form->error($model, 'avatar'); ?>
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
    jQuery(function ($) {
        jQuery('#coursecategoryavatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/economy/courseCategories/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#CourseCategories_avatar').val(obj.data.avatar);
                        if (jQuery('#coursecategoryavatar_img img').attr('src')) {
                            jQuery('#coursecategoryvatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#coursecategoryavatar_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#coursecategoryavatar_img').css({"margin-right": "10px"});
                    }
                }
            }
        });


    });
</script>
