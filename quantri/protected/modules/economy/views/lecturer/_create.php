<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/category/category.css");
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        CKEDITOR.replace("Lecturer_description", {
            height: 400,
            language: '<?php echo Yii::app()->language ?>'
        });
    });
</script>
<div class="widget widget-box">
    <div class="widget-header"><h4>
            <?php echo Yii::app()->controller->action->id != "update" ? Yii::t('course', 'lecturer_add_new') : Yii::t('course', 'lecturer_update'); ?>
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
                        <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'name', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'name'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArray(), array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'status'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'gender', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->dropDownList($model, 'gender', ActiveRecord::genderArray(), array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'gender'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'bod', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php
                            $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                                'model' => $model, //Model object
                                'name' => 'Lecturer[bod]', //attribute name
                                'mode' => 'date', //use "time","date" or "datetime" (default)
                                'value' => ((int) $model->bod > 0 ) ? date('d-m-Y', (int) $model->bod) : date('d-m-Y'),
                                'language' => 'vi',
                                'options' => array(
                                    'showSecond' => true,
                                    'dateFormat' => 'dd-mm-yy',
                                    'controlType' => 'select',
                                    'stepHour' => 1,
                                    'stepMinute' => 1,
                                    'stepSecond' => 1,
                                    //'showOn' => 'button',
                                    'showSecond' => true,
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                    'tabularLevel' => null,
                                //'addSliderAccess' => true,
                                //'sliderAccessArgs' => array('touchonly' => false),
                                ), // jquery plugin options
                                'htmlOptions' => array(
                                    'class' => 'span12 col-sm-12',
                                )
                            ));
                            ?>
                            <?php echo $form->error($model, 'bod'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
                            <div id="lectureravatar" style="display: block; margin-top: 0px;">
                                <div id="lectureravatar_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">  
                                    <?php if ($model->avatar_path && $model->avatar_name) { ?>
                                        <img src="<?php echo ClaHost::getImageHost() . $model->avatar_path . 's100_100/' . $model->avatar_name; ?>" style="width: 100%;" />
                                    <?php } ?>
                                </div>
                                <div id="lectureravatar_form" style="display: inline-block;">
                                    <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
                                </div>
                            </div>
                            <?php echo $form->error($model, 'avatar'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'subject', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'subject', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'subject'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'experience', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->dropDownList($model, 'experience', array(range(1, 100)), array('class' => 'span10 col-sm-1')); ?>
                            <label class="col-sm-2 control-label no-padding-left"><i>&nbsp; (năm kinh nghiệm)</i></label>
                            <?php echo $form->error($model, 'experience'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'level_of_education', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'level_of_education', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'level_of_education'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'add', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'add', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'add'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'phone', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'phone', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'phone'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'facebook', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'facebook', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'facebook'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'email', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'email', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'email'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'job_title', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'job_title', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'job_title'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'company', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'company', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'company'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'order', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'order', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'order'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'sort_description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <div class="span12">
                                <?php echo $form->textArea($model, 'sort_description', array('class' => 'span12 col-sm-12')); ?>
                                <?php echo $form->error($model, 'sort_description'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <div class="span12">
                                <?php echo $form->textArea($model, 'description', array('class' => 'span12 col-sm-12')); ?>
                                <?php echo $form->error($model, 'description'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="control-group form-group buttons">
                        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'save') : Yii::t('common', 'save'), array('class' => 'btn btn-primary', 'id' => 'btnAddCate')); ?>
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
        jQuery('#lectureravatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/economy/lecturer/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#Lecturer_avatar').val(obj.data.avatar);
                        if (jQuery('#lectureravatar_img img').attr('src')) {
                            jQuery('#lectureravatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#lectureravatar_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#lectureravatar_img').css({"margin-right": "10px"});
                    }
                }
            }
        });


    });
</script>
