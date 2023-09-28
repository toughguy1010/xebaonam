<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/category/category.css");
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
<script type="text/javascript">
    var ta = true;
    jQuery(document).ready(function () {
        //
        CKEDITOR.replace("HpDoctor_description", {
            height: 200,
            language: '<?php echo Yii::app()->language ?>'
        });
    });
    jQuery(function ($) {
    });
</script>
<div class="widget widget-box">
    <div class="widget-header"><h4>
            <?php echo Yii::app()->controller->action->id != "update" ? Yii::t('hospital', 'create') : Yii::t('hospital', 'update'); ?>
        </h4></div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'language-form',
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
                        <?php echo $form->labelEx($model, 'position', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'position', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'position'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'education', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->dropDownList($model, 'education', HpEducation::optionEducation(), array('class' => 'span12 col-sm-12')); ?>
                            <?php echo $form->error($model, 'education'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'faculty_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->dropDownList($model, 'faculty_id', HpFaculty::optionFaculty(), array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'faculty_id'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->label($model, 'language', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php
                            $selectedLanguage = array();
                            if (!$model->isNewRecord) {
                                $languages = $model->getLanguagesDoctor();
                                foreach ($languages as $key => $language)
                                    $selectedLanguage[$key] = array('selected' => 'selected');
                            }

                            $this->widget('common.extensions.echosen.Chosen', array(
                                'model' => $model,
                                'attribute' => 'language',
                                'multiple' => true,
                                'data' => HpLanguage::getLanguageArr(),
                                'value' => $model->language,
                                'htmlOptions' => array(
                                    'class' => 'span12 col-sm-12',
                                    'options' => $selectedLanguage,
                                ),
                            ));
                            ?>
                            <?php echo $form->error($model, 'language'); ?>
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
                                'name' => 'HpDoctor[bod]', //attribute name
                                'mode' => 'date', //use "time","date" or "datetime" (default)
                                'value' => ((int) $model->bod > 0 ) ? date('d-m-Y', (int) $model->bod) : '',
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
                            <div id="hpDoctoravatar" style="display: block; margin-top: 0px;">
                                <div id="hpDoctoravatar_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">  
                                    <?php if ($model->avatar_path && $model->avatar_name) { ?>
                                        <img src="<?php echo ClaHost::getImageHost() . $model->avatar_path . 's100_100/' . $model->avatar_name; ?>" style="width: 100%;" />
                                    <?php } ?>
                                </div>
                                <div id="hpDoctoravatar_form" style="display: inline-block;">
                                    <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
                                </div>
                            </div>
                            <?php echo $form->error($model, 'avatar'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textArea($model, 'description', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'description'); ?>
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
                        <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArray(), array('class' => 'span12 col-sm-12')); ?>
                            <?php echo $form->error($model, 'status'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group buttons">
                        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('hospital', 'create') : Yii::t('hospital', 'update'), array('class' => 'btn btn-primary', 'id' => 'btnAddCate')); ?>
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
        jQuery('#hpDoctoravatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/hospital/hpDoctor/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#HpDoctor_avatar').val(obj.data.avatar);
                        if (jQuery('#hpDoctoravatar_img img').attr('src')) {
                            jQuery('#hpDoctoravatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#hpDoctoravatar_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#hpDoctoravatar_img').css({"margin-right": "10px"});
                    }
                }
            }
        });


    });
</script>
