<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js');
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'site-settings-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
        ));
        ?>

        <?php
        Yii::app()->clientScript->registerScript('sitesettings', "
    jQuery('#SiteIntroduceaudio_form').ajaxUpload({
        url : '" . Yii::app()->createUrl("/setting/setting/uploadaudio", array(Yii::app()->request->csrfTokenName => Yii::app()->request->getCsrfToken())) . "',
        name: 'file',
        onSubmit: function() {
        },
        onComplete: function(result) {
            var obj = $.parseJSON(result);
            if(obj.status == '200') {
                if(obj.data.realurl){
                   jQuery('#SiteSettings_audio').val(obj.data.audio);
                        if (jQuery('#SiteIntroduceaudio_img audio source').attr('src')) {
                            var audio = jQuery('#SiteIntroduceaudio_img audio');
                            jQuery('#SiteIntroduceaudio_img audio source').attr('src', obj.data.realurl);
                            audio[0].load();
                            audio[0].play();
                        } else {
                            jQuery('#SiteIntroduceaudio_img').append('<audio controls> <source src=\"' + obj.data.realurl + '\" type=\"audio/mpeg\"></audio>');
                        }
                        jQuery('#SiteIntroduceaudio_img').css({\"margin-right\": \"10px\"});
                }
            }
        }
    });

");
        ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'audio', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->hiddenField($model, 'audio', array('class' => 'span12 col-sm-12')); ?>
                <div style="clear: both;"></div>
                <div id="SiteIntroduceaudio" style="display: block; margin-top: 10px;">
                    <div id="SiteIntroduceaudio_img" style="display: inline-block; vertical-align: top; <?php if ($model->audio) echo 'margin-right: 10px;'; ?>">  
                        <?php if ($model->audio_path && $model->audio_name) { ?>
                            <audio controls>
                                <source src="<?php echo ClaHost::getImageHost() . $model->audio_path . $model->audio_name; ?>" type="audio/mpeg">
                            </audio>
                        <?php } ?>
                    </div>
                    <div id="SiteIntroduceaudio_form" style="display: inline-block;">
                        <?php echo CHtml::button(Yii::t('setting', 'btn_select_audio'), array('class' => 'btn  btn-sm')); ?>
                    </div>
                </div>
                <?php echo $form->error($model, 'audio'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($options, 'autoPlay', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <label>
                    <?php echo $form->checkBox($options, 'autoPlay', array('class' => 'ace ace-switch ace-switch-6')); ?>
                    <span class="lbl"></span>
                </label>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($options, 'repeat', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <label>
                    <?php echo $form->checkBox($options, 'repeat', array('class' => 'ace ace-switch ace-switch-6')); ?>
                    <span class="lbl"></span>
                </label>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($options, 'showControl', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <label>
                    <?php echo $form->checkBox($options, 'showControl', array('class' => 'ace ace-switch ace-switch-6')); ?>
                    <span class="lbl"></span>
                </label>
            </div>
        </div>
        <div class="control-group form-group buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'update') : Yii::t('common', 'update'), array('class' => 'btn btn-info')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>