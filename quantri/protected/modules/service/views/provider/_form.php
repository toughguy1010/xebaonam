<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
<script type="text/javascript">
    jQuery(function ($) {
        jQuery('#newsavatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/service/provider/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#SeProviders_avatar').val(obj.data.avatar);
                        if (jQuery('#newsavatar_img img').attr('src')) {
                            jQuery('#newsavatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#newsavatar_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#newsavatar_img').css({"margin-right": "10px"});
                    }
                } else {
                    if (obj.message)
                        alert(obj.message);
                }

            }
        });

        CKEDITOR.replace("SeProvidersInfo_description", {
            height: 200,
            language: '<?php echo Yii::app()->language ?>'
        });
    });</script>
<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'news-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
        ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'name', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'position', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'position', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'position'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'position_highest', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'position_highest', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'position_highest'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'email', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'email', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'email'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'education', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'education', SeEducation::optionEducation(), array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'education'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'faculty_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'faculty_id', SeFaculty::optionFaculty(), array('class' => 'span10 col-sm-12')); ?>
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
                    'data' => SeLanguage::getLanguageArr(),
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
            <?php echo $form->labelEx($model, 'alias', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'alias', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'alias'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'phone', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'phone', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'phone'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'address', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'address', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'address'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
                <div style="clear: both;"></div>
                <div id="newsavatar" style="display: block; margin-top: 10px;">
                    <div id="newsavatar_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">  
                        <?php if ($model->avatar_path && $model->avatar_name) { ?>
                            <img src="<?php echo ClaHost::getImageHost() . $model->avatar_path . 's100_100/' . $model->avatar_name; ?>" style="width: 100%;" />
                        <?php } ?>
                    </div>
                    <div id="newsavatar_form" style="display: inline-block;">
                        <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
                    </div>
                    <?php if ($model->avatar_path && $model->avatar_name) { ?>
                        <div style="margin-top: 15px;">
                            <button type="button" onclick="removeAvatar(<?= $model->id ?>)" class="btn btn-danger btn-xs">Delete avatar</button>
                        </div>
                    <?php } ?>
                </div>
                <?php echo $form->error($model, 'avatar'); ?>
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
                <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArrayNews(), array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'status'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($providerInfo, 'description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($providerInfo, 'description', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($providerInfo, 'description'); ?>
            </div>
        </div>
        <div class="control-group form-group buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('service', 'provider_create') : Yii::t('service', 'provider_edit'), array('class' => 'btn btn-info', 'id' => 'savenews')); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>

<script type="text/javascript">
    function removeAvatar(id) {
        if (confirm("Are you sure delete avatar?")) {
            $.getJSON(
                    '<?php echo Yii::app()->createUrl('service/provider/deleteAvatar') ?>',
                    {id: id},
                    function (data) {
                        if (data.code == 200) {
                            $('#newsavatar_img img').remove();
                        }
                    }
            );
        }
    }
</script>